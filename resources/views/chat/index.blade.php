<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbox</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            height: calc(100vh - 40px);
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background-color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .chat-header h2 {
            margin: 0 0 10px 0;
            color: #1877f2;
            font-size: 24px;
        }

        .user-info {
            color: #65676b;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .search-container {
            position: relative;
            margin: 10px 0;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #dddfe2;
            border-radius: 20px;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.2s;
            background-color: #f0f2f5;
        }

        .search-input:focus {
            outline: none;
            border-color: #1877f2;
            background-color: #fff;
            box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
            background-color: #fff;
            border-radius: 8px;
            z-index: 1000;
            display: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
            margin-top: 5px;
        }

        .search-results.show {
            display: block !important;
        }

        .search-result-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f2f5;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .search-result-item:hover {
            background-color: #f5f6f7;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .selected-user {
            margin-top: 10px;
            padding: 12px 15px;
            background-color: #e7f3ff;
            border-radius: 8px;
            border-left: 4px solid #1877f2;
            font-weight: 500;
            color: #1877f2;
        }

        .chat-container {
            flex: 1;
            display: flex;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: calc(100% - 150px);
        }
        
        /* Thêm style cho sidebar */
        .chat-sidebar {
            width: 320px;
            border-right: 1px solid #e4e6eb;
            display: flex;
            flex-direction: column;
            background-color: #fff;
            overflow: hidden;
            /* Đảm bảo nội dung không tràn ra ngoài */
        }
        
        .sidebar-header {
            padding: 15px;
            border-bottom: 1px solid #e4e6eb;
        }
        
        .sidebar-header h3 {
            margin: 0;
            color: #050505;
            font-size: 20px;
            font-weight: 600;
        }
        
        .sidebar-tabs {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
        }
        
        .tab-button {
            background: none;
            border: none;
            padding: 0;
            font: inherit;
            cursor: pointer;
            outline: inherit;
            color: #65676b;
            font-size: 14px;
            font-weight: 500;
        }
        
        .tab-button.active {
            color: #1877f2;
            border-bottom: 2px solid #1877f2;
            font-weight: 600;
        }
        
        .sidebar-search {
            padding: 10px 15px;
            border-bottom: 1px solid #e4e6eb;
        }
        
        .sidebar-search input {
            width: 92%;
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            background-color: #f0f2f5;
            font-size: 14px;
        }
        
        .sidebar-search input:focus {
            outline: none;
            background-color: #e4e6eb;
        }
        
        .users-list {
            flex: 1;
            overflow-y: auto;
            /* Thêm thanh cuộn dọc */
            padding: 0;
            max-height: calc(100% - 110px);
            /* Đảm bảo có đủ không gian cho header và search */
        }
        
        .user-item {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f0f2f5;
            cursor: pointer;
            transition: background-color 0.2s;
            position: relative;
            /* Để định vị badge */
        }
        
        .user-item:hover {
            background-color: #f5f6f7;
        }

        .user-item.active {
            background-color: #e7f3ff;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #1877f2;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
            font-size: 16px;
            position: relative;
            /* Để định vị badge */
        }
        
        .user-details {
            flex: 1;
        }
        
        .user-name {
            font-weight: 500;
            color: #050505;
            margin: 0 0 3px 0;
            font-size: 14px;
        }
        
        .user-type {
            color: #65676b;
            font-size: 12px;
        }
        
        .user-status {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #31a24c;
            margin-left: 5px;
        }
        
        /* Style cho badge thông báo tin nhắn mới */
        .message-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #e41e3f;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        /* Style cho thông báo tin nhắn mới */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .notification {
            background-color: #1877f2;
            color: white;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease, fadeOut 0.5s ease 4.5s forwards;
            max-width: 300px;
        }
        
        .notification-icon {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .notification-message {
            font-size: 13px;
            opacity: 0.9;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                visibility: hidden;
            }
        }
        
        .chat-box-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #fff;
            scroll-behavior: smooth;
        }

        .message {
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 65%;
            word-wrap: break-word;
            position: relative;
            animation: fadeIn 0.3s ease;
        }

        .message-text {
            margin-bottom: 3px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sender {
            background-color: #0084ff;
            color: white;
            margin-left: auto;
            border-radius: 18px 18px 4px 18px;
        }

        .receiver {
            background-color: #f0f2f5;
            color: #050505;
            margin-right: auto;
            border-radius: 18px 18px 18px 4px;
        }

        .timestamp {
            font-size: 11px;
            color: rgba(0, 0, 0, 0.4);
            margin-top: 5px;
            display: block;
            text-align: right;
        }

        .sender .timestamp {
            color: rgba(255, 255, 255, 0.7);
        }

        .message-input-container {
            display: flex;
            padding: 10px 15px;
            border-top: 1px solid #f0f2f5;
            background-color: #fff;
            align-items: center;
        }

        .message-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #dddfe2;
            border-radius: 20px;
            font-size: 15px;
            background-color: #f0f2f5;
            margin-right: 10px;
            transition: all 0.2s;
        }

        .message-input:focus {
            outline: none;
            border-color: #1877f2;
            background-color: #fff;
        }

        .send-button {
            width: 40px;
            height: 40px;
            background-color: #0084ff;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .send-button:hover {
            background-color: #0070db;
        }

        .send-button:disabled {
            background-color: #e4e6eb;
            cursor: not-allowed;
            color: #bcc0c4;
        }

        .no-messages {
            text-align: center;
            color: #65676b;
            padding: 30px;
            font-size: 15px;
        }
        
        @keyframes pulse {
            0% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.6;
            }
        }

        .message-status {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 2px;
            text-align: right;
            padding-right: 8px;
            font-style: italic;
            animation: fadeIn 0.2s ease;
            display: block !important;
            opacity: 1 !important;
        }

        .sender .message-status {
            color: rgba(255, 255, 255, 0.8);
            margin-left: auto;
            width: 100%;
        }

        .message.sending .message-status {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.5; }
            50% { opacity: 1; }
            100% { opacity: 0.5; }
        }

        .message.sender .read-status {
            font-size: 8px;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 5px;
            margin-left: auto;
            padding-right: 8px;
            position: relative;
            line-height: 1;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            letter-spacing: 0.3px;
            text-align: right;
            width: 100%;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
                height: calc(100vh - 20px);
            }

            .chat-container {
                flex-direction: column;
                height: calc(100% - 120px);
            }

            .message {
                max-width: 85%;
            }
        }
        
        .loading-messages,
        .error-messages {
            padding: 20px;
            text-align: center;
            color: #65676b;
            font-style: italic;
        }
        
        .error-messages {
            color: #e41e3f;
        }

        .read-status {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.7);
            display: block;
            text-align: right;
            margin-top: 2px;
            font-style: italic;
        }

        /* CSS cho nút gửi tin nhắn và các phím tắt */
        .message-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .keyboard-shortcuts {
            color: #65676b;
            font-size: 12px;
        }

        /* Cập nhật CSS cho chỉ báo đã đọc */
        .message.sender .read-status {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 2px;
            margin-left: auto; /* Đẩy phần tử sang phải */
            padding-right: 8px; /* Tăng padding bên phải */
            position: relative;
            line-height: 1;
            animation: fadeIn 0.2s ease;
            display: flex;
            justify-content: flex-end; /* Căn phải */
            align-items: center;
            letter-spacing: 0.3px;
            text-align: right; /* Căn phải cho text */
            width: 100%; /* Đảm bảo chiếm toàn bộ chiều rộng */
        }
        
        /* Cải thiện hiển thị dấu tích */
        .double-tick {
            position: relative;
            display: inline-block;
            margin-right: 4px; /* Tăng khoảng cách giữa dấu tích và chữ Seen */
            vertical-align: middle;
            margin-bottom: 0px;
        }
        
        .double-tick i {
            font-size: 7px;
            position: relative;
            color: rgba(255, 255, 255, 0.85);
        }
        
        .double-tick i:nth-child(1) {
            margin-right: -4px;
            transform: translateX(1px);
        }
        
        .double-tick i:nth-child(2) {
            margin-left: -1px;
            transform: translateX(-1px);
        }

        .user-details {
            flex: 1;
        }
        
        .user-name {
            font-weight: 500;
            color: #050505;
            margin: 0 0 3px 0;
            font-size: 14px;
        }
        
        .user-type {
            color: #65676b;
            font-size: 12px;
        }
        
        .last-message {
            color: #65676b;
            font-size: 12px;
            margin: 3px 0 2px 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .user-details .message-time {
            color: #65676b;
            font-size: 11px;
            margin: 0;
            font-style: italic;
        }

        .tab-content {
            display: none;
            height: 100%;
            overflow-y: auto;
        }
        
        .tab-content.active {
            display: block;
        }

        /* CSS cho tin nhắn bị lỗi */
        .message.sender.error-message {
            background-color: #ffdddd; /* Màu nền nhạt */
            border: 1px solid #e74c3c; /* Viền đỏ */
            position: relative;
        }

        .message.sender.error-message::before {
            content: "!";
            position: absolute;
            left: -18px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .message.sender.error-message .message-status {
            color: #e74c3c !important; /* Màu đỏ cho thông báo lỗi */
            font-weight: 500; /* Đậm hơn */
            cursor: pointer;
            text-decoration: underline;
            padding: 5px 0;
            font-size: 11px;
        }

        .retry-button {
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 3px 8px;
            font-size: 10px;
            cursor: pointer;
            margin-top: 5px;
            display: inline-block;
        }

        .retry-button:hover {
            background-color: #c0392b;
        }

        .sent-status {
            font-size: 10px;
            animation: none !important;
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 500 !important;
            padding: 2px 6px !important;
            border-radius: 8px !important;
            display: inline-block !important;
            margin-top: 2px !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="chat-header">
            <h2>Chat</h2>
            <div class="user-info">
                <p>Đang đăng nhập với tài khoản: <strong>{{ Session::get('username') }}</strong></p>
            </div>
        </div>

        <div class="chat-container">
            <!-- Sidebar hiển thị danh sách người dùng -->
            <div class="chat-sidebar">
                <div class="sidebar-header">
                    <h3>Tin nhắn</h3>
                </div>
                <div class="sidebar-tabs">
                    <button class="tab-button active" data-tab="chat">Đã Chat</button>
                    <button class="tab-button" data-tab="all">Tất Cả</button>
                </div>
                <div class="sidebar-search">
                    <input type="text" id="sidebar-search-input" placeholder="Tìm kiếm người dùng...">
                </div>
                <div class="users-list" id="users-list">
                    <div id="chat-partners-list" class="tab-content active">
                        @if (isset($chatPartners) && count($chatPartners) > 0)
                            @foreach ($chatPartners as $partner)
                                <div class="user-item" data-email="{{ $partner->email }}" id="user-{{ $partner->email }}">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($partner->email, 0, 1)) }}
                                        <span class="message-badge" style="display: none;">0</span>
                                    </div>
                                    <div class="user-details">
                                        <p class="user-name">{{ $partner->email }}</p>
                                        <p class="user-type">{{ ucfirst($partner->type) }}</p>
                                        <p class="last-message">{{ \Illuminate\Support\Str::limit($partner->last_message, 25) }}</p>
                                        <p class="message-time">{{ $partner->last_message_time }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-users">Chưa có tin nhắn nào</div>
                        @endif
                    </div>
                    
                    <div id="all-users-list" class="tab-content">
                        @if (isset($users) && count($users) > 0)
                            @foreach ($users as $user)
                                <div class="user-item" data-email="{{ $user->email }}" id="user-all-{{ $user->email }}">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->email, 0, 1)) }}
                                        <span class="message-badge" style="display: none;">0</span>
                                    </div>
                                    <div class="user-details">
                                        <p class="user-name">{{ $user->email }}</p>
                                        <p class="user-type">{{ ucfirst($user->type) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-users">Không có người dùng nào</div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Phần chat chính -->
            <div class="chat-box-container">
                <div id="chat-header-info" class="selected-user"
                    style="display: none; margin: 0; border-radius: 0; border-left: none; border-bottom: 1px solid #e4e6eb;">
                    <p>Đang chat với: <strong id="chat-with-name"></strong></p>
                </div>
                <div id="chat-box" class="chat-box">
                    <div class="no-messages">Chọn một người dùng để bắt đầu chat</div>
                </div>
                <div class="message-input-container">
                    <input type="text" id="message-input" class="message-input" placeholder="Nhập tin nhắn..."
                        disabled>
                    <button id="send-button" class="send-button" disabled>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Container cho thông báo tin nhắn mới -->
    <div class="notification-container" id="notification-container"></div>

    <script>
        const currentUser = "{{ Session::get('username') }}";
        let chatWith = null;
        let lastMessageId = 0;
        let messagePollingInterval;
        let isSending = false;
        let messageQueue = [];
        let lastPollTime = 0;
        let messageCache = new Map(); // Cache tin nhắn
        let pendingMessages = new Set(); // Theo dõi tin nhắn đang gửi
        const POLL_INTERVAL = 3000; // 3 giây
        const MESSAGE_CACHE_TIME = 2000; // 2 giây
        const MESSAGE_BATCH_SIZE = 50; // Số lượng tin nhắn tải mỗi lần
        const DOM_UPDATE_DEBOUNCE = 100; // 100ms debounce cho cập nhật DOM
        const SEND_TIMEOUT = 10000; // 10 giây timeout cho gửi tin nhắn
        const CACHE_DURATION = 5000; // 5 giây cho cache tin nhắn

        // Thêm biến theo dõi tin nhắn gần đây
        const recentMessages = new Map(); // message_content -> timestamp

        // Thêm biến theo dõi tin nhắn đã gửi
        const sentMessageIds = new Set(); // Lưu ID tin nhắn đã gửi thành công

        // Thêm biến theo dõi nội dung tin nhắn đang gửi
        const pendingMessageContents = new Set(); // Lưu nội dung tin nhắn đang gửi

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        /**
         * Cập nhật hộp chat với tin nhắn mới nhận được
         */
        function updateChatBox(messages, appendOnly = false) {
            // Kiểm tra và tạo phần tử nếu cần thiết
            var chatBox = document.querySelector('#chat-box');
            if (!chatBox) {
                console.error('Không tìm thấy phần tử chat-box');
                return;
            }

            // Tạo fragment để gom nhóm các thay đổi DOM
            const fragment = document.createDocumentFragment();
            
            // Lấy tất cả ID tin nhắn hiện có trong DOM
            const existingIds = new Set();
            Array.from(chatBox.querySelectorAll('.message[id^="msg-"]')).forEach(el => {
                existingIds.add(el.id.replace('msg-', ''));
            });
            
            // Xử lý từng tin nhắn nhận được
            for (const msg of messages) {
                const msgId = String(msg.id);
                
                // Bỏ qua tin nhắn đã tồn tại nếu đang ở chế độ append
                if (existingIds.has(msgId)) {
                    // Chỉ cập nhật trạng thái đã đọc nếu cần
                    if (isMessageFromCurrentUser(msg.sender, msg.sender_type) && msg.is_read) {
                        const existingMsg = document.getElementById(`msg-${msgId}`);
                        if (existingMsg && !existingMsg.querySelector('.read-status')) {
                            addReadStatusWithAnimation(existingMsg);
                        }
                    }
                    continue;
                }
                
                // Tạo phần tử tin nhắn mới
                const messageDiv = document.createElement('div');
                messageDiv.id = `msg-${msgId}`;
                messageDiv.className = `message ${isMessageFromCurrentUser(msg.sender, msg.sender_type) ? 'sender' : 'receiver'}`;
                
                // Luôn thêm phần tử message-status cho tin nhắn người gửi
                if (isMessageFromCurrentUser(msg.sender, msg.sender_type)) {
                    messageDiv.innerHTML = `
                        <div class="message-text">${msg.text}</div>
                        <span class="timestamp">${msg.timestamp}</span>
                        ${msg.is_read ? 
                            `<span class="read-status"><span class="double-tick"><i class="fas fa-check"></i><i class="fas fa-check"></i></span> Seen</span>` : 
                            `<div class="message-status">
                                ${msg.status === 'sending' ? 'Sending...' : '<span class="sent-status">Sent</span>'}
                            </div>`
                        }
                    `;
                } else {
                    messageDiv.innerHTML = `
                        <div class="message-text">${msg.text}</div>
                        <span class="timestamp">${msg.timestamp}</span>
                    `;
                }
                
                fragment.appendChild(messageDiv);
            }

            // Cập nhật DOM
            if (fragment.childNodes.length > 0) {
                // Nếu đang hiển thị "Đang tải tin nhắn..." và không phải là chế độ append, xóa nó đi
                const loadingMsg = chatBox.querySelector('.loading-messages');
                if (loadingMsg && !appendOnly) {
                    chatBox.innerHTML = '';
                }
                
                // Thêm fragment vào chat box
                chatBox.appendChild(fragment);
                
                // Cuộn xuống tin nhắn mới nhất nếu tin nhắn mới được thêm vào
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        }

        // Kiểm tra người gửi tin nhắn
        function isMessageFromCurrentUser(sender, senderType) {
            const currentUsername = currentUser.toLowerCase().trim();
            const senderEmail = (sender || '').toLowerCase().trim();

            if (currentUsername.includes('admin')) {
                return senderType === 'admin';
            }

            return senderEmail === currentUsername ||
                senderEmail.startsWith(currentUsername + "@") ||
                (senderEmail.includes("@") && currentUsername === senderEmail.split("@")[0]);
        }

        // Tối ưu hàm load tin nhắn
        async function loadMessages(isBackgroundUpdate = false) {
            if (!chatWith) return;

            // Kiểm tra thời gian giữa các lần poll
            const now = Date.now();
            if (isBackgroundUpdate && (now - lastPollTime < POLL_INTERVAL)) {
                return;
            }
            lastPollTime = now;

            try {
                // Chỉ hiển thị loading khi không phải là background update
                if (!isBackgroundUpdate) {
                    const chatBox = $('#chat-box');
                    const noMessages = chatBox.find('.no-messages');
                    if (noMessages.length > 0) {
                        chatBox.html('<div class="loading-messages">Đang tải tin nhắn...</div>');
                    }
                }

                const response = await Promise.race([
                    $.ajax({
                        url: "{{ route('chat.messages') }}",
                        method: 'GET',
                        data: {
                            receiver: chatWith,
                            last_id: isBackgroundUpdate ? lastMessageId : 0,
                            limit: MESSAGE_BATCH_SIZE,
                            timestamp: now
                        },
                        cache: false
                    }),
                    new Promise((_, reject) => 
                        setTimeout(() => reject(new Error('Timeout')), 10000)
                    )
                ]);

                if (!response || !response.messages || response.messages.length === 0) {
                    if (!isBackgroundUpdate) {
                        $('#chat-box').html('<div class="no-messages">Chưa có tin nhắn nào với người dùng này</div>');
                    }
                    return;
                }

                // Kiểm tra và cập nhật trạng thái đã đọc
                checkAndUpdateMessageReadStatus(response.messages);

                // CHỈ cập nhật tin nhắn mới trong background update, thay vì tất cả
                let messagesToUpdate = response.messages;
                if (isBackgroundUpdate) {
                    // Lọc chỉ lấy tin nhắn mới hơn lastMessageId
                    messagesToUpdate = response.messages.filter(msg => msg.id > lastMessageId);
                }

                // Xử lý tin nhắn và cập nhật UI, chỉ nếu có tin nhắn mới
                if (messagesToUpdate.length > 0 || !isBackgroundUpdate) {
                    // Sắp xếp tin nhắn theo ID để đảm bảo thứ tự đúng
                    messagesToUpdate.sort((a, b) => a.id - b.id);
                    
                    requestAnimationFrame(() => {
                        // Nếu là background update, chỉ thêm tin nhắn mới
                        // Nếu không phải background update, cập nhật tất cả tin nhắn
                        updateChatBox(messagesToUpdate, isBackgroundUpdate);
                        
                        // Cập nhật lastMessageId
                        response.messages.forEach(msg => {
                            lastMessageId = Math.max(lastMessageId, msg.id);
                        });

                        // Cuộn xuống nếu không phải background update
                        if (!isBackgroundUpdate) {
                            const chatBox = document.getElementById('chat-box');
                            chatBox.scrollTop = chatBox.scrollHeight;
                        }
                    });
                }

            } catch (error) {
                console.error("Lỗi khi tải tin nhắn:", error);
                if (!isBackgroundUpdate) {
                    $('#chat-box').html(
                        '<div class="error-messages">Không thể tải tin nhắn. <a href="#" onclick="loadMessages(); return false;">Thử lại</a></div>'
                    );
                }
            }
        }

        // Thêm hàm mới để kiểm tra và cập nhật trạng thái đã đọc
        function checkAndUpdateMessageReadStatus(messages) {
            const senderMessages = document.querySelectorAll('.message.sender');
            
            senderMessages.forEach(messageElement => {
                const messageId = messageElement.id.replace('msg-', '');
                const message = messages.find(msg => String(msg.id) === messageId);
                
                if (message && message.is_read && !messageElement.querySelector('.read-status')) {
                    addReadStatusWithAnimation(messageElement);
                }
            });
        }

        // Tối ưu hàm gửi tin nhắn
        async function sendMessage() {
            if (isSending) return;

            const message = $('#message-input').val().trim();
            if (!message || !chatWith) return;
            
            const messageKey = `${message}|${chatWith}`;
            if (pendingMessageContents.has(messageKey)) {
                console.log('Tin nhắn đã đang được gửi:', message);
                return;
            }
            
            isSending = true;
            const tempId = 'temp-' + Date.now();
            const tempMessage = {
                id: tempId,
                text: message,
                sender: currentUser,
                timestamp: getCurrentTime(),
                status: 'sending'
            };

            try {
                // Cập nhật UI ngay lập tức
                $('#message-input').val('').focus();
                messageCache.set(tempId, tempMessage);
                pendingMessages.add(tempId);
                pendingMessageContents.add(messageKey);

                requestAnimationFrame(() => {
                    updateChatBox([tempMessage]);
                });

                // Gửi tin nhắn với timeout
                const response = await Promise.race([
                    $.ajax({
                        url: "{{ route('chat.send') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            message: message,
                            receiver: chatWith,
                            timestamp: getCurrentTime()
                        },
                        cache: false
                    }),
                    new Promise((_, reject) => 
                        setTimeout(() => reject(new Error('Timeout')), 10000)
                    )
                ]);

                if (response.success) {
                    const realMessageId = response.message.id;
                    
                    requestAnimationFrame(() => {
                        const tempElement = document.getElementById(`msg-${tempId}`);
                        if (tempElement) {
                            tempElement.id = `msg-${realMessageId}`;
                            const statusElement = tempElement.querySelector('.message-status');
                            if (statusElement) {
                                statusElement.innerHTML = '<span class="sent-status">Sent</span>';
                            }
                        }

                        // Cập nhật cache và trạng thái
                        messageCache.delete(tempId);
                        pendingMessages.delete(tempId);
                        pendingMessageContents.delete(messageKey);
                        sentMessageIds.add(realMessageId.toString());
                        messageCache.set(realMessageId, {
                            ...response.message,
                            status: 'sent'
                        });
                    });

                    lastMessageId = Math.max(lastMessageId, realMessageId);
                    
                    // Lưu thông tin tin nhắn mới vào localStorage để thông báo cho các tab khác
                    const messageData = {
                        timestamp: Date.now(),
                        sender: currentUser,
                        receiver: chatWith,
                        message_id: realMessageId,
                        content: message
                    };
                    
                    // Lưu vào localStorage để các tab khác biết có tin nhắn mới
                    localStorage.setItem('new_message_sent', JSON.stringify(messageData));
                    
                    // Cập nhật danh sách chat trong background
                    setTimeout(() => loadChatPartners(), 0);
                } else {
                    throw new Error(response.error || 'Lỗi gửi tin nhắn');
                }
            } catch (error) {
                console.error('Lỗi gửi tin nhắn:', error);
                
                requestAnimationFrame(() => {
                    const tempElement = document.getElementById(`msg-${tempId}`);
                    if (tempElement) {
                        tempElement.classList.add('error-message');
                        const statusElement = tempElement.querySelector('.message-status');
                        if (statusElement) {
                            statusElement.innerHTML = `Gửi thất bại <button class="retry-button">Thử lại</button>`;
                            statusElement.querySelector('.retry-button').onclick = (e) => {
                                e.stopPropagation();
                                resendMessage(tempId, message);
                            };
                        }
                    }
                });
            } finally {
                isSending = false;
                pendingMessageContents.delete(messageKey);
            }
        }

        // Thêm hàm để gửi lại tin nhắn thất bại
        function resendMessage(oldTempId, originalMessage) {
            // Xóa tin nhắn tạm thời cũ
            const oldElement = document.getElementById(`msg-${oldTempId}`);
            if (oldElement) {
                oldElement.remove();
            }
            
            // Xóa khỏi cache và danh sách chờ
            messageCache.delete(oldTempId);
            pendingMessages.delete(oldTempId);
            
            // Đặt tin nhắn vào ô input và gửi lại
            $('#message-input').val(originalMessage);
            
            // Đảm bảo tin nhắn này không còn trong danh sách tin nhắn đang gửi
            const messageKey = `${originalMessage}|${chatWith}`;
            pendingMessageContents.delete(messageKey);
            
            // Gửi lại tin nhắn
            sendMessage();
        }

        // Tối ưu hàm getCurrentTime
        const getCurrentTime = (() => {
            const options = {
                timeZone: 'Asia/Ho_Chi_Minh',
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };

            return () => new Date().toLocaleString('vi-VN', options).replace(',', '');
        })();

        // Event listeners
        $(document).ready(function() {
            let searchTimeout;
            
            // Xử lý chuyển đổi tab
            $('.tab-button').on('click', function() {
                // Loại bỏ active từ tất cả các tab và tab-content
                $('.tab-button').removeClass('active');
                $('.tab-content').removeClass('active');
                
                // Thêm active cho tab hiện tại
                $(this).addClass('active');
                
                // Hiển thị tab-content tương ứng
                const tabName = $(this).data('tab');
                if (tabName === 'chat') {
                    $('#chat-partners-list').addClass('active');
                } else {
                    $('#all-users-list').addClass('active');
                }
            });
            
            // Xử lý khi click vào người dùng trong danh sách
            $(document).on('click', '.user-item', function() {
                const email = $(this).data('email');
                if (email) {
                    selectUser(email);
                }
            });
            
            // Tìm kiếm trong sidebar
            $('#sidebar-search-input').on('keyup', function() {
                const query = $(this).val().trim().toLowerCase();
                
                if (query === '') {
                    // Hiển thị tất cả người dùng
                    $('.user-item').show();
                    return;
                }
                
                // Lọc danh sách người dùng
                $('.user-item').each(function() {
                    const email = $(this).data('email').toLowerCase();
                    const name = $(this).find('.user-name').text().toLowerCase();
                    const type = $(this).find('.user-type').text().toLowerCase();
                    
                    if (email.includes(query) || name.includes(query) || type.includes(query)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            
            // Tìm kiếm người dùng mới (giữ lại chức năng cũ)
            $('#search-input').on('keyup', function() {
                let query = $(this).val().trim();
                
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }
                
                if (query.length < 2) {
                    $('#search-results').removeClass('show').empty();
                    return;
                }

                $('#search-results').addClass('show');
                $('#search-results').html('<div class="search-result-item">Đang tìm kiếm...</div>');
                
                searchTimeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('chat.search') }}",
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            let results = '';
                            
                            if (!response.success || !response.users || response.users
                                .length === 0) {
                                results =
                                    '<div class="search-result-item">Không tìm thấy người dùng</div>';
                            } else {
                                response.users.forEach(user => {
                                    let displayText =
                                        `${user.email} - ${user.type}`;
                                    results +=
                                        `<div class="search-result-item" data-email="${user.email}">${displayText}</div>`;
                                });
                            }
                            
                            $('#search-results').html(results);
                            $('#search-results').addClass('show');
                        },
                        error: function(error) {
                            $('#search-results').html(
                                '<div class="search-result-item">Lỗi khi tìm kiếm</div>'
                            );
                            $('#search-results').addClass('show');
                        }
                    });
                }, 200); // Giảm thời gian chờ tìm kiếm
            });
            
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-container').length) {
                    $('#search-results').removeClass('show').empty();
                }
            });

            $('#send-button').on('click', function() {
                sendMessage();
            });
            
            $('#message-input').keypress(function(e) {
                if (e.which === 13) {
                    sendMessage();
                    return false;
                }
            });

            // Thêm sự kiện cho input với debounce
            $('#message-input').on('input', debounce(function() {
                // Có thể thêm chức năng "đang nhập" ở đây
            }, 300));
            
            // Lắng nghe sự kiện từ localStorage để cập nhật số tin nhắn chưa đọc ngay lập tức
            window.addEventListener('storage', function(e) {
                if (e.key === 'new_message_sent') {
                    const data = JSON.parse(e.newValue || '{}');
                    const now = Date.now();
                    
                    // Chỉ xử lý tin nhắn gửi trong vòng 10 giây gần đây
                    if (data && now - data.timestamp < 10000) {
                        console.log('Đã nhận thông báo tin nhắn mới từ localStorage:', data);
                        
                        // Nếu người nhận là người dùng hiện tại
                        if (data.receiver === currentUser) {
                            // Nếu đang chat với người gửi, tải tin nhắn mới ngay lập tức
                            if (chatWith === data.sender) {
                                console.log('Đang chat với người gửi tin nhắn, tải tin nhắn mới');
                                
                                // Ngừng polling hiện tại để tránh xung đột
                                if (messagePollingInterval) {
                                    clearInterval(messagePollingInterval);
                                }
                                
                                // Tải tin nhắn mới ngay lập tức
                                loadMessages(true);
                                
                                // Thiết lập lại polling sau khi tải tin nhắn
                                setupMessagePolling();
                            } else {
                                // Nếu không đang chat với người gửi, cập nhật badge và hiển thị thông báo
                                updateMessageBadge(data.sender);
                                showNotification(data.sender, data.content);
                            }
                        }
                    }
                }
            });
            
            // Kiểm tra tham số URL
            const urlParams = new URLSearchParams(window.location.search);
            const userParam = urlParams.get('user');
            
            // Kiểm tra localStorage
            const storedUser = localStorage.getItem('selected_chat_user');
            
            // Ưu tiên tham số URL, sau đó đến localStorage
            if (userParam) {
                selectUser(userParam);
            } else if (storedUser) {
                selectUser(storedUser);
                localStorage.removeItem('selected_chat_user');
            }
            
            // Load danh sách người đã chat khi trang được tải
            loadChatPartners();
            
            // Thiết lập polling để cập nhật danh sách chat mỗi 30 giây
            setInterval(function() {
                if (!document.hidden) { // Chỉ cập nhật khi tab đang active
                    loadChatPartners();
                }
            }, 30000); // 30 giây

            // Đảm bảo các status không bị ẩn khi load trang
            setTimeout(() => {
                document.querySelectorAll('.message-status').forEach(el => {
                    el.style.display = 'block';
                    el.style.opacity = '1';
                });
                
                document.querySelectorAll('.sent-status').forEach(el => {
                    el.style.display = 'block';
                    el.style.opacity = '1';
                });
            }, 500);

            // Thêm lắng nghe sự kiện messages_marked_read (thêm vào phần document.ready)
            window.addEventListener('storage', function(e) {
                // Kiểm tra sự kiện đánh dấu tin nhắn đã đọc từ localStorage
                if (e.key === 'messages_marked_read') {
                    const data = JSON.parse(e.newValue || '{}');
                    const now = Date.now();
                    
                    // Chỉ xử lý nếu sự kiện xảy ra trong 10 giây gần đây
                    if (data && now - data.timestamp < 10000) {
                        // Nếu người gửi là người dùng hiện tại và đang chat với người nhận
                        if (data.receiver === currentUser && chatWith === data.sender) {
                            updateReadStatus();
                        }
                    }
                }
            });

            // Lắng nghe sự kiện đánh dấu tin nhắn đã đọc cho TAB HIỆN TẠI 
            window.addEventListener('read_status_updated', function(e) {
                const data = e.detail;
                
                // Chỉ xử lý nếu sự kiện liên quan đến cuộc hội thoại hiện tại
                if (data && data.sender === chatWith && data.receiver === currentUser) {
                    console.log('Tin nhắn được đánh dấu đã đọc:', data);
                    updateReadStatus();
                }
            });
            
            // Lắng nghe sự kiện từ localStorage cho TAB KHÁC
            window.addEventListener('storage', function(e) {
                if (e.key === 'messages_marked_read') {
                    try {
                        const data = JSON.parse(e.newValue || '{}');
                        
                        // Chỉ xử lý nếu sự kiện xảy ra trong 30 giây gần đây
                        const now = Date.now();
                        if (data && now - data.timestamp < 30000) {
                            // Nếu người NHẬN tin nhắn là người dùng hiện tại
                            // và đang chat với người gửi tin nhắn
                            if (data.sender === chatWith && data.receiver === currentUser) {
                                console.log('Tin nhắn đã được đọc (từ tab khác):', data);
                                updateReadStatus();
                                
                                // Cập nhật giao diện ngay lập tức
                                loadMessages(true);
                            }
                        }
                    } catch (error) {
                        console.error('Lỗi khi xử lý sự kiện storage:', error);
                    }
                }
            });
        });
        
        // Thêm hàm hiển thị thông báo khi có tin nhắn mới
        function showNotification(sender, message) {
            const notificationContainer = $('#notification-container');
            const truncatedMessage = message.length > 30 ? message.substring(0, 30) + '...' : message;
            
            const notification = `
                <div class="notification">
                    <div class="notification-icon">
                        <i class="fas fa-comment"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">Tin nhắn mới từ ${sender}</div>
                        <div class="notification-message">${truncatedMessage}</div>
                    </div>
                </div>
            `;
            
            notificationContainer.append(notification);
            
            // Tự động xóa thông báo sau 5 giây
            setTimeout(() => {
                notificationContainer.find('.notification').first().remove();
            }, 5000);
            
            // Cập nhật badge trên avatar người dùng
            updateMessageBadge(sender);
        }
        
        // Hàm cập nhật badge thông báo tin nhắn mới
        function updateMessageBadge(sender) {
            // Nếu đang chat với người này thì không hiển thị badge
            if (chatWith === sender) {
                return;
            }
            
            // Cập nhật badge trong sidebar chat
            const userId = sender.replace(/[@.]/g, '-'); // Thay thế cả @ và . bằng dấu -
            const userItem = $(`#user-${userId}`);
            
            if (userItem.length) {
                const badge = userItem.find('.message-badge');
                const currentCount = parseInt(badge.text()) || 0;
                badge.text(currentCount + 1);
                badge.show();
            }
            
            // Trực tiếp gọi API để lấy số lượng tin nhắn chưa đọc mới nhất
            $.ajax({
                url: "{{ route('get.unread.count') }}",
                type: "GET",
                cache: false,
                success: function(response) {
                    if (response.success) {
                        // Cập nhật toàn cục qua localStorage
                        localStorage.setItem('unread_count_updated', JSON.stringify({
                            timestamp: Date.now(),
                            count: response.unread_count,
                            sender: currentUser,
                            receiver: sender
                        }));
                        
                        // Kích hoạt event trực tiếp cho tab hiện tại
                        const updateEvent = new CustomEvent('unread_count_updated', {
                            detail: { 
                                timestamp: Date.now(),
                                count: response.unread_count,
                                sender: currentUser,
                                receiver: sender
                            }
                        });
                        window.dispatchEvent(updateEvent);
                        
                        // Thêm cập nhật trực tiếp cho biểu tượng chat trong thanh điều hướng
                        if (response.unread_count > 0) {
                            try {
                                // Cập nhật badge trực tiếp trên trang hiện tại
                                const navBadge = document.getElementById('unread-badge');
                                if (navBadge) {
                                    navBadge.textContent = response.unread_count;
                                    navBadge.style.display = 'flex';
                                }
                                // Kích hoạt hiệu ứng nhấp nháy
                                $('.chatbox-item .nav-link').addClass('message-pulse');
                            } catch (e) {
                                console.error("Lỗi khi cập nhật badge trực tiếp:", e);
                            }
                        }
                    }
                }
            });
        }

        // Thêm hàm đánh dấu tin nhắn đã đọc
        function markMessagesAsRead(senderEmail) {
            if (!senderEmail) return;
            
            $.ajax({
                url: "{{ route('mark.messages.read') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    sender_email: senderEmail
                },
                success: function(response) {
                    if (response.success) {
                        // Cập nhật UI để hiển thị "đã đọc"
                        updateReadStatus();
                        
                        // Lưu thông tin vào localStorage để các tab khác cập nhật
                        const data = {
                            timestamp: Date.now(),
                            sender: senderEmail,  // Người gửi tin nhắn
                            receiver: currentUser  // Người nhận tin nhắn (người hiện tại)
                        };
                        
                        // Ghi thông tin vào localStorage, điều này sẽ kích hoạt sự kiện storage
                        localStorage.setItem('messages_marked_read', JSON.stringify(data));
                        
                        // Phát sóng một CustomEvent cho tab hiện tại, vì tab hiện tại không nhận sự kiện storage
                        const event = new CustomEvent('read_status_updated', {
                            detail: data
                        });
                        window.dispatchEvent(event);
                    }
                },
                error: function(error) {
                    console.error('Lỗi khi đánh dấu tin nhắn đã đọc:', error);
                }
            });
        }

        // Thêm hàm để thêm hiệu ứng animation khi thêm .read-status vào tin nhắn
        function addReadStatusWithAnimation(messageElement) {
            if (!messageElement) return;
            
            // Xóa status "Sent" nếu có
            const sentStatus = messageElement.querySelector('.message-status');
            if (sentStatus) {
                sentStatus.remove(); // Xóa hoàn toàn phần tử thay vì ẩn
            }

            // Thêm read-status nếu chưa có
            if (!messageElement.querySelector('.read-status')) {
                const readStatus = document.createElement('span');
                readStatus.className = 'read-status';
                readStatus.innerHTML = '<span class="double-tick"><i class="fas fa-check"></i><i class="fas fa-check"></i></span> Seen';
                messageElement.appendChild(readStatus);
            }
        }

        // Thêm hàm updateReadStatus
        function updateReadStatus() {
            const messages = document.querySelectorAll('.message.sender');
            messages.forEach(message => {
                if (!message.querySelector('.read-status')) {
                    addReadStatusWithAnimation(message);
                }
            });
        }

        // Hàm để chọn người dùng và bắt đầu chat
        function selectUser(email) {
            if (!email) return;
            
            // Nếu đang chọn cùng một người dùng, không làm gì cả
            if (chatWith === email) return;
            
            // Xóa cache trước khi chuyển đổi người dùng
            clearConversationCache();
            
            // Dừng polling hiện tại
            if (messagePollingInterval) {
                clearInterval(messagePollingInterval);
                messagePollingInterval = null;
            }
            
            // Ẩn badge thông báo
            $(`.user-item[data-email="${email}"]`).find('.message-badge').text('0').hide();
            
            // Đánh dấu người dùng đang được chọn
            $('.user-item').removeClass('active');
            $(`.user-item[data-email="${email}"]`).addClass('active');
            
            chatWith = email;
            $('#chat-with-name').text(email);
            $('#chat-header-info').show();
            $('#message-input, #send-button').prop('disabled', false);
            
            // Hiển thị loading ngay lập tức
            $('#chat-box').html('<div class="loading-messages">Đang tải tin nhắn...</div>');
            
            // Sử dụng setTimeout để đảm bảo UI được cập nhật trước khi load tin nhắn
            setTimeout(() => {
                loadMessages();
                $('#message-input').focus();
                
                // Đánh dấu tin nhắn đã đọc
                markMessagesAsRead(email);
                
                // Thiết lập polling mới
                setupMessagePolling();
            }, 0);
        }

        // Hàm để load danh sách người đã chat
        function loadChatPartners() {
            $.ajax({
                url: "{{ route('chat.partners') }}",
                method: 'GET',
                success: function(response) {
                    if (response.success && response.partners && response.partners.length > 0) {
                        // Cập nhật danh sách người đã chat
                        updateChatPartnersList(response.partners);
                    }
                },
                error: function(error) {
                    console.error('Lỗi khi tải danh sách chat:', error);
                }
            });
        }
        
        // Hàm cập nhật danh sách người đã chat
        function updateChatPartnersList(partners) {
            const listElement = $('#chat-partners-list');
            listElement.empty();
            
            partners.forEach(function(partner) {
                // Tạo một phần tử user-item mới
                const userItem = $(`
                    <div class="user-item" data-email="${partner.email}" id="user-${partner.email}">
                        <div class="user-avatar">
                            ${partner.email.charAt(0).toUpperCase()}
                            <span class="message-badge" style="display: none;">0</span>
                        </div>
                        <div class="user-details">
                            <p class="user-name">${partner.email}</p>
                            <p class="user-type">${partner.type.charAt(0).toUpperCase() + partner.type.slice(1)}</p>
                            <p class="last-message">${partner.last_message.substring(0, 25) + (partner.last_message.length > 25 ? '...' : '')}</p>
                            <p class="message-time">${partner.last_message_time}</p>
                        </div>
                    </div>
                `);
                
                // Thêm sự kiện click
                userItem.on('click', function() {
                    const email = $(this).data('email');
                    selectUser(email);
                });
                
                // Thêm vào danh sách
                listElement.append(userItem);
                
                // Nếu đang chat với người này, thêm class active
                if (chatWith === partner.email) {
                    userItem.addClass('active');
                }
            });
            
            // Nếu không có người dùng nào
            if (partners.length === 0) {
                listElement.html('<div class="no-users">Chưa có tin nhắn nào</div>');
            }
        }

        // Thêm hàm setupMessagePolling
        function setupMessagePolling() {
            if (messagePollingInterval) {
                clearInterval(messagePollingInterval);
            }

            // Khoảng thời gian poll ngắn hơn để kiểm tra realtime hơn
            const REALTIME_POLL_INTERVAL = 2000; // 2 giây để realtime hơn
            
            // Thiết lập polling mới
            messagePollingInterval = setInterval(() => {
                if (!document.hidden && chatWith) {
                    // Gọi API để kiểm tra tin nhắn mới
                    $.ajax({
                        url: "{{ route('chat.messages') }}",
                        method: 'GET',
                        data: {
                            receiver: chatWith,
                            last_id: lastMessageId,
                            limit: 10, // Chỉ lấy một số ít tin nhắn mới nhất để kiểm tra nhanh
                            timestamp: Date.now()
                        },
                        cache: false,
                        success: function(response) {
                            if (response && response.messages && response.messages.length > 0) {
                                // Lọc các tin nhắn mới (ID > lastMessageId)
                                const newMessages = response.messages.filter(msg => msg.id > lastMessageId);
                                
                                // Nếu có tin nhắn mới, cập nhật UI
                                if (newMessages.length > 0) {
                                    console.log('Đã nhận được tin nhắn mới:', newMessages.length);
                                    
                                    // Cập nhật UI với tin nhắn mới
                                    requestAnimationFrame(() => {
                                        // Sắp xếp tin nhắn theo ID để đảm bảo thứ tự đúng
                                        newMessages.sort((a, b) => a.id - b.id);
                                        
                                        // Cập nhật UI
                                        updateChatBox(newMessages, true);
                                        
                                        // Cuộn xuống tin nhắn mới nhất nếu người dùng đang ở cuối cuộc trò chuyện
                                        const chatBox = document.getElementById('chat-box');
                                        const isNearBottom = chatBox.scrollHeight - chatBox.clientHeight - chatBox.scrollTop < 100;
                                        
                                        if (isNearBottom) {
                                            chatBox.scrollTop = chatBox.scrollHeight;
                                        } else {
                                            // Hiển thị thông báo có tin nhắn mới
                                            // TODO: Thêm thông báo tin nhắn mới nếu cần
                                        }
                                    });
                                }
                                
                                // Kiểm tra xem có tin nhắn nào đã được đọc không
                                const hasReadMessages = response.messages.some(msg => 
                                    isMessageFromCurrentUser(msg.sender, msg.sender_type) && msg.is_read
                                );
                                
                                if (hasReadMessages) {
                                    // Cập nhật trạng thái tin nhắn
                                    checkAndUpdateMessageReadStatus(response.messages);
                                }
                                
                                // Cập nhật lastMessageId
                                response.messages.forEach(msg => {
                                    lastMessageId = Math.max(lastMessageId, msg.id);
                                });
                            }
                        },
                        error: function(error) {
                            console.error("Lỗi khi kiểm tra tin nhắn mới:", error);
                        }
                    });
                }
            }, REALTIME_POLL_INTERVAL);

            // Cập nhật listener cho visibility change
            const visibilityHandler = () => {
                if (!document.hidden && chatWith) {
                    loadMessages(true);
                }
            };
            
            // Xóa listener cũ nếu có
            document.removeEventListener('visibilitychange', visibilityHandler);
            // Thêm listener mới
            document.addEventListener('visibilitychange', visibilityHandler);
        }

        // Thêm hàm clearConversationCache
        function clearConversationCache() {
            // Xóa cache tin nhắn
            messageCache.clear();
            
            // Xóa lastMessageId chỉ khi cần thiết
            // Chỉ khi không có tin nhắn trước đó trong DOM thì mới reset về 0
            const chatBox = document.getElementById('chat-box');
            if (!chatBox || !chatBox.querySelector('.message[id^="msg-"]')) {
                // Nếu không tìm thấy tin nhắn nào, reset lastMessageId
                lastMessageId = 0;
                console.log('Reset lastMessageId về 0 (không tìm thấy tin nhắn trong DOM)');
            } else {
                console.log('Giữ nguyên lastMessageId = ' + lastMessageId);
            }
            
            // Xóa cache trong sessionStorage
            Object.keys(sessionStorage).forEach(key => {
                if (key.startsWith('messages_')) {
                    sessionStorage.removeItem(key);
                }
            });
        }
    </script>
</body>

</html>