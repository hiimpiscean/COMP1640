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
      font-family: 'Roboto', Helvetica, Arial, sans-serif;
      background: #4e657a;
      color: #fff;
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
      max-width: 600px;
      margin: auto;
      background: #50697f;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      margin-top: 30px;
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
  </style>

  <div class="form-container">
    <h2>Sửa nhân viên</h2>
    @include('partials.errors')

    <form action="{{ route('staff.update', $staff->id_s) }}" method="POST">
      @csrf
      @method('PUT')

      <input type="hidden" name="id_s" value="{{ $staff->id_s }}">

      <div class="mb-3">
        <label class="form-label">Tên đăng nhập</label>
        <input type="text" class="form-control" name="username" value="{{ $staff->username }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Họ và Tên</label>
        <input type="text" class="form-control" name="fullname_s" value="{{ $staff->fullname_s }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="{{ $staff->email }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Số điện thoại</label>
        <input type="text" class="form-control" name="phone_s" value="{{ $staff->phone_s }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu cũ</label>
        <input type="password" name="old_password" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu mới</label>
        <input type="password" name="password" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Xác nhận mật khẩu mới</label>
        <input type="password" name="password_confirmation" class="form-control">
      </div>
      <button type="submit" class="btn-primary">Cập nhật</button>
      <a href="{{ route('staff.index') }}" class="btn btn-info">Cancel</a>
    </form>
  </div>
@endsection
