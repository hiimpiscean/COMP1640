@extends('masters.dashboardMaster')

@section('main')
  <style>
    /* Global Reset */
    *, *::before, *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      background: #4e657a;
      color: #fff;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    a {
      color: inherit;
      transition: color 0.3s ease;
    }
    a:focus, a:hover {
      text-decoration: none;
    }

    /* Layout */
    .form-container {
      padding: 2rem;
      width: 1000px;
      margin: auto;
      background: #50697f;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    /* Form Styling */
    .form-label {
      font-weight: bold;
      display: block;
      margin-bottom: 0.5rem;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #415a70;
      border-radius: 5px;
      background: #394e64;
      color: #fff;
      margin-bottom: 1rem;
      height: auto !important;
    }

    .button-group {
      display: flex;
      gap: 15px;
      justify-content: space-evenly;
    }

    .btn-primary, .btn-info {
      width: 120px; /* Đảm bảo cả hai nút có cùng kích thước */
      text-align: center;
      padding: 10px;
      border-radius: 5px;
      text-decoration: none;
      transition: background 0.3s ease;
      border: none;
      cursor: pointer;
      font-size: 1rem;
    }

    .btn-primary {
      background: #f5a623;
      color: #fff;
    }

    .btn-primary:hover {
      background: #e6951d;
    }

    .btn-info {
      background: #60a6dd;
      color: #fff;
    }

    .btn-info:hover {
      background: #394e64;
    }
  </style>

  <div class="form-container">
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
      <div class="button-group">
        <button type="submit" class="btn-primary">Lưu</button>
        <a href="{{ route('teacher.index') }}" class="btn-info">Cancel</a>
      </div>
    </form>
  </div>
@endsection
