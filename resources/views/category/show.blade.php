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

    /* Container */
    .category-container {
      padding: 2rem;
      width: 1000px;
      margin: 50px auto;
      background: #50697f;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .category-container h1 {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    /* Nếu phần chi tiết bên trong cần được bao bọc thêm, có thể dùng class này */
    .category-details {
      background: #394e64;
      padding: 1.5rem;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }

    /* Button */
    .back-button-container {
      text-align: center;
      margin-top: 20px;
    }
    .btn-secondary {
      display: inline-block;
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

  <div class="category-container">
    <h1>Category Details</h1>
    @include('category.categoryDetails')
    <div class="back-button-container">
      <a href="{{ route('category.index') }}" class="btn btn-secondary">&lt;&lt;&nbsp;Back</a>
    </div>
  </div>
@endsection
