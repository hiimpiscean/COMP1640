<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbox</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .chat-container {
            display: flex;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 80vh;
        }

        .chat-header {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .search-container {
            position: relative;
            margin: 10px 0;
        }

        .search-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 0 0 4px 4px;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-results.show {
            display: block !important;
        }

        .search-result-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .search-result-item:hover {
            background-color: #f5f5f5;
        }

        .selected-user {
            margin-top: 10px;
            padding: 10px;
            background-color: #f0f7ff;
            border-radius: 4px;
            border-left: 3px solid #3490dc;
        }

        .chat-box-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .chat-box {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background-color: #f9f9f9;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            max-width: 70%;
            word-wrap: break-word;
        }

        .sender {
            background-color: #dcf8c6;
            margin-left: auto;
            border-radius: 10px 0 10px 10px;
        }

        .receiver {
            background-color: #f1f0f0;
            margin-right: auto;
            border-radius: 0 10px 10px 10px;
        }

        .timestamp {
            font-size: 11px;
            color: #777;
            margin-left: 5px;
        }

        .message-input-container {
            display: flex;
            padding: 10px;
            border-top: 1px solid #eee;
            background-color: #fff;
        }

        .message-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 10px;
        }

        .send-button {
            padding: 10px 20px;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .send-button:hover {
            background-color: #2779bd;
        }

        .send-button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .no-messages {
            text-align: center;
            color: #777;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .chat-container {
                flex-direction: column;
                height: auto;
            }

            .chat-box {
                height: 400px;
            }

            .message {
                max-width: 85%;
            }
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
            <div class="search-container">
                <input type="text" id="search-input" class="search-input" placeholder="Nhập email để tìm kiếm người dùng...">
                <div id="search-results" class="search-results"></div>
            </div>
            <div id="selected-user" class="selected-user" style="display: none;">
                <p>Đang chat với: <strong id="chat-with-name"></strong></p>
            </div>
        </div>

        <div class="chat-container">
            <div class="chat-box-container" style="width: 100%;">
                <div id="chat-box" class="chat-box">
                    <div class="no-messages">Tìm kiếm và chọn một người dùng để bắt đầu chat</div>
                </div>
                <div class="message-input-container">
                    <input type="text" id="message-input" class="message-input" placeholder="Nhập tin nhắn..." disabled>
                    <button id="send-button" class="send-button" disabled>Gửi</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const currentUser = "{{ Session::get('username') }}";
        let chatWith = null;

        $(document).ready(function() {
            let searchTimeout;
            
            $(document).on('click', '.search-result-item', function() {
                const email = $(this).data('email');
                if (email) {
                    chatWith = email;
                    $('#chat-with-name').text(email);
                    $('#selected-user').show();
                    $('#message-input, #send-button').prop('disabled', false);
                    
                    $('#search-results').removeClass('show').empty();
                    $('#search-input').val('');
                    
                    loadMessages();
                }
            });
            
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
                        data: { query: query },
                        success: function(response) {
                            let results = '';
                            
                            if (!response.success || !response.users || response.users.length === 0) {
                                results = '<div class="search-result-item">Không tìm thấy người dùng</div>';
                            } else {
                                response.users.forEach(user => {
                                    let displayText = `${user.email} - ${user.type}`;
                                    results += `<div class="search-result-item" data-email="${user.email}">${displayText}</div>`;
                                });
                            }
                            
                            $('#search-results').html(results);
                            $('#search-results').addClass('show');
                        },
                        error: function(error) {
                            $('#search-results').html('<div class="search-result-item">Lỗi khi tìm kiếm</div>');
                            $('#search-results').addClass('show');
                        }
                    });
                }, 500);
            });
            
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-container').length) {
                    $('#search-results').removeClass('show').empty();
                }
            });

            $('#send-button').on('click', function() {
                if (!chatWith) {
                    alert('Vui lòng chọn người nhận trước khi gửi tin nhắn');
                    return;
                }

                let message = $('#message-input').val().trim();
                if (!message) {
                    alert('Vui lòng nhập tin nhắn');
                    return;
                }

                $('#send-button').prop('disabled', true).text('Đang gửi...');

                $.ajax({
                    url: "{{ route('chat.send') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        message: message,
                        receiver: chatWith
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#message-input').val('').focus();
                            loadMessages();
                        } else {
                            alert("Lỗi: " + (response.error || "Không thể gửi tin nhắn"));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Lỗi khi gửi tin nhắn. Vui lòng thử lại sau.");
                    },
                    complete: function() {
                        $('#send-button').prop('disabled', false).text('Gửi');
                    }
                });
            });
            
            $('#message-input').keypress(function(e) {
                if (e.which === 13) {
                    $('#send-button').trigger('click');
                    return false;
                }
            });
            
            setInterval(function() {
                if (chatWith) {
                    loadMessages();
                }
            }, 5000);
        });

        function loadMessages() {
            if (!chatWith) {
                return;
            }
    
            $.get("{{ route('chat.messages') }}", { receiver: chatWith }, function(response) {
                if (!response || !response.messages) {
                    return;
                }
                
                let messages = response.messages;
                let chatBox = $('#chat-box');
                chatBox.html('');
    
                if (messages.length === 0) {
                    chatBox.html('<div class="no-messages">Chưa có tin nhắn nào</div>');
                    return;
                }
    
                messages.forEach(msg => {
                    let currentUsername = "{{ Session::get('username') }}".toLowerCase().trim();
                    let senderEmail = msg.sender ? msg.sender.toLowerCase().trim() : '';
                    let senderType = msg.sender_type;
                    
                    // Force admin messages to always be on the right (sender) for admin user
                    let isSentByCurrentUser = false;
                    
                    // Nếu người dùng hiện tại là admin (kiểm tra username)
                    if (currentUsername.includes('admin')) {
                        // Nếu tin nhắn được gửi bởi admin
                        if (senderType === 'admin') {
                            // Đối với admin, hiển thị tất cả tin nhắn của admin ở bên phải
                            isSentByCurrentUser = true;
                        }
                    } 
                    // Nếu người dùng hiện tại không phải admin
                    else {
                        // So sánh email hoặc username
                        if (senderEmail === currentUsername || 
                            senderEmail.startsWith(currentUsername + "@") || 
                            (senderEmail.includes("@") && currentUsername === senderEmail.split("@")[0])) {
                            isSentByCurrentUser = true;
                        }
                    }
                    
                    let className = isSentByCurrentUser ? "sender" : "receiver";
                    let formattedMessage = `
                    <div class="message ${className}">
                        <strong>${msg.sender}:</strong> ${msg.text} 
                        <span class="timestamp">(${msg.timestamp})</span>
                    </div>`;
    
                    chatBox.append(formattedMessage);
                });
                
                chatBox.scrollTop(chatBox[0].scrollHeight);
            }).fail(function(error) {
            });
        }
    </script>
</body>

</html>