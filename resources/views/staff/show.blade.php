@extends('masters.dashboardMaster')

@section('main')
  <div class="container">
    <h2 class="my-4">Chi tiết nhân viên</h2>

    <p><strong>ID:</strong> {{ $staff->id_s }}</p>
    <p><strong>Tên đăng nhập:</strong> {{ $staff->username }}</p>
    <p><strong>Họ và Tên:</strong> {{ $staff->fullname_s }}</p>
    <p><strong>Email:</strong> {{ $staff->email }}</p>
    <p><strong>Số điện thoại:</strong> {{ $staff->phone_s }}</p>

    <a href="{{ route('staff.index') }}" class="btn btn-secondary">Quay lại</a>
  </div>
@endsection
