@extends('masters.dashboardMaster')

@section('main')
  <div class="container">
    <h2 class="my-4">Danh sách nhân viên</h2>
    <a href="{{ route('staff.create') }}" class="btn btn-primary mb-3">Thêm nhân viên</a>
    @if(session('msg'))
      <div class="alert alert-success">{{ session('msg') }}</div>
    @endif
    <table class="table table-bordered">
      <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Họ và Tên</th>
        <th>Email</th>
        <th>Số điện thoại</th>
        <th>Password</th>
        <th>Hành động</th>
      </tr>
      </thead>
      <tbody>
      @foreach($staff as $s)
        <tr>
          <td>{{ $s->id_s }}</td>
          <td>{{ $s->username }}</td>
          <td>{{ $s->fullname_s }}</td>
          <td>{{ $s->email }}</td>
          <td>{{ $s->phone_s }}</td>
          <td>{{ $s->password }}</td>
          <td>
            <a href="{{ route('staff.show', $s->id_s) }}" class="btn btn-info btn-sm">Xem</a>
            <a href="{{ route('staff.edit', $s->id_s) }}" class="btn btn-warning btn-sm">Sửa</a>
            <a href="{{ route('staff.confirm', $s->id_s) }}" class="btn btn-danger btn-sm">Xóa</a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
