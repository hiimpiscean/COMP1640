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
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    a {
      color: inherit;
      transition: color 0.3s ease;
    }
    a:focus, a:hover {
      text-decoration: none;
    }

    /* Layout tương tự staff */
    .form-container {
      padding: 2rem;
      width: 1000px;
      margin: auto;
      background: #50697f;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .form-title {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    /* Form Styling */
    .form-label {
      font-weight: bold;
      display: block;
      margin-bottom: 0.5rem;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #415a70;
      border-radius: 5px;
      background: #394e64;
      color: #fff;
      margin-bottom: 1rem;
      height: auto !important;
    }

    .btn-primary,
    .btn-dark {
      display: block;
      width: 100%;
      padding: 10px;
      background: #f5a623;
      border: none;
      color: #fff;
      font-size: 1rem;
      border-radius: 5px;
      transition: background 0.3s ease, transform 0.2s ease;
      text-align: center;
    }

    .btn-primary:hover,
    .btn-dark:hover {
      background: #e6951d;
      transform: scale(1.05);
    }

    .btn-info {
      display: block;
      width: 100%;
      padding: 10px;
      background: #60a6dd;
      border: none;
      color: #fff;
      font-size: 1rem;
      border-radius: 5px;
      text-align: center;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-info:hover {
      background: #394e64;
      transform: scale(1.05);
    }

    /* Nếu muốn hai nút Submit - Cancel nằm ngang: */
    .btn-container {
      display: flex;
      gap: 1rem;
    }
  </style>

  <div class="form-container">
    <h2 class="form-title">Create New Course</h2>
    @include('partials.errors')

    <form action="{{ route('product.store') }}" method="post">
      @csrf

      @include('product.productFieldsNew')

      <div class="btn-container">
        <button type="submit" class="btn-primary">Submit</button>
        <a href="{{ route('product.index') }}" class="btn-info">Cancel</a>
      </div>
    </form>
  </div>
@endsection
