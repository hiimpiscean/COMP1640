{{--@extends('masters.uiMaster')--}}
{{--@section('main')--}}
{{--  <div class="container">--}}
{{--    <h2>Danh sách đăng ký chờ phê duyệt</h2>--}}
{{--    @if(session('msg'))--}}
{{--      <div class="alert alert-success">{{ session('msg') }}</div>--}}
{{--    @endif--}}
{{--    <table class="table">--}}
{{--      <thead>--}}
{{--      <tr>--}}
{{--        <th>ID</th>--}}
{{--        <th>Tên khóa học</th>--}}
{{--        <th>Người đăng ký</th>--}}
{{--        <th>Hành động</th>--}}
{{--      </tr>--}}
{{--      </thead>--}}
{{--      <tbody>--}}
{{--      @foreach($registrations as $reg)--}}
{{--        <tr>--}}
{{--          <td>{{ $reg->id }}</td>--}}
{{--          <td>{{ $reg->course_name }}</td>--}}
{{--          <td>{{ $reg->user_name }}</td>--}}
{{--          <td>--}}
{{--            <form action="{{ route('teacher.approve', $reg->id) }}" method="POST" style="display:inline;">--}}
{{--              @csrf--}}
{{--              <button type="submit" class="btn btn-success">Phê duyệt</button>--}}
{{--            </form>--}}
{{--            <form action="{{ route('teacher.reject', $reg->id) }}" method="POST" style="display:inline;">--}}
{{--              @csrf--}}
{{--              <button type="submit" class="btn btn-danger">Từ chối</button>--}}
{{--            </form>--}}
{{--          </td>--}}
{{--        </tr>--}}
{{--      @endforeach--}}
{{--      </tbody>--}}
{{--    </table>--}}
{{--  </div>--}}
{{--@endsection--}}
