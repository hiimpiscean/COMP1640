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

    .btn-primary {
      display: block;
      width: 100%;
      padding: 10px;
      background: #f5a623;
      border: none;
      color: #fff;
      font-size: 1rem;
      border-radius: 5px;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
      background: #e6951d;
      transform: scale(1.05);
    }

    .btn-info {
      display: block;
      width: 100%;
      padding: 10px;
      background: #60a6dd;
      border: none;
      color: #fff;
      font-size: 1rem;
      border-radius: 5px;
      text-align: center;
      transition: background 0.3s ease, transform 0.2s ease;
      margin-top: 10px;
    }

    .btn-info:hover {
      background: #394e64;
      transform: scale(1.05);
    }
  </style>

  <div class="form-container">
    <h2>Thêm nhân viên</h2>

    @if($errors->any())
      <div class="alert alert-danger">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form action="{{ route('staff.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Tên đăng nhập</label>
        <input type="text" class="form-control" name="username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Họ và Tên</label>
        <input type="text" class="form-control" name="fullname_s" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Số điện thoại</label>
        <input type="text" class="form-control" name="phone_s" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Xác nhận mật khẩu</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>
      <button type="submit" class="btn-primary">Thêm</button>
      <a href="{{ route('staff.index') }}" class="btn btn-info">Cancel</a>
    </form>
  </div>
@endsection
