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
            font-size: 11px;
            text-align: right;
            margin-top: 2px;
            color: #65676b;
        }

        .message-time {
            color: #65676b;
            font-size: 12px;
            margin-top: 5px;
            display: inline-block;
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
                <div class="sidebar-search">
                    <input type="text" id="sidebar-search-input" placeholder="Tìm kiếm người dùng...">
                </div>
                <div class="users-list" id="users-list">
                    @if (isset($users) && count($users) > 0)
                        @foreach ($users as $user)
                            <div class="user-item" data-email="{{ $user->email }}" id="user-{{ $user->email }}">
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

        // Tối ưu việc cập nhật DOM
        const updateChatBox = debounce((messages) => {
            const fragment = document.createDocumentFragment();
            const chatBox = document.getElementById('chat-box');
            const existingMessageIds = new Set(Array.from(chatBox.children)
                .map(el => el.id?.replace('msg-', '')));

            messages.forEach(msg => {
                // Kiểm tra xem tin nhắn đã tồn tại chưa
                if (existingMessageIds.has(msg.id.toString())) return;

                const messageDiv = document.createElement('div');
                const isCurrentUser = isMessageFromCurrentUser(msg.sender, msg.sender_type);
                messageDiv.id = `msg-${msg.id}`;
                messageDiv.className = `message ${isCurrentUser ? 'sender' : 'receiver'}`;
                messageDiv.innerHTML = `
            ${msg.text}
            <span class="timestamp">${msg.timestamp}</span>
        `;
                fragment.appendChild(messageDiv);
            });

            // Chỉ cập nhật DOM nếu có tin nhắn mới
            if (fragment.children.length > 0) {
                // Nếu đang hiển thị "Đang tải tin nhắn...", xóa nó đi
                const loadingMsg = chatBox.querySelector('.loading-messages');
                if (loadingMsg) {
                    chatBox.innerHTML = '';
                }

                chatBox.appendChild(fragment);
                requestAnimationFrame(() => {
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
            }
        }, DOM_UPDATE_DEBOUNCE);

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

        // Tối ưu hàm gửi tin nhắn
        async function sendMessage() {
            if (isSending) {
                return;
            }

            const message = $('#message-input').val().trim();
            if (!message || !chatWith) return;

            isSending = true;
            const tempId = 'temp-' + Date.now();
            pendingMessages.add(tempId);

            // Hiển thị tin nhắn tạm thời
            const tempMessage = {
                id: tempId,
                text: message,
                sender: currentUser,
                timestamp: getCurrentTime(),
                status: 'sending'
            };

            // Thêm vào cache tạm thời
            messageCache.set(tempId, tempMessage);
            updateChatBox([tempMessage]);

            // Clear input ngay lập tức
            $('#message-input').val('').focus();

            try {
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
                    new Promise((_, reject) => setTimeout(() => reject(new Error('Timeout')), 5000))
                ]);

                if (response.success) {
                    const realMessageId = response.message.id;
                    pendingMessages.delete(tempId);
                    messageCache.delete(tempId);
                    messageCache.set(realMessageId, {
                        ...response.message,
                        status: 'sent'
                    });

                    // Cập nhật UI
                    const tempElement = document.getElementById(tempId);
                    if (tempElement) {
                        tempElement.id = `msg-${realMessageId}`;
                        const statusElement = tempElement.querySelector('.message-status');
                        if (statusElement) {
                            statusElement.textContent = 'Đã gửi';
                            setTimeout(() => statusElement.style.display = 'none', 300);
                        }
                    }

                    lastMessageId = Math.max(lastMessageId, realMessageId);
                } else {
                    throw new Error(response.error || 'Lỗi gửi tin nhắn');
                }
            } catch (error) {
                console.error('Lỗi gửi tin nhắn:', error);
                const tempElement = document.getElementById(tempId);
                if (tempElement) {
                    tempElement.style.backgroundColor = '#ffdddd';
                    const statusElement = tempElement.querySelector('.message-status');
                    if (statusElement) {
                        statusElement.textContent = `Lỗi: ${error.message}`;
                    }
                }
            } finally {
                isSending = false;
                if (messageQueue.length > 0) {
                    const nextMessage = messageQueue.shift();
                    sendMessage(nextMessage);
                }
            }
        }

        // Tối ưu hàm load tin nhắn
        async function loadMessages(isBackgroundUpdate = false) {
            if (!chatWith) return;

            const now = Date.now();
            if (isBackgroundUpdate && (now - lastPollTime < POLL_INTERVAL)) {
                return;
            }
            lastPollTime = now;

            // Chỉ hiển thị loading khi load lần đầu
            if (!isBackgroundUpdate) {
                $('#chat-box').html('<div class="loading-messages">Đang tải tin nhắn...</div>');
            }

            try {
                const response = await $.ajax({
                    url: "{{ route('chat.messages') }}",
                    method: 'GET',
                    data: {
                        receiver: chatWith,
                        last_id: isBackgroundUpdate ? lastMessageId : 0,
                        limit: MESSAGE_BATCH_SIZE
                    },
                    cache: false
                });

                if (!response || !response.messages) {
                    if (!isBackgroundUpdate) {
                        $('#chat-box').html('<div class="no-messages">Chưa có tin nhắn nào</div>');
                    }
                    return;
                }

                const messages = response.messages;
                if (!isBackgroundUpdate && messages.length === 0) {
                    $('#chat-box').html('<div class="no-messages">Chưa có tin nhắn nào</div>');
                    return;
                }

                // Thêm kiểm tra trùng lặp tin nhắn
                const uniqueMessages = messages.filter(msg => {
                    const isDuplicate = messageCache.has(msg.id);
                    if (!isDuplicate) {
                        messageCache.set(msg.id, msg);
                        if (msg.id > lastMessageId) {
                            lastMessageId = msg.id;
                        }
                    }
                    return !isDuplicate;
                });

                // Chỉ cập nhật UI nếu có tin nhắn mới
                if (uniqueMessages.length > 0) {
                    updateChatBox(uniqueMessages);
                }

                // Xử lý thông báo cho tin nhắn mới
                if (isBackgroundUpdate) {
                    uniqueMessages.forEach(msg => {
                        if (!isMessageFromCurrentUser(msg.sender, msg.sender_type)) {
                            showNotification(msg.sender, msg.text);
                        }
                    });
                }

            } catch (error) {
                console.error("Lỗi khi tải tin nhắn:", error);
                if (!isBackgroundUpdate) {
                    $('#chat-box').html(
                        '<div class="error-messages">Không thể tải tin nhắn. Vui lòng thử lại sau.</div>');
                }
            }
        }

        // Tối ưu hàm polling
        function setupMessagePolling() {
            if (messagePollingInterval) {
                clearInterval(messagePollingInterval);
            }

            messagePollingInterval = setInterval(() => {
                if (document.hidden) return; // Không poll khi tab không active
                loadMessages(true);
            }, POLL_INTERVAL);

            // Thêm listener cho visibility change
            document.addEventListener('visibilitychange', () => {
                if (!document.hidden && chatWith) {
                    loadMessages(true);
                }
            });
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

            // Xử lý khi click vào người dùng trong danh sách
            $(document).on('click', '.user-item', function() {
                $(this).find('.message-badge').text('0').hide();

                const email = $(this).data('email');
                if (email) {
                    // Đánh dấu người dùng đang được chọn
                    $('.user-item').removeClass('active');
                    $(this).addClass('active');

                    chatWith = email;
                    $('#chat-with-name').text(email);
                    $('#chat-header-info').show();
                    $('#message-input, #send-button').prop('disabled', false);

                    // Tải tin nhắn và focus vào ô nhập liệu
                    loadMessages();
                    $('#message-input').focus();

                    // Thiết lập polling cho tin nhắn mới
                    setupMessagePolling();
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

            const userItem = $(`#user-${sender}`);
            if (userItem.length) {
                const badge = userItem.find('.message-badge');
                const currentCount = parseInt(badge.text()) || 0;
                badge.text(currentCount + 1);
                badge.show();
            }
        }
    </script>
</body>

</html>
