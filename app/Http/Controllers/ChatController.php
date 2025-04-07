<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Repository\MessageRepos;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Hiển thị danh sách người dùng có thể nhắn tin
     */
    public function index()
    {
        try {
            // Lấy email của người dùng đang đăng nhập
            $currentUserEmail = Session::get('username');

            // Gọi phương thức lấy tất cả người dùng từ MessageRepos
            $allUsers = MessageRepos::getAllUsers();

            // Lọc ra tài khoản đang đăng nhập khỏi danh sách
            $users = array_filter($allUsers, function($user) use ($currentUserEmail) {
                // Kiểm tra cả email và username vì admin có thể đăng nhập bằng username
                return $user->email !== $currentUserEmail && $user->username !== $currentUserEmail;
            });

            // Lấy thông tin người dùng hiện tại
            $userInfo = MessageRepos::getUserInfoByEmail($currentUserEmail);
            
            // Khởi tạo danh sách chat
            $chatPartners = [];
            
            // Chỉ lấy danh sách chat nếu tìm thấy thông tin người dùng
            if ($userInfo) {
                // Lấy danh sách người đã chat
                $partners = MessageRepos::getChatPartners($userInfo->type, $userInfo->id);
                
                foreach ($partners as $partner) {
                    $partnerData = json_decode($partner->partner);
                    
                    $chatPartners[] = (object)[
                        'id' => $partnerData->id,
                        'email' => $partnerData->email,
                        'type' => $partnerData->type,
                        'last_message' => $partner->last_message,
                        'last_message_time' => Carbon::parse($partner->last_message_time)->format('H:i:s d/m/Y')
                    ];
                }
            }

            // Trả về view 'chat.index' với danh sách người dùng và danh sách chat
            return view('chat.index', [
                'users' => array_values($users),
                'chatPartners' => $chatPartners
            ]);
        } catch (\Exception $e) {
            // Nếu có lỗi, trả về view với danh sách rỗng và thông báo lỗi
            return view('chat.index', [
                'users' => [], 
                'chatPartners' => [],
                'error' => 'Không thể lấy danh sách người dùng'
            ]);
        }
    }

    /**
     * Xử lý gửi tin nhắn
     */
    public function sendMessage(Request $request)
    {
        try {
            // Lấy nội dung tin nhắn và email người nhận từ request
            $content = $request->input('message');
            $receiverEmail = $request->input('receiver');

            // Lấy email người gửi từ session
            $senderEmail = Session::get('username');

            // Kiểm tra nếu thiếu thông tin thì trả về lỗi
            if (!$content || !$receiverEmail || !$senderEmail) {
                return response()->json(['success' => false, 'error' => 'Thiếu thông tin tin nhắn']);
            }

            // Lấy thông tin người gửi và người nhận từ database
            $senderInfo = MessageRepos::getUserInfoByEmail($senderEmail);
            $receiverInfo = MessageRepos::getUserInfoByEmail($receiverEmail);

            // Kiểm tra nếu không tìm thấy thông tin người gửi hoặc người nhận
            if (!$senderInfo || !$receiverInfo) {
                return response()->json(['success' => false, 'error' => 'Không tìm thấy thông tin người dùng']);
            }

            // Lưu tin nhắn vào database
            $messageId = MessageRepos::saveMessage(
                $senderInfo->type, $senderInfo->id,
                $receiverInfo->type, $receiverInfo->id,
                $content
            );

            // Nếu không lưu được tin nhắn, trả về lỗi
            if (!$messageId) {
                return response()->json(['success' => false, 'error' => 'Không thể lưu tin nhắn']);
            }

            // Trả về phản hồi thành công với thông tin tin nhắn
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $messageId,
                    'sender' => $senderEmail,
                    'receiver' => $receiverEmail,
                    'text' => $content,
                    'timestamp' => Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    /**
     * Lấy danh sách tin nhắn giữa hai người dùng
     */
    public function getMessages(Request $request)
    {
        try {
            // Lấy email của người nhận từ request và người gửi từ session
            $receiverEmail = $request->input('receiver');
            $senderEmail = Session::get('username');
            $lastId = intval($request->input('last_id', 0));
            $checkReadStatus = $request->input('check_read_status', false);

            // Kiểm tra nếu thiếu thông tin thì trả về lỗi
            if (!$senderEmail || !$receiverEmail) {
                return response()->json([
                    'success' => false, 
                    'error' => 'Thiếu thông tin người gửi/nhận', 
                    'messages' => []
                ]);
            }

            // Lấy thông tin người gửi và người nhận từ database
            $senderInfo = MessageRepos::getUserInfoByEmail($senderEmail);
            $receiverInfo = MessageRepos::getUserInfoByEmail($receiverEmail);

            // Kiểm tra nếu không tìm thấy thông tin người gửi hoặc người nhận
            if (!$senderInfo || !$receiverInfo) {
                return response()->json([
                    'success' => false, 
                    'error' => 'Không tìm thấy thông tin người dùng', 
                    'messages' => []
                ]);
            }

            // Lấy danh sách tin nhắn giữa hai người dùng
            $messages = MessageRepos::getMessagesBetweenUsers(
                $senderInfo->type, $senderInfo->id,
                $receiverInfo->type, $receiverInfo->id,
                $lastId
            );

            // Đánh dấu tin nhắn từ người khác gửi đến đã đọc
            // Chỉ đánh dấu nếu không phải là chế độ kiểm tra trạng thái đã đọc
            if (!$checkReadStatus && count($messages) > 0) {
                MessageRepos::markMessagesAsRead(
                    $receiverInfo->type, $receiverInfo->id,
                    $senderInfo->type, $senderInfo->id
                );
            }

            // Định dạng lại dữ liệu tin nhắn trước khi trả về
            $formattedMessages = [];
            foreach ($messages as $msg) {
                $senderEmail = $this->getEmailByTypeAndId($msg->sender_type, $msg->sender_id);
                $receiverEmail = $this->getEmailByTypeAndId($msg->receiver_type, $msg->receiver_id);

                // Xử lý timestamp - Định dạng lại timestamp
                $timestamp = $msg->timestamp;

                try {
                    // Loại bỏ phần microsecond nếu có
                    if (strpos($timestamp, '.') !== false) {
                        $timestamp = substr($timestamp, 0, strpos($timestamp, '.'));
                    }

                    // Chuyển đổi timestamp thành đối tượng Carbon
                    $dt = Carbon::parse($timestamp);

                    // Định dạng lại timestamp theo định dạng d/m/Y H:i:s
                    // Thay đổi định dạng để tránh trùng lặp với thứ tự khác
                    $timestamp = $dt->format('H:i:s d/m/Y');
                } catch (\Exception $e) {
                    // Nếu có lỗi, sử dụng thời gian hiện tại
                    $timestamp = Carbon::now()->format('H:i:s d/m/Y');
                }

                $formattedMessages[] = [
                    'id' => $msg->message_id,
                    'sender' => $senderEmail,
                    'receiver' => $receiverEmail,
                    'sender_type' => $msg->sender_type,
                    'receiver_type' => $msg->receiver_type,
                    'text' => $msg->content,
                    'timestamp' => $timestamp,
                    'is_read' => (bool)$msg->is_read
                ];
            }

            // Trả về danh sách tin nhắn
            return response()->json(['success' => true, 'messages' => $formattedMessages]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'messages' => []]);
        }
    }

    /**
     * Lấy email của người dùng dựa vào loại người dùng và ID
     */
    private function getEmailByTypeAndId($type, $id)
    {
        switch ($type) {
            case 'customer':
                $result = DB::select('SELECT email FROM customer WHERE id_c = ?', [$id]);
                break;
            case 'teacher':
                $result = DB::select('SELECT email FROM teacher WHERE id_t = ?', [$id]);
                break;
            case 'staff':
                $result = DB::select('SELECT email FROM staff WHERE id_s = ?', [$id]);
                break;
            case 'admin':
                $result = DB::select('SELECT email_a FROM admin WHERE id_a = ?', [$id]);
                break;
            default:
                return null;
        }

        // Trả về email nếu tìm thấy, ngược lại trả về null
        if (empty($result)) {
            return null;
        }

        // Xử lý đặc biệt cho admin
        if ($type === 'admin') {
            return $result[0]->email_a;
        }

        return $result[0]->email;
    }

    /**
     * Tìm kiếm người dùng theo từ khóa
     */
    public function search(Request $request)
    {
        try {
            // Lấy từ khóa tìm kiếm từ request
            $query = $request->input('query');

            // Nếu từ khóa quá ngắn, trả về danh sách rỗng
            if (empty($query) || strlen($query) < 2) {
                return response()->json(['success' => true, 'users' => []]);
            }

            // Tìm kiếm người dùng dựa trên từ khóa
            $users = MessageRepos::searchUsers($query, Session::get('username'));

            // Trả về danh sách người dùng tìm được
            return response()->json(['success' => true, 'users' => $users]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    //TODO: Notifications for messages
    public function getUnreadCount(Request $request) {
        try {
            // Lấy email của người dùng đang đăng nhập
            $userEmail = Session::get('username');
            
            // Lấy thông tin người dùng từ email
            $userInfo = MessageRepos::getUserInfoByEmail($userEmail);
            
            if (!$userInfo) {
                return response()->json(['success' => false, 'error' => 'Không tìm thấy thông tin người dùng', 'unread_count' => 0]);
            }
            
            // Lấy số lượng tin nhắn chưa đọc từ MessageRepos
            $unreadCount = MessageRepos::getUnreadMessageCount($userInfo->type, $userInfo->id);
            
            // Đảm bảo đây là một số nguyên
            $unreadCount = intval($unreadCount);
            
            return response()->json(['success' => true, 'unread_count' => $unreadCount]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'unread_count' => 0]);
        }
    }

    /**
     * Định dạng lại timestamp thành chuẩn H:i:s d/m/Y
     */
    private function formatTimestamp($timestamp)
    {
        try {
            // Loại bỏ phần microsecond nếu có
            if (strpos($timestamp, '.') !== false) {
                $timestamp = substr($timestamp, 0, strpos($timestamp, '.'));
            }

            // Chuyển đổi timestamp thành đối tượng Carbon
            $dt = Carbon::parse($timestamp);

            // Định dạng lại timestamp theo định dạng H:i:s d/m/Y
            return $dt->format('H:i:s d/m/Y');
        } catch (\Exception $e) {
            // Nếu có lỗi, sử dụng thời gian hiện tại
            return Carbon::now()->format('H:i:s d/m/Y');
        }
    }

    public function getUnreadMessages(Request $request) {
        try {
            // Lấy thông tin người dùng đang đăng nhập
            $userEmail = Session::get('username');
            
            // Nếu không có người dùng đăng nhập, trả về lỗi
            if (!$userEmail) {
                return response()->json(['success' => false, 'error' => 'Người dùng chưa đăng nhập', 'messages' => []]);
            }
            
            // Lấy thông tin người dùng từ email
            $userInfo = MessageRepos::getUserInfoByEmail($userEmail);
            
            // Nếu không tìm thấy thông tin người dùng, trả về lỗi
            if (!$userInfo) {
                return response()->json(['success' => false, 'error' => 'Không tìm thấy thông tin người dùng', 'messages' => []]);
            }
            
            // Lấy tin nhắn chưa đọc từ database
            $messages = DB::select(
                'SELECT m.message_id, m.content, m.timestamp, 
                        m.sender_type, m.sender_id  
                 FROM messages m 
                 WHERE m.receiver_type = ? 
                 AND m.receiver_id = ? 
                 AND m.is_read = false
                 ORDER BY m.timestamp DESC
                 LIMIT 10',  // Giới hạn 10 tin nhắn mới nhất
                [$userInfo->type, $userInfo->id]
            );
            
            // Định dạng lại dữ liệu tin nhắn trước khi trả về
            $formattedMessages = [];
            foreach ($messages as $msg) {
                // Lấy email của người gửi
                $senderEmail = $this->getEmailByTypeAndId($msg->sender_type, $msg->sender_id);
                
                // Chỉ thêm vào danh sách nếu có email hợp lệ
                if ($senderEmail) {
                    $formattedMessages[] = [
                        'id' => $msg->message_id,
                        'sender' => $senderEmail,
                        'sender_type' => $msg->sender_type,
                        'sender_id' => $msg->sender_id,
                        'text' => $msg->content,
                        'timestamp' => $this->formatTimestamp($msg->timestamp)
                    ];
                }
            }
            
            return response()->json([
                'success' => true, 
                'messages' => $formattedMessages, 
                'count' => count($formattedMessages)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'error' => $e->getMessage(), 
                'messages' => []
            ]);
        }
    }

    public function markMessagesAsRead(Request $request) {
        try {
            $receiverEmail = Session::get('username');
            $senderId = $request->input('id');
            $senderType = $request->input('type');
            
            if (!$senderId || !$senderType || !$receiverEmail) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Thiếu thông tin người gửi/nhận'
                ]);
            }
            
            $receiverInfo = MessageRepos::getUserInfoByEmail($receiverEmail);
            
            if (!$receiverInfo) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Không tìm thấy thông tin người dùng'
                ]);
            }
            
            // Đánh dấu tin nhắn là đã đọc và lưu số lượng cập nhật
            // QUAN TRỌNG: Thứ tự tham số là (người GỬI, người NHẬN)
            $updatedCount = MessageRepos::markMessagesAsRead(
                $senderType, $senderId,
                $receiverInfo->type, $receiverInfo->id
            );
            
            // Lấy số lượng tin nhắn chưa đọc mới
            $unreadCount = MessageRepos::getUnreadMessageCount($receiverInfo->type, $receiverInfo->id);
            
            return response()->json([
                'success' => true, 
                'message' => 'Tin nhắn đã được đánh dấu là đã đọc',
                'updated_count' => $updatedCount,
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    //TODO: Retrieve list of chatted users
    /**
     * Lấy danh sách người đã chat với người dùng hiện tại
     */
    public function getChatPartners()
    {
        try {
            // Lấy thông tin người dùng đang đăng nhập
            $userEmail = Session::get('username');
            
            // Nếu không có người dùng đăng nhập, trả về lỗi
            if (!$userEmail) {
                return response()->json(['success' => false, 'error' => 'Người dùng chưa đăng nhập']);
            }
            
            // Lấy thông tin người dùng từ email
            $userInfo = MessageRepos::getUserInfoByEmail($userEmail);
            
            // Nếu không tìm thấy thông tin người dùng, trả về lỗi
            if (!$userInfo) {
                return response()->json([
                    'success' => false, 
                    'error' => 'Không tìm thấy thông tin người dùng'
                ]);
            }
            
            // Phương pháp 1: Sử dụng getChatPartners
            
            // Phương pháp 1: Sử dụng getChatPartners
            $partners = MessageRepos::getChatPartners($userInfo->type, $userInfo->id);
            
            // Nếu không có kết quả, thử phương pháp 2
            if (empty($partners)) {
                // Truy vấn trực tiếp
                $sql = "SELECT 
                          DISTINCT ON (partner_id, partner_type)
                          CASE WHEN sender_type = ? AND sender_id = ? THEN receiver_type ELSE sender_type END AS partner_type,
                          CASE WHEN sender_type = ? AND sender_id = ? THEN receiver_id ELSE sender_id END AS partner_id,
                          CASE WHEN sender_type = ? AND sender_id = ? THEN 
                            (SELECT email FROM messages_partners WHERE type = receiver_type AND id = receiver_id LIMIT 1)
                          ELSE 
                            (SELECT email FROM messages_partners WHERE type = sender_type AND id = sender_id LIMIT 1)
                          END AS partner_email,
                          content AS last_message,
                          timestamp AS last_message_time
                        FROM messages
                        WHERE (sender_type = ? AND sender_id = ?) OR (receiver_type = ? AND receiver_id = ?)
                        ORDER BY partner_id, partner_type, timestamp DESC";
                
                $params = array_fill(0, 10, null);
                for ($i = 0; $i < 10; $i += 2) {
                    $params[$i] = $userInfo->type;
                    $params[$i + 1] = $userInfo->id;
                }
                
                $results = DB::select($sql, $params);
                
                // Định dạng kết quả
                $partners = [];
                foreach ($results as $row) {
                    $partnerObj = [
                        'type' => $row->partner_type,
                        'id' => $row->partner_id,
                        'email' => $row->partner_email
                    ];
                    
                    $partners[] = (object)[
                        'partner' => json_encode($partnerObj),
                        'last_message' => $row->last_message,
                        'last_message_time' => $row->last_message_time
                    ];
                }
                
            }
            
            // Định dạng dữ liệu trả về
            $formattedPartners = [];
            foreach ($partners as $partner) {
                $partnerData = json_decode($partner->partner);
                
                // Bỏ qua partners không có email
                if (empty($partnerData->email)) {
                    continue;
                }
                
                $formattedPartners[] = [
                    'id' => $partnerData->id,
                    'email' => $partnerData->email,
                    'type' => $partnerData->type,
                    'last_message' => $partner->last_message,
                    'last_message_time' => date('H:i:s d/m/Y', strtotime($partner->last_message_time))
                ];
            }
            
            
            return response()->json(['success' => true, 'partners' => $formattedPartners]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}