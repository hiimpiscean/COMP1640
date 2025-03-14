@extends('masters.dashboardMaster')

@section('main')
  <div class="container">
    <h2 class="my-4">Thêm nhân viên</h2>

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
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
  </div>
@endsection
