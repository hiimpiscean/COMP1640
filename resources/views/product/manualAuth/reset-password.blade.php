<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        .reset-container {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .reset-header {
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            color: #00bcd4;
            margin-bottom: 25px;
        }
        .brand {
            text-align: center;
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
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            font-weight: 500;
            color: #555;
            margin-bottom: 10px;
            font-size: 15px;
        }
        .form-control {
            height: auto;
            padding: 12px 25px;
            font-size: 15px;
            border-radius: 30px;
            border: 2px solid #eee;
            background: #f8f9fa;
            transition: all 0.3s ease;
            color: #495057;
        }
        .form-control:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.15);
            background: #fff;
        }
        .form-control[readonly] {
            background-color: #f8f9fa;
            border-color: #eee;
            color: #666;
            cursor: default;
        }
        .btn-primary {
            width: 100%;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 30px;
            background: #00bcd4;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 188, 212, 0.2);
        }
        .btn-primary:hover {
            background: #008ba3;
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(0, 188, 212, 0.3);
        }
        .btn-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.25);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
        .alert {
            border-radius: 15px;
            margin-bottom: 25px;
            padding: 15px 20px;
        }
        .alert-danger {
            background-color: #fff5f5;
            border-color: #ffd4d4;
            color: #dc3545;
        }
        .alert-danger ul {
            margin-bottom: 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
<div class="reset-container">
    <div class="reset-header">Reset Password</div>
    <a class="brand" href="{{ route('ui.index') }}">ATN Website Courses</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="{{ $email }}" readonly>
        </div>

        <div class="form-group">
            <label>New Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 