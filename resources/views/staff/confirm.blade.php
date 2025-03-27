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
    }
    a {
      color: inherit;
      transition: color 0.3s ease;
    }
    a:focus, a:hover {
      text-decoration: none;
    }

    /* Layout */
    .staff-container {
      padding: 2rem;
      max-width: 100%;
      overflow-x: auto;
    }

    .staff-details {
      background: #50697f;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      margin-bottom: 20px;
    }

    .staff-details p {
      font-size: 1rem;
      margin-bottom: 1rem;
      border-bottom: 1px solid #415a70;
      padding-bottom: 0.5rem;
    }

    .button-group {
      display: flex;
      gap: 15px;
    }

    .btn-secondary, .btn-danger {
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

    .btn-secondary {
      background: #394e64;
      color: #fff;
    }

    .btn-secondary:hover {
      background: #f5a623;
    }

    .btn-danger {
      background: #d9534f;
      color: #fff;
    }

    .btn-danger:hover {
      background: #c9302c;
    }
  </style>

  <div class="staff-container">
    <h2 class="text-danger">Xác nhận xóa nhân viên</h2>
    <p>Bạn có chắc chắn muốn xóa nhân viên <strong>{{ $staff->fullname_s }}</strong> không?</p>

    <div class="staff-details">
      <p><strong>ID:</strong> {{ $staff->id_s }}</p>
      <p><strong>Tên đăng nhập:</strong> {{ $staff->username }}</p>
      <p><strong>Họ và Tên:</strong> {{ $staff->fullname_s }}</p>
      <p><strong>Email:</strong> {{ $staff->email }}</p>
      <p><strong>Số điện thoại:</strong> {{ $staff->phone_s }}</p>
    </div>

    <form action="{{ route('staff.destroy', $staff->id_s) }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="button-group">
        <button type="submit" class="btn-danger">Xóa</button>
        <a href="{{ route('staff.index') }}" class="btn-secondary">Hủy</a>
      </div>
    </form>
  </div>
@endsection
