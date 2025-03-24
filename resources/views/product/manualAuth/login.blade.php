<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
    }
    .login-container {
      width: 100%;
      max-width: 400px;
      background: #ffffff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }
    .login-header {
      text-align: center;
      font-size: 24px;
      font-weight: 600;
      color: #00bcd4;
    }

    .brand {
      text-align: center;
      font-size: 24px;
      display: block;
      margin: 10px;
    }
    .brand:hover {
      text-decoration: none;
    }

    .form-control {
      border-radius: 30px;
      padding: 10px 15px;
    }
    .btn-primary {
      width: 100%;
      border-radius: 30px;
      background: #00bcd4;
      border: none;
      padding: 10px;
      font-weight: 600;
      transition: 0.3s;
    }
    .btn-primary:hover {
      background: #008ba3;
    }
    .text-center a {
      color: #00bcd4;
      font-weight: 600;
      text-decoration: none;
    }
    .text-center a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
<div class="login-container">
  <div class="login-header">Sign In</div>
  <a class="brand" href="{{ route('ui.index') }}">ATN Website Courses</a>
  <form action="{{route('auth.signin')}}" method="post">
    @csrf
    <div class="form-group">
      <label>Email</label>
      <input type="text" class="form-control" name="login" required>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" class="form-control" name="password" required>
    </div>
    <div class="form-group form-check">
      <input type="checkbox" class="form-check-input" name="remember">
      <label class="form-check-label">Remember Me</label>
    </div>
    <button type="submit" class="btn btn-primary">Sign In</button>
    <div class="text-center mt-3">
      <a href="#">Forgot Your Password?</a>
    </div>
  </form>
</div>
</body>
</html>
