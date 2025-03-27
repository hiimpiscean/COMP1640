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
      background: #4e657a; /* giống trang staff */
      color: #fff;         /* giống trang staff */
    }
    a {
      color: inherit;
      transition: color 0.3s ease;
    }
    a:focus, a:hover {
      text-decoration: none;
    }

    /* Layout giống trang staff */
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

    .staff-details dl dt,
    .staff-details dl dd {
      margin-bottom: 1rem;
      border-bottom: 1px solid #415a70;
      padding-bottom: 0.5rem;
    }

    .staff-details img {
      max-width: 400px;
      max-height: 400px;
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
    <h2>Chi tiết sản phẩm</h2>

    <div class="staff-details">
      <dl class="row">
        <dt class="col-sm-3">Name</dt>
        <dd class="col-sm-9">{{ $product->name_p }}</dd>

        <dt class="col-sm-3">Image</dt>
        <dd class="col-sm-9">
          <img src="{{ asset('images/handicraf/' . $product->image_p) }}" alt="{{ $product->name_p }}">
        </dd>

        <dt class="col-sm-3">Price</dt>
        <dd class="col-sm-9">VND {{ $product->price_p }}</dd>

        <dt class="col-sm-3">Description</dt>
        <dd class="col-sm-9" style="white-space: pre-wrap;">{{ $product->description_p }}</dd>

        <dt class="col-sm-3">Category</dt>
        <dd class="col-sm-9">{{ $category->name_cate }}</dd>
      </dl>
    </div>

    {{-- Nút quay lại (có thể trỏ về trang index của product, hoặc staff tuỳ bạn) --}}
    <a href="{{ route('product.index') }}" class="btn-secondary">Quay lại</a>
  </div>
@endsection
