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
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Container */
    .form-container {
      padding: 2rem;
      width: 1000px;
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

    /* Button Group */
    .button-group {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .btn {
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
      width: 45%;
      text-align: center;
    }

    .btn-dark {
      background-color: #f5a623;
      color: white;
    }

    .btn-dark:hover {
      background-color: #e6951d;
      transform: scale(1.05);
    }

    .btn-info {
      background-color: #60a6dd;
      color: white;
      text-decoration: none;
      display: inline-block;
    }

    .btn-info:hover {
      background-color: #394e64;
      transform: scale(1.05);
    }
  </style>

  <div class="form-container">
    <h1 class="form-title">Update An Existing Category</h1>
    @include('partials.errors')
    <form action="{{ route('category.update', ['id_cate' => old('id_cate') ?? $category->id_cate]) }}" method="post">
      @csrf
      @include('category.categoryFields')
      <div class="button-group">
        <button type="submit" class="btn btn-dark">Submit</button>
        <a href="{{ route('category.index') }}" class="btn btn-info">Cancel</a>
      </div>
    </form>
  </div>
@endsection
