<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Success</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #00bcd4, #008ba3);
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .success-container {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .success-header {
            font-size: 28px;
            font-weight: 600;
            color: #00bcd4;
            margin-bottom: 25px;
        }
        .brand {
            font-size: 26px;
            display: block;
            margin: 15px 0 30px;
            color: #333;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .brand:hover {
            color: #00bcd4;
            text-decoration: none;
            transform: scale(1.02);
        }
        .success-icon {
            font-size: 60px;
            color: #2f855a;
            margin: 20px 0;
        }
        .success-message {
            color: #2f855a;
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .btn-primary {
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 30px;
            background: #00bcd4;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 188, 212, 0.2);
            display: inline-block;
            text-decoration: none;
            color: white;
        }
        .btn-primary:hover {
            background: #008ba3;
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(0, 188, 212, 0.3);
            color: white;
            text-decoration: none;
        }
        .btn-primary:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
<div class="success-container">
    <div class="success-header">Password Reset</div>
    <a class="brand" href="{{ route('ui.index') }}">ATN Website Courses</a>
    
    <div class="success-icon">✓</div>
    <div class="success-message">
        Your password has been reset successfully!<br>
        You can now login with your new password.
    </div>
    
    <a href="{{ route('auth.ask') }}" class="btn btn-primary">Back to Login</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 