@extends('layouts.app')
@section('content')
  <div class="container">
    <h2>Chi Tiết Giáo Viên</h2>
    <p><strong>ID:</strong> {{ $teacher->id_t }}</p>
    <p><strong>Họ và Tên:</strong> {{ $teacher->fullname_t }}</p>
    <p><strong>Số điện thoại:</strong> {{ $teacher->phone_t }}</p>
    <p><strong>Email:</strong> {{ $teacher->email }}</p>
    <a href="{{ route('teacher.index') }}" class="btn btn-secondary">Quay lại</a>
  </div>
@endsection
