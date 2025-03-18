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
      font-family: 'Roboto', Helvetica, Arial, sans-serif;
    }
    a {
      color: inherit;
      transition: color 0.3s ease;
    }
    a:focus, a:hover {
      text-decoration: none;
    }

    /* Layout */
    .form-container {
      padding: 2rem;
      width: 600px;
      margin: 50px auto;
      background: #50697f;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      text-align: center;
    }

    .form-container h1 {
      margin-bottom: 1.5rem;
    }

    .button-group {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 30px;
    }

    .btn-danger, .btn-info {
      width: 120px; /* Kích thước đồng nhất cho cả 2 nút */
      padding: 10px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-danger {
      background: #d9534f;
      color: #fff;
    }

    .btn-danger:hover {
      background: #c9302c;
      transform: scale(1.05);
    }

    .btn-info {
      background: #60a6dd;
      color: #fff;
    }

    .btn-info:hover {
      background: #394e64;
      transform: scale(1.05);
    }
  </style>

  <div class="form-container">
    <h1>Are you sure you want to delete?</h1>
    <form action="{{ route('customer.destroy', ['id_c' => $customer->id_c]) }}" method="post">
      @csrf
      <input type="hidden" name="id_c" value="{{ $customer->id_c }}">
      <div class="button-group">
        <button type="submit" class="btn-danger">Delete</button>
        <a href="{{ route('customer.index') }}" class="btn-info">Cancel</a>
      </div>
    </form>
  </div>
@endsection
