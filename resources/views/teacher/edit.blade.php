@extends('masters.dashboardMaster')

@section('main')
  <div class="container">
    <h2>Chỉnh Sửa Giáo Viên</h2>
    {{-- Hiển thị thông báo thành công hoặc lỗi --}}
    @if (session('msg'))
      <div class="alert alert-success">
        {{ session('msg') }}
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    @include('partials.errors')
    <form action="{{ route('teacher.edit', $teacher->id_t) }}" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" name="id_t" value="{{ $teacher->id_t }}">
      <div class="mb-3">
        <label class="form-label">Họ và Tên</label>
        <input type="text" name="fullname_t" class="form-control" value="{{ $teacher->fullname_t }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Số điện thoại</label>
        <input type="text" name="phone_t" class="form-control" value="{{ $teacher->phone_t }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $teacher->email }}" required>
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
      <button type="submit" class="btn btn-primary">Cập Nhật</button>
      <a href="{{ route('teacher.index') }}" class="btn btn-info cancel">Cancel</a>
    </form>
  </div>
@endsection
