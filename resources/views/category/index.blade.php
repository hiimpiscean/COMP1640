@extends('masters.dashboardMaster')
@section('main')
  <style>
    html {
      font-size: 16px;
      overflow-x: hidden;
    }
    body {
      font-family: Roboto, Helvetica, Arial, sans-serif;
      background-color: #4e657a;
      overflow-x: hidden;
    }
    a {
      transition: all 0.3s ease;
    }
    a:focus,
    a:hover {
      text-decoration: none;
    }
    button:focus {
      outline: 0;
    }

    .navbar .container {
      position: relative;
    }

    .nav-link > i {
      margin-bottom: 10px;
      margin-right: 0;
      font-size: 1.5rem;
    }
    .navbar-nav .active > .nav-link,
    .navbar-nav .nav-link.active {
      background-color: #f5a623;
      color: #fff;
    }
    .navbar-nav .nav-link.active i {
      color: #fff;
    }
    .navbar-nav a:hover,
    .navbar-nav a:hover i {
      color: #f5a623;
    }

    .tm-content-row {
      justify-content: space-between;
      margin-left: -20px;
      margin-right: -20px;
    }

    .table {
      width: 100%;
      background-color: #50697f;
      color: #fff;
      font-size: 85%;
      margin-bottom: 0;
    }
    /* Sticky header: khi cuộn, thead sẽ cố định */
    thead {
      background-color: #486177;
      color: #fff;
      position: sticky;
      top: 0;
      z-index: 2;
    }
    .table thead th {
      border-bottom: 0;
      padding: 15px 25px;
      text-align: left;
    }
    .table td,
    .table th {
      border-top: 1px solid #415a70;
      padding: 15px 25px;
      vertical-align: middle;
    }
    .table-hover tbody tr {
      transition: all 0.2s ease;
    }
    .table-hover tbody tr:hover {
      color: #a0c0de;
    }
    .tm-bg-primary-dark {
      background-color: #435c70;
    }
    .tm-product-table-container {
      max-height: 465px;
      margin-bottom: 15px;
      overflow-y: auto;
    }
    .tm-product-table tr {
      font-weight: 600;
    }
    .tm-product-delete-link {
      padding: 10px;
      border-radius: 50%;
      background-color: #394e64;
      display: inline-block;
      width: 40px;
      height: 40px;
      text-align: center;
      color: #fff;
      transition: color 0.3s ease;
    }
    .tm-product-delete-link:hover .tm-product-delete-icon {
      color: #6d8ca6;
    }
    .but a {
      margin-right: 5px;
    }
    /* Chỉnh sửa khối sản phẩm cho phù hợp với toàn bộ giao diện */
    .tm-block-products {
      min-height: 500px;
      margin-top: 60px;
      width: 100%;
    }
    .table img {
      max-width: 100%;
      height: auto;
    }
    /* Scrollbar styling */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #394e62;
    }
    ::-webkit-scrollbar-thumb {
      background: #6d8da6;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #8ab5d6;
    }
  </style>

  <div class="container-fluid mt-5">
    <div class="row tm-content-row">
      <div class="col-12 tm-block-col">
        <div class="tm-bg-primary-dark tm-block tm-block-products">
          @include('category.sessionmessage')
          <div class="tm-product-table-container">
            <table class="table table-hover tm-table-small tm-product-table">
              <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">View</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
              </thead>
              <tbody>
              @foreach($category as $c)
                <tr>
                  <td>{{ $c->name_cate }}</td>
                  <td>
                    <a href="{{ route('category.show', ['id_cate' => $c->id_cate]) }}">
                      <img src="{{ asset('images/category/' . $c->image_cate) }}" alt="{{ $c->name_cate }}" style="width: 30%;">
                    </a>
                  </td>
                  <td class="but">
                    <a class="tm-product-delete-link" href="{{ route('category.show', ['id_cate' => $c->id_cate]) }}">
                      <i class="bi bi-eye"></i>
                    </a>
                  </td>
                  <td class="but">
                    <a class="tm-product-delete-link" href="{{ route('category.edit', ['id_cate' => $c->id_cate]) }}">
                      <i class="bi bi-plus-square"></i>
                    </a>
                  </td>
                  <td class="but">
                    <a class="tm-product-delete-link" href="{{ route('category.confirm', ['id_cate' => $c->id_cate]) }}">
                      <i class="bi bi-trash3-fill"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
@endsection
