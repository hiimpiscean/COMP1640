@extends('masters.dashboardMaster')

@section('main')

  <style>
    body {
      background: #f8f9fa;
    }

    .container {
      max-width: 500px;
      margin: 60px auto;
      padding: 30px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-title {
      margin-bottom: 25px;
      font-weight: bold;
      color: #343a40;
      text-align: center;
      font-size: 24px;
    }

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
    }

    .btn-dark {
      background-color: #343a40;
      color: white;
    }

    .btn-dark:hover {
      background-color: #23272b;
    }

    .btn-info {
      background-color: #17a2b8;
      color: white;
      text-decoration: none;
      text-align: center;
      display: inline-block;
    }

    .btn-info:hover {
      background-color: #117a8b;
    }
  </style>

  <div class="container">
    <h1 class="form-title">Create New Course</h1>

    @include('partials.errors')

    <form action="{{route('product.store')}}" method="post">
      @csrf
      @include('product.productFieldsNew')
      <div class="btn-container">
        <button type="submit" class="btn btn-dark">Submit</button>
        <a href="{{route('product.index')}}" class="btn btn-info">Cancel</a>
      </div>
    </form>
  </div>
@endsection
