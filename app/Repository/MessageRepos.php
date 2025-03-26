<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageRepos
{
    /**
     * Lấy tin nhắn giữa hai người dùng
     */
    public static function getMessagesBetweenUsers($senderType, $senderId, $receiverType, $receiverId)
    {
        $sql = 'SELECT * FROM messages WHERE 
                ((sender_type = ? AND sender_id = ? AND receiver_type = ? AND receiver_id = ?) OR 
                (sender_type = ? AND sender_id = ? AND receiver_type = ? AND receiver_id = ?))
                ORDER BY timestamp ASC';
        
        return DB::select($sql, [
            $senderType, $senderId, $receiverType, $receiverId,
            $receiverType, $receiverId, $senderType, $senderId
        ]);
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
}
