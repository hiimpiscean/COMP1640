<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Đăng Ký Sinh Viên</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 400px;
    }
    h2 {
      text-align: center;
    }
    label {
      font-weight: bold;
    }
    input, select {
      width: 100%;
      padding: 8px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background: #218838;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>Form Đăng Ký Sinh Viên</h2>
  <form action="#" method="post">
    <label for="name">Họ và tên:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="phone">Số điện thoại:</label>
    <input type="tel" id="phone" name="phone" required>

    <label for="dob">Ngày sinh:</label>
    <input type="date" id="dob" name="dob" required>

    <label for="gender">Giới tính:</label>
    <select id="gender" name="gender">
      <option value="male">Nam</option>
      <option value="female">Nữ</option>
      <option value="other">Khác</option>
    </select>

    <label for="course">Khóa học:</label>
    <input type="text" id="course" name="course" required>

    <button type="submit">Đăng Ký</button>
  </form>
</div>
</body>
</html>
