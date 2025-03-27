<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Repository\MessageRepos;
use App\Repository\CustomerRepos;
use App\Repository\TeacherRepos;
use Carbon\Carbon;

class ChatController extends Controller
{
    /**
     * Hiển thị danh sách người dùng có thể nhắn tin
     */
    public function index()
    {
        try {
            // Gọi phương thức lấy tất cả người dùng từ MessageRepos
            $users = MessageRepos::getAllUsers();
            
            // Trả về view 'chat.index' với danh sách người dùng
            return view('chat.index', ['users' => $users]);
        } catch (\Exception $e) {
            // Nếu có lỗi, trả về view với danh sách rỗng và thông báo lỗi
            return view('chat.index', ['users' => [], 'error' => 'Không thể lấy danh sách người dùng']);
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
                    'timestamp' => Carbon::now()->format('d/m/Y H:i:s')
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

            // Kiểm tra nếu thiếu thông tin thì trả về lỗi
            if (!$senderEmail || !$receiverEmail) {
                return response()->json(['success' => false, 'error' => 'Thiếu thông tin người gửi/nhận', 'messages' => []]);
            }

            // Lấy thông tin người gửi và người nhận từ database
            $senderInfo = MessageRepos::getUserInfoByEmail($senderEmail);
            $receiverInfo = MessageRepos::getUserInfoByEmail($receiverEmail);

            // Kiểm tra nếu không tìm thấy thông tin người gửi hoặc người nhận
            if (!$senderInfo || !$receiverInfo) {
                return response()->json(['success' => false, 'error' => 'Không tìm thấy thông tin người dùng', 'messages' => []]);
            }

            // Lấy danh sách tin nhắn giữa hai người dùng
            $messages = MessageRepos::getMessagesBetweenUsers(
                $senderInfo->type, $senderInfo->id,
                $receiverInfo->type, $receiverInfo->id
            );

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
                    // Giả định rằng timestamp trong database đã là múi giờ Việt Nam
                    $dt = Carbon::parse($timestamp);
                    
                    // Định dạng lại timestamp theo định dạng d/m/Y H:i:s
                    $timestamp = $dt->format('d/m/Y H:i:s');
                } catch (\Exception $e) {
                    // Nếu có lỗi, sử dụng thời gian hiện tại
                    $timestamp = Carbon::now()->format('d/m/Y H:i:s');
                }

                // Thêm thông tin về username để dễ dàng xác định người gửi
                $senderUsername = '';
                if ($msg->sender_type === 'admin') {
                    $adminInfo = DB::select('SELECT username FROM admin WHERE id_a = ?', [$msg->sender_id]);
                    if (!empty($adminInfo)) {
                        $senderUsername = $adminInfo[0]->username;
                    }
                }

                $formattedMessages[] = [
                    'id' => $msg->message_id,
                    'sender' => $senderEmail,
                    'receiver' => $receiverEmail,
                    'sender_type' => $msg->sender_type,
                    'receiver_type' => $msg->receiver_type,
                    'text' => $msg->content,
                    'timestamp' => $timestamp
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
}
