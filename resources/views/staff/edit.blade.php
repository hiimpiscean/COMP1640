@extends('masters.dashboardMaster')

@section('main')
  <div class="container">
    <h2 class="my-4">Sửa nhân viên</h2>

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
        <input type="password" name="old_password" class="form-control" >
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu mới</label>
        <input type="password" name="password" class="form-control" >
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm New Password</label>
        <input type="password" name="password_confirmation" class="form-control" >
      </div>
      <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
  </div>
@endsection
