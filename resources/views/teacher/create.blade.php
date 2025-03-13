@extends('masters.dashboardMaster')

@section('main')
  <style>
    /* Centering Form */
    html, body {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f8f9fa;
    }

    /* Form Styling */
    .container {
      max-width: 500px;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      color: #333;
    }
    .form-label {
      font-weight: bold;
      color: #555;
    }
    .form-control {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      width: 100%;
    }
    .btn-success {
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      border: none;
      border-radius: 5px;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .btn-success:hover {
      background-color: #218838;
    }
  </style>

  <div class="container">
    <h2>Thêm Giáo Viên</h2>
    @include('partials.errors')
    <form action="{{ route('teacher.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Họ và Tên</label>
        <input type="text" name="fullname_t" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Số điện thoại</label>
        <input type="text" name="phone_t" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">Lưu</button>
      <a href="{{ route('teacher.index') }}" class="btn btn-info">Cancel</a>
    </form>
  </div>
@endsection
