<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đặt lại mật khẩu</title>
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
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00bcd4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
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
        <h2>Xin chào {{ $user->fullname_c ?? $user->fullname_t ?? $user->fullname_s ?? 'Quý khách' }},</h2>
        
        <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn tại ATN Website Courses.</p>
        
        <p>Vui lòng click vào nút bên dưới để đặt lại mật khẩu:</p>
        
        <a href="{{ $resetLink }}" class="button">Đặt lại mật khẩu</a>
        
        <p><strong>Lưu ý:</strong> Link này sẽ hết hạn sau 1 giờ.</p>
        
        <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
        
        <div class="footer">
            <p>Đây là email tự động, vui lòng không trả lời email này.</p>
            <p>ATN Website Courses</p>
        </div>
    </div>
</body>
</html>
