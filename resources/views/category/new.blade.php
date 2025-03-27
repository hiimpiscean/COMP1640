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

    /* Container */
    .form-container {
      padding: 2rem;
      width: 500px;
      margin: 60px auto;
      background: #50697f;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .form-title {
      margin-bottom: 25px;
      font-weight: bold;
      color: #fff;
      font-size: 24px;
    }

    /* Form Fields */
    .form-group {
      margin-bottom: 1rem;
      text-align: left;
    }
    .form-group label {
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
    }
    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #415a70;
      border-radius: 5px;
      background: #394e64;
      color: #fff;
      margin-bottom: 1rem;
    }

    /* Buttons */
    .btn-container {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }
    .btn {
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 6px;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      width: 45%;
    }
    .btn-dark {
      background-color: #f5a623;
      color: white;
    }
    .btn-dark:hover {
      background-color: #e6951d;
    }
    .btn-info {
      background-color: #60a6dd;
      color: white;
      text-decoration: none;
      text-align: center;
      display: inline-block;
    }
    .btn-info:hover {
      background-color: #394e64;
    }
  </style>

  <div class="form-container">
    <h1 class="form-title">Create New Category</h1>
    @include('partials.errors')
    <form action="{{ route('category.store') }}" method="post">
      @csrf
      @include('category.categoryFieldsNew')
      <div class="btn-container">
        <button type="submit" class="btn btn-dark">Submit</button>
        <a href="{{ route('category.index') }}" class="btn btn-info">Cancel</a>
      </div>
    </form>
  </div>
@endsection
