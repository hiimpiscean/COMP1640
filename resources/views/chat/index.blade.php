<!DOCTYPE html>
<html lang="en">

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
            0% {
                opacity: 0.5;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.5;
            }
        }

        .message.sender .read-status {
            font-size: 8px;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 5px;
            margin-left: auto;
            /* Đẩy phần tử sang phải */
            padding-right: 8px;
            /* Tăng padding bên phải */
            position: relative;
            line-height: 1;
            display: flex;
            justify-content: flex-end;
            /* Căn phải */
            align-items: center;
            letter-spacing: 0.3px;
            text-align: right;
            /* Căn phải cho text */
            width: 100%;
            /* Đảm bảo chiếm toàn bộ chiều rộng */
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
            font-size: 0.75em;
            color: #999;
            display: block;
            text-align: right;
            margin-top: 2px;
        }

        .message.sender {
            position: relative;
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
            margin-left: auto;
            /* Đẩy phần tử sang phải */
            padding-right: 8px;
            /* Tăng padding bên phải */
            position: relative;
            line-height: 1;
            animation: fadeIn 0.2s ease;
            display: flex;
            justify-content: flex-end;
            /* Căn phải */
            align-items: center;
            letter-spacing: 0.3px;
            text-align: right;
            /* Căn phải cho text */
            width: 100%;
            /* Đảm bảo chiếm toàn bộ chiều rộng */
        }

        /* Cải thiện hiển thị dấu tích */
        .double-tick {
            position: relative;
            display: inline-block;
            margin-right: 4px;
            /* Tăng khoảng cách giữa dấu tích và chữ Seen */
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
            background-color: #ffdddd !important;
            color: #050505 !important;
            border: 1px solid #e74c3c !important;
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
            color: #e74c3c !important;
            /* Màu đỏ cho thông báo lỗi */
            font-weight: 500;
            /* Đậm hơn */
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

        /* Đảm bảo tin nhắn lỗi không hiển thị trạng thái Seen */
        .message.sender.error-message .read-status {
            display: none !important;
        }

        .home-button {
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            background-color: #1877f2;
            color: white;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .home-button:hover {
            background-color: #166fe5;
        }

        .home-button i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="chat-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2>ChatBox</h2>
                <a href="{{ route('ui.index') }}" class="home-button">
                    <i class="fas fa-home"></i> Home
                </a>
            </div>
            <div class="user-info">
                <p>Logged in as: <strong>{{ Session::get('username') }}</strong></p>
            </div>
        </div>

        <div class="chat-container">
            <!-- Sidebar showing user list -->
            <div class="chat-sidebar">
                <div class="sidebar-header">
                    <h3>Messages</h3>
                </div>
                <div class="sidebar-tabs">
                    <button class="tab-button active" data-tab="chat">Chat Partners</button>
                    <button class="tab-button" data-tab="all">All Users</button>
                </div>
                <div class="sidebar-search">
                    <input type="text" id="sidebar-search-input" placeholder="Search users...">
                </div>
                <div class="users-list" id="users-list">
                    <div id="chat-partners-list" class="tab-content active">
                        @if (isset($chatPartners) && count($chatPartners) > 0)
                            @foreach ($chatPartners as $partner)
                                <div class="user-item" data-email="{{ $partner->email }}"
                                    id="user-{{ $partner->email }}">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($partner->email, 0, 1)) }}
                                        <span class="message-badge" style="display: none;">0</span>
                                    </div>
                                    <div class="user-details">
                                        <p class="user-name">{{ $partner->email }}</p>
                                        <p class="user-type">{{ ucfirst($partner->type) }}</p>
                                        <p class="last-message">
                                            {{ \Illuminate\Support\Str::limit($partner->last_message, 25) }}</p>
                                        <p class="message-time">{{ $partner->last_message_time }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-users">No messages yet</div>
                        @endif
                    </div>

                    <div id="all-users-list" class="tab-content">
                        @if (isset($users) && count($users) > 0)
                            @foreach ($users as $user)
                                <div class="user-item" data-email="{{ $user->email }}"
                                    id="user-all-{{ $user->email }}">
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
                            <div class="no-users">No users found</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main chat section -->
            <div class="chat-box-container">
                <div id="chat-header-info" class="selected-user"
                    style="display: none; margin: 0; border-radius: 0; border-left: none; border-bottom: 1px solid #e4e6eb;">
                    <p>Chatting with: <strong id="chat-with-name"></strong></p>
                </div>
                <div id="chat-box" class="chat-box">
                    <div class="no-messages">Select a user to start chatting</div>
                </div>
                <div class="message-input-container">
                    <input type="text" id="message-input" class="message-input" placeholder="Type a message..."
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
        /**
         * ===================================
         * 1. KHAI BÁO HẰNG SỐ VÀ BIẾN TOÀN CỤC
         * ===================================
         */

        const APP_CONSTANTS = {
            POLL_INTERVAL: 3000, // Thời gian giữa các lần kiểm tra tin nhắn mới (3 giây)
            MESSAGE_CACHE_TIME: 2000, // Thời gian lưu cache tin nhắn (2 giây)
            MESSAGE_BATCH_SIZE: 50, // Số lượng tin nhắn tải về mỗi lần
            DOM_UPDATE_DEBOUNCE: 100, // Độ trễ cập nhật DOM (100ms)
            SEND_TIMEOUT: 10000, // Thời gian chờ tối đa khi gửi tin nhắn (10 giây)
            CACHE_DURATION: 5000, // Thời gian lưu cache (5 giây)
            REALTIME_POLL_INTERVAL: 2000 // Thời gian kiểm tra real-time (2 giây)
        };

        const currentUser = "{{ Session::get('username') }}";
        let chatWith = null;
        let lastMessageId = 0;
        let messagePollingInterval;
        let isSending = false;

        const messageCache = new Map();
        const pendingMessages = new Set();
        const sentMessageIds = new Set();
        const pendingMessageContents = new Set();

        /**
         * ===================================
         * 2. CÁC HÀM TIỆN ÍCH
         * ===================================
         */

        /**
         * Hàm debounce để giới hạn tần suất gọi hàm
         * @param {Function} func - Hàm cần debounce
         * @param {number} wait - Thời gian chờ (ms)
         */
        const debounce = (func, wait) => {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        };

        /**
         * Hàm lấy thời gian hiện tại theo định dạng Việt Nam
         * @returns {string} Chuỗi thời gian định dạng dd/mm/yyyy HH:MM:SS
         */
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

        /**
         * ===================================
         * 3. QUẢN LÝ TIN NHẮN
         * ===================================
         */

        /**
         * Kiểm tra xem tin nhắn có phải từ người dùng hiện tại không
         * @param {string} sender - Email người gửi
         * @param {string} senderType - Loại người gửi (admin/user)
         * @returns {boolean}
         */
        const isMessageFromCurrentUser = (sender, senderType) => {
            const currentUsername = currentUser.toLowerCase().trim();
            const senderEmail = (sender || '').toLowerCase().trim();

            if (currentUsername.includes('admin')) {
                return senderType === 'admin';
            }

            return senderEmail === currentUsername ||
                senderEmail.startsWith(currentUsername + "@") ||
                (senderEmail.includes("@") && currentUsername === senderEmail.split("@")[0]);
        };

        /**
         * Cập nhật giao diện chat box với tin nhắn mới
         * @param {Array} messages - Mảng tin nhắn cần hiển thị
         * @param {boolean} appendOnly - Chỉ thêm mới hay thay thế hoàn toàn
         */
        const updateChatBox = (messages, appendOnly = false) => {
            const chatBox = document.querySelector('#chat-box');
            if (!chatBox) {
                console.error('Chat box element not found');
                return;
            }

            const fragment = document.createDocumentFragment();
            const existingIds = new Set();
            Array.from(chatBox.querySelectorAll('.message[id^="msg-"]')).forEach(el => {
                existingIds.add(el.id.replace('msg-', ''));
            });

            for (const msg of messages) {
                const msgId = String(msg.id);

                if (existingIds.has(msgId)) {
                    if (isMessageFromCurrentUser(msg.sender, msg.sender_type) && msg.is_read) {
                        const existingMsg = document.getElementById(`msg-${msgId}`);
                        if (existingMsg && !existingMsg.querySelector('.read-status')) {
                            const sentStatus = existingMsg.querySelector('.message-status');
                            if (sentStatus) sentStatus.remove();

                            const readStatus = document.createElement('span');
                            readStatus.className = 'read-status';
                            readStatus.innerHTML =
                                '<span class="double-tick"><i class="fas fa-check"></i><i class="fas fa-check"></i></span> Seen';
                            existingMsg.appendChild(readStatus);
                        }
                    }
                    continue;
                }

                const messageDiv = document.createElement('div');
                messageDiv.id = `msg-${msgId}`;
                messageDiv.className =
                    `message ${isMessageFromCurrentUser(msg.sender, msg.sender_type) ? 'sender' : 'receiver'}`;

                if (isMessageFromCurrentUser(msg.sender, msg.sender_type)) {
                    messageDiv.innerHTML = `
                <div class="message-text">${msg.text}</div>
                <span class="timestamp">${msg.timestamp}</span>
                ${msg.is_read ? 
                    `<span class="read-status"><span class="double-tick">
                        <i class="fas fa-check"></i><i class="fas fa-check"></i></span> Seen</span>` : 
                    `<div class="message-status">${msg.status === 'sending' ? 'Sending...' : '<span class="sent-status">Sent</span>'}</div>`
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

            if (fragment.childNodes.length > 0) {
                const loadingMsg = chatBox.querySelector('.loading-messages');
                if (loadingMsg && !appendOnly) chatBox.innerHTML = '';

                chatBox.appendChild(fragment);
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        };

        /**
         * Tải tin nhắn từ server
         * @param {boolean} isBackgroundUpdate - Có phải cập nhật ngầm không
         */
         const loadMessages = async (isBackgroundUpdate = false) => {
            if (!chatWith || (!isBackgroundUpdate && window.isLoadingMessages)) return;

            if (!isBackgroundUpdate) {
                window.isLoadingMessages = true;
                const chatBox = $('#chat-box');
                if (chatBox.find('.message').length === 0) chatBox.html(
                    '<div class="loading-messages">Loading messages...</div>');
            }

            try {
                const requestId = Date.now();
                window.currentRequestId = requestId;

                const response = await $.ajax({
                    url: "{{ route('chat.messages') }}",
                    method: 'GET',
                    data: {
                        receiver: chatWith,
                        last_id: isBackgroundUpdate ? lastMessageId : 0,
                        limit: isBackgroundUpdate ? 20 : 100,
                        timestamp: Date.now(),
                        request_id: requestId
                    },
                    cache: false,
                    timeout: 15000
                });

                if (!chatWith || window.currentRequestId !== requestId) return;

                if (response?.messages?.length > 0) {
                    let messagesToUpdate = response.messages;
                    if (isBackgroundUpdate) messagesToUpdate = response.messages.filter(msg => msg.id >
                        lastMessageId);

                    if (messagesToUpdate.length > 0 || !isBackgroundUpdate) {
                        if (!isBackgroundUpdate) $('#chat-box').empty();
                        updateChatBox(messagesToUpdate, isBackgroundUpdate);

                        if (!isBackgroundUpdate) {
                            const chatBox = document.getElementById('chat-box');
                            if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
                        }

                        response.messages.forEach(msg => lastMessageId = Math.max(lastMessageId, msg.id));
                        updateReadStatus();
                    }
                } else if (!isBackgroundUpdate) {
                    $('#chat-box').html('<div class="no-messages">No messages yet</div>');
                }

                if (!isBackgroundUpdate) markMessagesAsRead(chatWith);
            } catch (error) {
                console.error("Error loading messages:", error);

                if (!isBackgroundUpdate) {
                    const chatBox = $('#chat-box');
                    if (chatBox.find('.message').length === 0) {
                        chatBox.html(`
                    <div class="error-messages">
                        Unable to load messages. 
                        <a href="#" class="retry-link">Try again</a>
                    </div>
                `);
                        $('.retry-link').off('click').on('click', (e) => {
                            e.preventDefault();
                            loadMessages(false);
                        });
                    }
                }
            } finally {
                if (!isBackgroundUpdate) window.isLoadingMessages = false;
            }
        };

        /**
         * Gửi tin nhắn mới
         * Xử lý việc gửi tin nhắn và cập nhật giao diện
         */
        const sendMessage = async () => {
            if (isSending) return;

            const message = $('#message-input').val().trim();
            if (!message || !chatWith) return;

            const messageKey = `${message}|${chatWith}`;
            if (pendingMessageContents.has(messageKey)) return;

            const chatBox = document.getElementById('chat-box');
            const noMessagesMsg = chatBox.querySelector('.no-messages');
            if (noMessagesMsg) chatBox.innerHTML = '';

            isSending = true;
            const tempId = 'temp-' + Date.now();

            const tempMessage = {
                id: tempId,
                text: message,
                sender: currentUser,
                receiver: chatWith,
                timestamp: getCurrentTime(),
                status: 'sending'
            };

            try {
                $('#message-input').val('').focus();
                pendingMessages.add(tempId);
                pendingMessageContents.add(messageKey);

                updateChatBox([tempMessage], true);
                if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

                let messageMarkedAsError = false;

                const response = await $.ajax({
                    url: "{{ route('chat.send') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        message: message,
                        receiver: chatWith,
                        timestamp: getCurrentTime()
                    },
                    cache: false,
                    timeout: 15000
                });

                if (response && response.success) {
                    const realMessageId = response.message.id;
                    const tempElement = document.getElementById(`msg-${tempId}`);
                    if (tempElement) {
                        tempElement.id = `msg-${realMessageId}`;
                        tempElement.setAttribute('data-message-saved', 'true');
                        tempElement.classList.remove('error-message');

                        const statusElement = tempElement.querySelector('.message-status');
                        if (statusElement) statusElement.innerHTML = '<span class="sent-status">Sent</span>';
                    }

                    pendingMessages.delete(tempId);
                    pendingMessageContents.delete(messageKey);
                    sentMessageIds.add(realMessageId.toString());
                    lastMessageId = Math.max(lastMessageId, realMessageId);

                    setTimeout(() => loadChatPartners(), 500);
                } else {
                    const tempElement = document.getElementById(`msg-${tempId}`);
                    if (tempElement) {
                        messageMarkedAsError = true;
                        tempElement.classList.add('error-message');
                        tempElement.setAttribute('data-message-error', 'true');
                        tempElement.style.backgroundColor = '#ffdddd';
                        tempElement.style.color = '#e74c3c';
                        tempElement.style.borderColor = '#e74c3c';

                        let errorMessage = response.error || 'Send failed';
                        const statusElement = tempElement.querySelector('.message-status');
                        if (statusElement) {
                            statusElement.style.color = '#e74c3c';
                            statusElement.innerHTML = `${errorMessage} <button class="retry-button">Retry</button>`;
                            const retryBtn = statusElement.querySelector('.retry-button');
                            if (retryBtn) {
                                retryBtn.onclick = (e) => {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    resendMessage(tempId, message);
                                };
                            }
                        }
                    }
                }
            } catch (error) {
                console.error('Message sending error:', error);

                const tempElement = document.getElementById(`msg-${tempId}`);
                if (tempElement) {
                    messageMarkedAsError = true;
                    tempElement.classList.add('error-message');
                    tempElement.setAttribute('data-message-error', 'true');
                    tempElement.style.backgroundColor = '#ffdddd';
                    tempElement.style.color = '#e74c3c';
                    tempElement.style.borderColor = '#e74c3c';

                    const statusElement = tempElement.querySelector('.message-status');
                    if (statusElement) {
                        let errorMessage = 'Send failed';
                        if (error.statusText === 'timeout' || error.message === 'Timeout') {
                            errorMessage = 'Timeout - slow network';
                        } else if (!navigator.onLine) {
                            errorMessage = 'Network connection error';
                        }

                        statusElement.style.color = '#e74c3c';
                        statusElement.innerHTML =
                            `${errorMessage} <button class="retry-button" data-message="${message.replace(/"/g, '"')}">Retry</button>`;
                        const retryBtn = statusElement.querySelector('.retry-button');
                        if (retryBtn) {
                            retryBtn.onclick = (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                resendMessage(tempId, message);
                            };
                        }
                    }
                }
            } finally {
                isSending = false;
                const msgElement = document.getElementById(`msg-${tempId}`);
                if (msgElement && !msgElement.querySelector('.message-status')?.textContent.includes('Sending')) {
                    pendingMessageContents.delete(messageKey);
                }
            }
        };

        /**
         * Gửi lại tin nhắn thất bại
         * @param {string} oldTempId - ID tạm thời của tin nhắn cũ
         * @param {string} originalMessage - Nội dung tin nhắn gốc
         */
        const resendMessage = (oldTempId, originalMessage) => {
            const oldElement = document.getElementById(`msg-${oldTempId}`);
            if (!oldElement) return;

            oldElement.classList.remove('error-message');
            oldElement.style.backgroundColor = '#0084ff';
            oldElement.style.color = 'white';
            oldElement.style.border = 'none';

            const statusElement = oldElement.querySelector('.message-status');
            if (statusElement) {
                statusElement.style.color = 'rgba(255, 255, 255, 0.8)';
                statusElement.innerHTML = 'Sending...';
            }

            oldElement.setAttribute('data-resending', 'true');
            oldElement.removeAttribute('data-message-error');

            $.ajax({
                url: "{{ route('chat.send') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    message: originalMessage,
                    receiver: chatWith,
                    timestamp: getCurrentTime(),
                    is_new_attempt: true
                },
                success: (response) => {
                    if (response && response.success) {
                        const newMsgId = response.message.id;
                        oldElement.id = `msg-${newMsgId}`;
                        oldElement.classList.remove('error-message');
                        oldElement.removeAttribute('data-message-error');
                        oldElement.removeAttribute('data-resending');
                        oldElement.setAttribute('data-message-saved', 'true');

                        oldElement.style.backgroundColor = '#0084ff';
                        oldElement.style.color = 'white';
                        oldElement.style.border = 'none';

                        if (statusElement) {
                            statusElement.style.color = 'rgba(255, 255, 255, 0.8)';
                            statusElement.innerHTML = '<span class="sent-status">Sent</span>';
                        }

                        lastMessageId = Math.max(lastMessageId, newMsgId);
                        sentMessageIds.add(newMsgId.toString());
                        loadChatPartners();
                    } else {
                        oldElement.classList.add('error-message');
                        oldElement.setAttribute('data-message-error', 'true');
                        oldElement.removeAttribute('data-resending');
                        oldElement.style.backgroundColor = '#ffdddd';
                        oldElement.style.color = '#050505';
                        oldElement.style.border = '1px solid #e74c3c';

                        let errorMsg = response.error || 'Send failed';
                        if (statusElement) {
                            statusElement.style.color = '#e74c3c';
                            statusElement.innerHTML =
                                `${errorMsg} <button class="retry-button">Retry</button>`;
                            const retryBtn = statusElement.querySelector('.retry-button');
                            if (retryBtn) {
                                retryBtn.onclick = (e) => {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    resendMessage(oldElement.id.replace('msg-', ''), originalMessage);
                                };
                            }
                        }
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Message sending error:', error);

                    oldElement.classList.add('error-message');
                    oldElement.setAttribute('data-message-error', 'true');
                    oldElement.removeAttribute('data-resending');
                    oldElement.style.backgroundColor = '#ffdddd';
                    oldElement.style.color = '#050505';
                    oldElement.style.border = '1px solid #e74c3c';

                    let errorMsg = 'Connection error';
                    if (status === 'timeout') errorMsg = 'Timeout - slow connection';
                    else if (!navigator.onLine) errorMsg = 'Network connection lost';

                    if (statusElement) {
                        statusElement.style.color = '#e74c3c';
                        statusElement.innerHTML = `${errorMsg} <button class="retry-button">Retry</button>`;
                        const retryBtn = statusElement.querySelector('.retry-button');
                        if (retryBtn) {
                            retryBtn.onclick = (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                resendMessage(oldElement.id.replace('msg-', ''), originalMessage);
                            };
                        }
                    }
                }
            });
        };

        /**
         * ===================================
         * 4. QUẢN LÝ TRẠNG THÁI
         * ===================================
         */

        const updateReadStatus = () => {
            $.ajax({
                url: '{{ route('chat.messages') }}',
                method: 'GET',
                data: {
                    receiver: chatWith,
                    check_read_status: true,
                    last_id: 0
                },
                success: (response) => {
                    if (response.success && response.messages) {
                        const readMessages = response.messages.filter(msg =>
                            isMessageFromCurrentUser(msg.sender, msg.sender_type) && msg.is_read
                        );

                        if (readMessages.length === 0) return;

                        const senderMessages = document.querySelectorAll(
                            '.message.sender:not(.error-message)');
                        senderMessages.forEach(messageElement => {
                            const messageId = messageElement.id.replace('msg-', '');
                            const isRead = readMessages.some(msg => String(msg.id) === messageId);

                            if (isRead && !messageElement.querySelector('.read-status')) {
                                const sentStatus = messageElement.querySelector('.message-status');
                                if (sentStatus) sentStatus.remove();

                                const readStatus = document.createElement('span');
                                readStatus.className = 'read-status';
                                readStatus.innerHTML =
                                    '<span class="double-tick"><i class="fas fa-check"></i><i class="fas fa-check"></i></span> Seen';
                                messageElement.appendChild(readStatus);
                            }
                        });
                    }
                }
            });
        };

        /**
         * Đánh dấu tất cả tin nhắn từ một người dùng là đã đọc
         * @param {string} senderEmail - Email người gửi
         */
        const markMessagesAsRead = (senderEmail) => {
            if (!senderEmail) return;

            $.ajax({
                url: "{{ route('mark.messages.read') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    sender_email: senderEmail
                },
                success: (response) => {
                    if (response.success) {
                        updateReadStatus();

                        const data = {
                            timestamp: Date.now(),
                            sender: senderEmail,
                            receiver: currentUser
                        };

                        localStorage.setItem('messages_marked_read', JSON.stringify(data));

                        const event = new CustomEvent('read_status_updated', {
                            detail: data
                        });
                        window.dispatchEvent(event);
                    }
                },
                error: (error) => {
                    console.error('Error marking messages as read:', error);
                }
            });
        };

        /**
         * ===================================
         * 5. QUẢN LÝ GIAO DIỆN NGƯỜI DÙNG
         * ===================================
         */

        /**
         * Chọn người dùng để bắt đầu chat
         * @param {string} email - Email người dùng được chọn
         */
        const selectUser = (email) => {
            if (!email || chatWith === email) return;

            const newUrl = new URL(window.location.href);
            newUrl.searchParams.set('user', email);
            history.pushState({}, '', newUrl.toString());

            messageCache.clear();
            const chatBox = document.getElementById('chat-box');
            if (!chatBox || !chatBox.querySelector('.message[id^="msg-"]')) lastMessageId = 0;

            Object.keys(sessionStorage).forEach(key => {
                if (key.startsWith('messages_')) sessionStorage.removeItem(key);
            });

            if (messagePollingInterval) clearInterval(messagePollingInterval);
            if (window.readStatusChecker) clearInterval(window.readStatusChecker);

            $(`.user-item[data-email="${email}"]`).find('.message-badge').text('0').hide();
            $('.user-item').removeClass('active');
            $(`.user-item[data-email="${email}"]`).addClass('active');

            chatWith = email;
            $('#chat-with-name').text(email);
            $('#chat-header-info').show();
            $('#message-input, #send-button').prop('disabled', false);

            $('#chat-box').html('<div class="loading-messages">Loading messages...</div>');

            setTimeout(() => {
                loadMessages();
                $('#message-input').focus();
                markMessagesAsRead(email);
                setupMessagePolling();
            }, 0);
        };

                /**
         * Tải danh sách người đã chat
         */
         const loadChatPartners = () => {
            $.ajax({
                url: "{{ route('chat.partners') }}",
                method: 'GET',
                success: (response) => {
                    if (response.success && response.partners?.length > 0) updateChatPartnersList(response
                        .partners);
                },
                error: (error) => console.error('Error loading chat partners:', error)
            });
        };

        /**
         * Cập nhật danh sách người chat trong sidebar
         * @param {Array} partners - Mảng thông tin người dùng
         */
        const updateChatPartnersList = (partners) => {
            const listElement = $('#chat-partners-list');
            listElement.empty();

            partners.forEach(partner => {
                const userItem = $(`
            <div class="user-item" data-email="${partner.email}" data-id="${partner.id}" id="user-${partner.email}">
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

                userItem.on('click', () => selectUser(partner.email));
                listElement.append(userItem);
                if (chatWith === partner.email) userItem.addClass('active');
            });

            if (partners.length === 0) listElement.html('<div class="no-users">No messages yet</div>');
        };

        /**
         * Cập nhật badge thông báo tin nhắn mới
         * @param {string} sender - Email người gửi
         * @param {string} message - Nội dung tin nhắn (thêm tham số mới)
         */
        const updateMessageBadge = (sender, message = '') => {
            if (chatWith === sender) return;

            const userId = sender.replace(/[@.]/g, '-');
            const userItem = $(`#user-${userId}`);

            if (userItem.length) {
                const badge = userItem.find('.message-badge');
                const currentCount = parseInt(badge.text()) || 0;
                badge.text(currentCount + 1).show();
            }

            if (message) {
                const notificationContainer = $('#notification-container');
                const truncatedMessage = message.length > 30 ? message.substring(0, 30) + '...' : message;

                const notification = $(`
            <div class="notification">
                <div class="notification-icon">
                    <i class="fas fa-comment"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">New message from ${sender}</div>
                    <div class="notification-message">${truncatedMessage}</div>
                </div>
            </div>
        `);

                notification.on('click', () => selectUser(sender));
                notificationContainer.append(notification);
                setTimeout(() => notification.remove(), 5000);
            }

            $.ajax({
                url: "{{ route('get.unread.count') }}",
                type: "GET",
                cache: false,
                success: (response) => {
                    if (response.success) {
                        localStorage.setItem('unread_count_updated', JSON.stringify({
                            timestamp: Date.now(),
                            count: response.unread_count,
                            sender: currentUser,
                            receiver: sender
                        }));

                        const updateEvent = new CustomEvent('unread_count_updated', {
                            detail: {
                                timestamp: Date.now(),
                                count: response.unread_count,
                                sender: currentUser,
                                receiver: sender
                            }
                        });
                        window.dispatchEvent(updateEvent);

                        if (response.unread_count > 0) {
                            try {
                                const navBadge = document.getElementById('unread-badge');
                                if (navBadge) {
                                    navBadge.textContent = response.unread_count;
                                    navBadge.style.display = 'flex';
                                }
                                $('.chatbox-item .nav-link').addClass('message-pulse');
                            } catch (e) {
                                console.error("Error updating badge directly:", e);
                            }
                        }
                    }
                }
            });
        };

                /**
         * Thiết lập cơ chế kiểm tra tin nhắn mới và trạng thái đã đọc định kỳ
         */
         const setupMessagePolling = () => {
            if (messagePollingInterval) clearInterval(messagePollingInterval);
            if (window.readStatusChecker) clearInterval(window.readStatusChecker);

            const REALTIME_POLL_INTERVAL = APP_CONSTANTS.REALTIME_POLL_INTERVAL;

            messagePollingInterval = setInterval(() => {
                if (!document.hidden && chatWith) {
                    $.ajax({
                        url: "{{ route('chat.messages') }}",
                        method: 'GET',
                        data: {
                            receiver: chatWith,
                            last_id: lastMessageId,
                            limit: 10,
                            timestamp: Date.now()
                        },
                        cache: false,
                        success: (response) => {
                            if (response?.messages?.length > 0) {
                                const newMessages = response.messages.filter(msg => msg.id >
                                    lastMessageId);
                                if (newMessages.length > 0) {
                                    requestAnimationFrame(() => {
                                        newMessages.sort((a, b) => a.id - b.id);
                                        updateChatBox(newMessages, true);

                                        const chatBox = document.getElementById('chat-box');
                                        const isNearBottom = chatBox.scrollHeight - chatBox
                                            .clientHeight - chatBox.scrollTop < 100;
                                        if (isNearBottom) chatBox.scrollTop = chatBox
                                            .scrollHeight;
                                    });
                                }

                                const hasReadMessages = response.messages.some(msg =>
                                    isMessageFromCurrentUser(msg.sender, msg.sender_type) && msg
                                    .is_read
                                );
                                if (hasReadMessages) updateReadStatus();

                                response.messages.forEach(msg => lastMessageId = Math.max(
                                    lastMessageId, msg.id));
                            }
                        },
                        error: (error) => console.error("Error checking new messages:", error)
                    });
                }
            }, REALTIME_POLL_INTERVAL);

            window.readStatusChecker = setInterval(() => {
                if (!chatWith) {
                    clearInterval(window.readStatusChecker);
                    return;
                }

                $.ajax({
                    url: '{{ route('chat.messages') }}',
                    method: 'GET',
                    data: {
                        receiver: chatWith,
                        check_read_status: true,
                        last_id: 0
                    },
                    success: (response) => {
                        if (response.success && response.messages) updateReadStatus();
                    },
                    error: (error) => console.error('Error checking read status:', error)
                });
            }, 3000);

            const visibilityHandler = () => {
                if (!document.hidden && chatWith) loadMessages(true);
            };

            document.removeEventListener('visibilitychange', visibilityHandler);
            document.addEventListener('visibilitychange', visibilityHandler);
        };

                /**
         * ===================================
         * 8. KHỞI TẠO VÀ XỬ LÝ SỰ KIỆN
         * ===================================
         */
         $(document).ready(() => {
            $('.tab-button').on('click', function() {
                $('.tab-button').removeClass('active');
                $('.tab-content').removeClass('active');
                $(this).addClass('active');

                const tabName = $(this).data('tab');
                if (tabName === 'chat') $('#chat-partners-list').addClass('active');
                else $('#all-users-list').addClass('active');
            });

            $(document).on('click', '.user-item', function() {
                const email = $(this).data('email');
                if (email) selectUser(email);
            });

            $('#sidebar-search-input').on('keyup', function() {
                const query = $(this).val().trim().toLowerCase();
                if (query === '') return $('.user-item').show();

                $('.user-item').each(function() {
                    const email = $(this).data('email').toLowerCase();
                    const name = $(this).find('.user-name').text().toLowerCase();
                    const type = $(this).find('.user-type').text().toLowerCase();
                    $(this).toggle(email.includes(query) || name.includes(query) || type.includes(
                        query));
                });
            });

            $('#message-input').on('keypress', (e) => {
                if (e.which === 13) {
                    sendMessage();
                    return false;
                }
            });

            window.addEventListener('storage', (e) => {
                if (e.key === 'new_message_sent') {
                    const data = JSON.parse(e.newValue || '{}');
                    const now = Date.now();

                    if (data && now - data.timestamp < 10000 && data.receiver === currentUser) {
                        if (chatWith === data.sender) {
                            if (messagePollingInterval) clearInterval(messagePollingInterval);
                            loadMessages(true);
                            setupMessagePolling();
                        } else {
                            updateMessageBadge(data.sender, data.content);
                        }
                    }
                }
            });

            const initializeChat = () => {
                const urlParams = new URLSearchParams(window.location.search);
                const userParam = urlParams.get('user');
                const storedUser = localStorage.getItem('selected_chat_user');

                if (userParam) selectUser(userParam);
                else if (storedUser) {
                    selectUser(storedUser);
                    localStorage.removeItem('selected_chat_user');
                }

                loadChatPartners();
                setInterval(() => {
                    if (!document.hidden) loadChatPartners();
                }, 30000);
            };

            initializeChat();
        });
    </script>
</body>

</html>
