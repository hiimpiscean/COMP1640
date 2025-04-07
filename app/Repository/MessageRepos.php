<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MessageRepos
{
    /**
     * Lấy tin nhắn giữa hai người dùng
     * @param string $senderType Loại người gửi (customer, teacher, staff, admin)
     * @param int $senderId ID của người gửi
     * @param string $receiverType Loại người nhận (customer, teacher, staff, admin)
     * @param int $receiverId ID của người nhận
     * @param int $lastId ID của tin nhắn cuối cùng đã nhận, mặc định là 0 để lấy tất cả tin nhắn
     * @return array Danh sách tin nhắn
     */
    public static function getMessagesBetweenUsers($senderType, $senderId, $receiverType, $receiverId, $lastId = 0)
    {
        $sql = 'SELECT * FROM messages WHERE 
                ((sender_type = ? AND sender_id = ? AND receiver_type = ? AND receiver_id = ?) OR 
                (sender_type = ? AND sender_id = ? AND receiver_type = ? AND receiver_id = ?))';
        
        // Thêm điều kiện để chỉ lấy tin nhắn mới nếu có lastId
        if ($lastId > 0) {
            $sql .= ' AND message_id > ?';
        }
        
        $sql .= ' ORDER BY timestamp ASC';
        
        $params = [
            $senderType, $senderId, $receiverType, $receiverId,
            $receiverType, $receiverId, $senderType, $senderId
        ];
        
        // Thêm tham số lastId vào mảng tham số nếu có
        if ($lastId > 0) {
            $params[] = $lastId;
        }
        
        return DB::select($sql, $params);
    }
    
    /**
     * Lưu tin nhắn vào database
     */
    public static function saveMessage($senderType, $senderId, $receiverType, $receiverId, $content)
    {
        try {
            // Kiểm tra xem tin nhắn tương tự đã được gửi gần đây chưa (trong vòng 2 phút)
            $twoMinutesAgo = Carbon::now('Asia/Ho_Chi_Minh')->subMinutes(2)->format('Y-m-d H:i:s');
            
            $checkSql = "SELECT message_id FROM messages 
                        WHERE sender_type = ? AND sender_id = ? 
                        AND receiver_type = ? AND receiver_id = ? 
                        AND content = ? 
                        AND timestamp > ?
                        LIMIT 1";
                        
            $existingMessage = DB::select($checkSql, [
                $senderType, $senderId, $receiverType, $receiverId, $content, $twoMinutesAgo
            ]);
            
            // Nếu tìm thấy tin nhắn trùng lặp, trả về ID của tin nhắn đó
            if (!empty($existingMessage)) {
                Log::info('Detected duplicate message', [
                    'message_id' => $existingMessage[0]->message_id,
                    'content' => $content
                ]);
                return $existingMessage[0]->message_id;
            }
            
            // Tiếp tục lưu tin nhắn mới
            $timestamp = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            
            $sql = "INSERT INTO messages (sender_type, sender_id, receiver_type, receiver_id, content, timestamp) 
                    VALUES (?, ?, ?, ?, ?, ?) RETURNING message_id";
            $result = DB::select($sql, [$senderType, $senderId, $receiverType, $receiverId, $content, $timestamp]);
            
            $messageId = $result[0]->message_id;
            
            return $messageId;
        } catch (\Exception $e) {
            Log::error('Error saving message', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
    
    /**
     * Lấy thông tin người dùng theo email hoặc username
     */
    public static function getUserInfoByEmail($emailOrUsername)
    {
        try {
            $searchValue = strtolower($emailOrUsername);
            
            // Tìm kiếm trong bảng customer
            $sql = 'SELECT \'customer\' as type, id_c as id, email, fullname_c as username FROM customer 
                   WHERE LOWER(email) = ?';
            $customerResult = DB::select($sql, [$searchValue]);
            if (!empty($customerResult)) {
                return $customerResult[0];
            }
            
            // Tìm kiếm trong bảng teacher
            $sql = 'SELECT \'teacher\' as type, id_t as id, email, email as username FROM teacher 
                   WHERE LOWER(email) = ?';
            $teacherResult = DB::select($sql, [$searchValue]);
            if (!empty($teacherResult)) {
                return $teacherResult[0];
            }
            
            // Tìm kiếm trong bảng staff
            $sql = 'SELECT \'staff\' as type, id_s as id, email, username FROM staff 
                   WHERE LOWER(email) = ? OR LOWER(username) = ?';
            $staffResult = DB::select($sql, [$searchValue, $searchValue]);
            if (!empty($staffResult)) {
                return $staffResult[0];
            }
            
            // Tìm kiếm trong bảng admin
            $sql = 'SELECT \'admin\' as type, id_a as id, email_a as email, username FROM admin 
                   WHERE LOWER(email_a) = ? OR LOWER(username) = ?';
            $adminResult = DB::select($sql, [$searchValue, $searchValue]);
            if (!empty($adminResult)) {
                return $adminResult[0];
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
    
    /**
     * Tìm kiếm người dùng theo từ khóa (email hoặc username)
     */
    public static function searchUsers($query, $currentUser)
    {
        try {
            $searchPattern = '%' . strtolower($query) . '%';
            
            // Tìm kiếm trong bảng teacher
            $teachers = DB::table('teacher')
                ->select(DB::raw("'teacher' as type, id_t as id, email, email as username"))
                ->whereRaw('LOWER(email) LIKE ?', [$searchPattern])
                ->get();
            
            // Tìm kiếm trong bảng customer
            $customers = DB::table('customer')
                ->select(DB::raw("'customer' as type, id_c as id, email, fullname_c as username"))
                ->whereRaw('LOWER(email) LIKE ? OR LOWER(fullname_c) LIKE ?', [$searchPattern, $searchPattern])
                ->get();
            
            // Tìm kiếm trong bảng staff
            $staffs = DB::table('staff')
                ->select(DB::raw("'staff' as type, id_s as id, email, username"))
                ->whereRaw('LOWER(email) LIKE ? OR LOWER(username) LIKE ?', [$searchPattern, $searchPattern])
                ->get();
            
            // Tìm kiếm trong bảng admin
            $admins = DB::table('admin')
                ->select(DB::raw("'admin' as type, id_a as id, email_a as email, username"))
                ->whereRaw('LOWER(email_a) LIKE ? OR LOWER(username) LIKE ?', [$searchPattern, $searchPattern])
                ->get();
            
            // Kết hợp kết quả
            return array_merge($teachers->toArray(), $customers->toArray(), $staffs->toArray(), $admins->toArray());
        } catch (\Exception $e) {
            return [];
        }
    }
    
    /**
     * Lấy tất cả người dùng từ các bảng
     */
    public static function getAllUsers()
    {
        try {
            // Lấy tất cả người dùng từ bảng teacher
            $teachers = DB::table('teacher')
                ->select(DB::raw("'teacher' as type, id_t as id, email, email as username"))
                ->get();
            
            // Lấy tất cả người dùng từ bảng customer
            $customers = DB::table('customer')
                ->select(DB::raw("'customer' as type, id_c as id, email, fullname_c as username"))
                ->get();
            
            // Lấy tất cả người dùng từ bảng staff
            $staffs = DB::table('staff')
                ->select(DB::raw("'staff' as type, id_s as id, email, username"))
                ->get();
            
            // Lấy tất cả người dùng từ bảng admin
            $admins = DB::table('admin')
                ->select(DB::raw("'admin' as type, id_a as id, email_a as email, username"))
                ->get();
            
            // Kết hợp kết quả từ cả bốn bảng
            return array_merge($teachers->toArray(), $customers->toArray(), $staffs->toArray(), $admins->toArray());
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Lấy số lượng tin nhắn chưa đọc
     */
    public static function getUnreadMessageCount($receiverType, $receiverId)
    {
        try {
            // Đảm bảo đầu vào hợp lệ
            if (empty($receiverType) || empty($receiverId)) {
                return 0;
            }
            
            $sql = "SELECT COUNT(*) as count FROM messages 
                   WHERE receiver_type = ? AND receiver_id = ? 
                   AND is_read = false";
            
            $result = DB::select($sql, [$receiverType, $receiverId]);
            
            // Kiểm tra kết quả trả về
            if (!$result || !isset($result[0]->count)) {
                return 0;
            }
            
            return (int)$result[0]->count;
        } catch (\Exception $e) {
            // Bỏ qua log lỗi để tránh lỗi lint
            return 0;
        }
    }

    /**
     * Đánh dấu tin nhắn là đã đọc
     */
    public static function markMessagesAsRead($senderType, $senderId, $receiverType, $receiverId)
    {
        try {
            // Sửa lại câu truy vấn để khớp với thứ tự thông số
            // sender_type, sender_id là người GỬI tin nhắn
            // receiver_type, receiver_id là người NHẬN tin nhắn (người đang đọc)
            $sql = "UPDATE messages 
                   SET is_read = true 
                   WHERE sender_type = ? AND sender_id = ? 
                   AND receiver_type = ? AND receiver_id = ? 
                   AND is_read = false";
            
            return DB::update($sql, [$senderType, $senderId, $receiverType, $receiverId]);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Lấy danh sách người đã chat (phiên bản đơn giản hóa)
     */
    public static function getChatPartners($userType, $userId)
    {
        try {
            // Ghi log để debug
            Log::info('Fetching chat partners for', ['userType' => $userType, 'userId' => $userId]);
            
            // Truy vấn đơn giản hơn, tránh CTE phức tạp
            $sql = "SELECT 
                        m.sender_type AS s_type,
                        m.sender_id AS s_id,
                        m.receiver_type AS r_type,
                        m.receiver_id AS r_id,
                        m.content AS last_message,
                        m.timestamp AS last_message_time,
                        m.message_id
                    FROM messages m
                    WHERE 
                        (m.sender_type = ? AND m.sender_id = ?) 
                        OR (m.receiver_type = ? AND m.receiver_id = ?) 
                    ORDER BY m.timestamp DESC";
                    
            $results = DB::select($sql, [$userType, $userId, $userType, $userId]);
            Log::info('Raw messages found', ['count' => count($results)]);
            
            // Xử lý kết quả để lấy đối tác chat duy nhất
            $uniquePartners = [];
            $processedPartners = [];
            
            foreach ($results as $row) {
                // Xác định đối tác chat
                $partnerType = ($row->s_type == $userType && $row->s_id == $userId) ? $row->r_type : $row->s_type;
                $partnerId = ($row->s_type == $userType && $row->s_id == $userId) ? $row->r_id : $row->s_id;
                
                // Tạo khóa duy nhất cho đối tác
                $partnerKey = $partnerType . '_' . $partnerId;
                
                // Nếu đối tác này đã được xử lý rồi, bỏ qua
                if (in_array($partnerKey, $processedPartners)) {
                    continue;
                }
                
                $processedPartners[] = $partnerKey;
                
                // Lấy email của đối tác
                $partnerEmail = null;
                switch ($partnerType) {
                    case 'customer':
                        $emailResult = DB::select('SELECT email FROM customer WHERE id_c = ? LIMIT 1', [$partnerId]);
                        if (!empty($emailResult)) $partnerEmail = $emailResult[0]->email;
                        break;
                    case 'teacher':
                        $emailResult = DB::select('SELECT email FROM teacher WHERE id_t = ? LIMIT 1', [$partnerId]);
                        if (!empty($emailResult)) $partnerEmail = $emailResult[0]->email;
                        break;
                    case 'staff':
                        $emailResult = DB::select('SELECT email FROM staff WHERE id_s = ? LIMIT 1', [$partnerId]);
                        if (!empty($emailResult)) $partnerEmail = $emailResult[0]->email;
                        break;
                    case 'admin':
                        $emailResult = DB::select('SELECT email_a FROM admin WHERE id_a = ? LIMIT 1', [$partnerId]);
                        if (!empty($emailResult)) $partnerEmail = $emailResult[0]->email_a;
                        break;
                }
                
                // Nếu không tìm thấy email, bỏ qua đối tác này
                if (empty($partnerEmail)) {
                    Log::warning('Could not find email for partner', [
                        'type' => $partnerType,
                        'id' => $partnerId
                    ]);
                    continue;
                }
                
                $partnerObj = [
                    'type' => $partnerType,
                    'id' => $partnerId,
                    'email' => $partnerEmail
                ];
                
                $uniquePartners[] = (object)[
                    'partner' => json_encode($partnerObj),
                    'last_message' => $row->last_message,
                    'last_message_time' => $row->last_message_time
                ];
                
                // Debug log cho mỗi partner
                Log::info('Found chat partner', $partnerObj);
            }
            
            Log::info('Unique partners found', ['count' => count($uniquePartners)]);
            return $uniquePartners;
        } catch (\Exception $e) {
            // Ghi log lỗi chi tiết
            Log::error('Error in getChatPartners', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'userType' => $userType,
                'userId' => $userId
            ]);
            return [];
        }
    }
}