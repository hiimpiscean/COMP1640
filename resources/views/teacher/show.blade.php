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

    .btn-secondary {
      background: #394e64;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .btn-secondary:hover {
      background: #f5a623;
    }
  </style>

  <div class="staff-container">
    <h2>Chi Tiết Giáo Viên</h2>
    @include('partials.errors')

    <div class="staff-details">
      <p><strong>ID:</strong> {{ $teacher->id_t }}</p>
      <p><strong>Họ và Tên:</strong> {{ $teacher->fullname_t }}</p>
      <p><strong>Số điện thoại:</strong> {{ $teacher->phone_t }}</p>
      <p><strong>Email:</strong> {{ $teacher->email }}</p>
    </div>

    <a href="{{ route('teacher.index') }}" class="btn-secondary">Quay lại</a>
  </div>
@endsection
