<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
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
            // Lấy thời gian hiện tại theo múi giờ Việt Nam
            $timestamp = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            
            // Lưu tin nhắn vào database với timestamp cụ thể
            $sql = "INSERT INTO messages (sender_type, sender_id, receiver_type, receiver_id, content, timestamp) 
                    VALUES (?, ?, ?, ?, ?, ?) RETURNING message_id";
            $result = DB::select($sql, [$senderType, $senderId, $receiverType, $receiverId, $content, $timestamp]);
            
            $messageId = $result[0]->message_id;
            
            return $messageId;
        } catch (\Exception $e) {
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
            $sql = "SELECT COUNT(*) as count FROM messages 
                   WHERE receiver_type = ? AND receiver_id = ? 
                   AND is_read = false";
            
            $result = DB::select($sql, [$receiverType, $receiverId]);
            return $result[0]->count;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Đánh dấu tin nhắn là đã đọc
     */
    public static function markMessagesAsRead($senderType, $senderId, $receiverType, $receiverId)
    {
        try {
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
     * Lấy danh sách người đã chat
     */
    public static function getChatPartners($userType, $userId)
    {
        try {
            $sql = "SELECT DISTINCT 
                        CASE 
                            WHEN sender_type = ? AND sender_id = ? THEN 
                                json_build_object(
                                    'type', receiver_type,
                                    'id', receiver_id,
                                    'email', (SELECT CASE 
                                        WHEN receiver_type = 'admin' THEN email_a 
                                        ELSE email 
                                    END 
                                    FROM (
                                        SELECT email FROM customer WHERE id_c = receiver_id AND receiver_type = 'customer'
                                        UNION ALL
                                        SELECT email FROM teacher WHERE id_t = receiver_id AND receiver_type = 'teacher'
                                        UNION ALL
                                        SELECT email FROM staff WHERE id_s = receiver_id AND receiver_type = 'staff'
                                        UNION ALL
                                        SELECT email_a FROM admin WHERE id_a = receiver_id AND receiver_type = 'admin'
                                    ) AS user_emails LIMIT 1)
                                )
                            ELSE 
                                json_build_object(
                                    'type', sender_type,
                                    'id', sender_id,
                                    'email', (SELECT CASE 
                                        WHEN sender_type = 'admin' THEN email_a 
                                        ELSE email 
                                    END 
                                    FROM (
                                        SELECT email FROM customer WHERE id_c = sender_id AND sender_type = 'customer'
                                        UNION ALL
                                        SELECT email FROM teacher WHERE id_t = sender_id AND sender_type = 'teacher'
                                        UNION ALL
                                        SELECT email FROM staff WHERE id_s = sender_id AND sender_type = 'staff'
                                        UNION ALL
                                        SELECT email_a FROM admin WHERE id_a = sender_id AND sender_type = 'admin'
                                    ) AS user_emails LIMIT 1)
                                )
                        END as partner,
                        MAX(timestamp) as last_message_time,
                        (SELECT content 
                         FROM messages m2 
                         WHERE m2.timestamp = MAX(m1.timestamp)
                         AND ((m2.sender_type = ? AND m2.sender_id = ?) 
                              OR (m2.receiver_type = ? AND m2.receiver_id = ?))
                         LIMIT 1) as last_message
                    FROM messages m1
                    WHERE (sender_type = ? AND sender_id = ?) 
                       OR (receiver_type = ? AND receiver_id = ?)
                    GROUP BY 
                        CASE 
                            WHEN sender_type = ? AND sender_id = ? THEN receiver_type 
                            ELSE sender_type 
                        END,
                        CASE 
                            WHEN sender_type = ? AND sender_id = ? THEN receiver_id 
                            ELSE sender_id 
                        END
                    ORDER BY last_message_time DESC";

            $params = array_fill(0, 14, null);
            for ($i = 0; $i < 14; $i += 2) {
                $params[$i] = $userType;
                $params[$i + 1] = $userId;
            }

            return DB::select($sql, $params);
        } catch (\Exception $e) {
            return [];
        }
    }
}
