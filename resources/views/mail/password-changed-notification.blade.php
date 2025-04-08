<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thông báo thay đổi mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background: #f9f9f9;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
        }
        .footer {
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thông báo thay đổi mật khẩu</h2>
        
        <p>Một người dùng vừa thay đổi mật khẩu của họ:</p>
        
        <ul>
            <li><strong>Tên người dùng:</strong> {{ $user->fullname_c ?? $user->fullname_t ?? $user->fullname_s ?? 'N/A' }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Vai trò:</strong> {{ ucfirst($role) }}</li>
            <li><strong>Thời gian thay đổi:</strong> {{ $changedAt->format('d/m/Y H:i:s') }}</li>
        </ul>
        
        <div class="footer">
            <p>Đây là email tự động, vui lòng không trả lời email này.</p>
            <p>ATN Website Courses</p>
        </div>
    </div>
</body>
</html>
