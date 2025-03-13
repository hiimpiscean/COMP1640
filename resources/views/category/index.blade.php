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
    .container-fluid, .customer-container {
      padding: 2rem;
      max-width: 100%;
      overflow-x: auto;
    }

    /* Table Styling */
    .table-container, .tm-product-table-container {
      width: 100%;
      overflow-x: auto;
    }
    .table-custom {
      width: 100%;
      max-width: 100%;
      border-collapse: collapse;
      background: #50697f;
      font-size: 0.9rem;
    }
    .table-custom thead {
      background: #486177;
    }
    .table-custom th, .table-custom td {
      padding: 12px 20px;
      border: 1px solid #415a70;
      text-align: left;
      white-space: nowrap;
    }
    .table-custom tbody tr:hover {
      background: rgba(245, 166, 35, 0.1);
    }

    /* Action Links */
    .action-link {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background: #394e64;
      transition: background 0.3s ease, transform 0.2s ease;
    }
    .action-link:hover {
      background: #f5a623;
      transform: scale(1.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .table-container, .tm-product-table-container {
        overflow-x: auto;
      }
      .table-custom, .table-custom thead, .table-custom tbody, .table-custom th, .table-custom td, .table-custom tr {
        display: block;
      }
      .table-custom th {
        display: none;
      }
      .table-custom td {
        padding-left: 50%;
        position: relative;
        border: none;
        white-space: normal;
      }
      .table-custom td:before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        padding-left: 1rem;
        font-weight: bold;
        white-space: nowrap;
      }
    }
  </style>

  <div class="container-fluid mt-5">
    <div class="row tm-content-row">
      <div class="col-12 tm-block-col">
        <div class="tm-bg-primary-dark tm-block tm-block-products">
          @include('category.sessionmessage')
          <div class="tm-product-table-container">
            <table class="table-custom">
              <thead>
              <tr>
                <th>Tên</th>
                <th>Hình ảnh</th>
                <th>Xem</th>
                <th>Sửa</th>
                <th>Xóa</th>
              </tr>
              </thead>
              <tbody>
              @foreach($category as $c)
                <tr>
                  <td data-label="Tên">{{ $c->name_cate }}</td>
                  <td data-label="Hình ảnh">
                    <a href="{{ route('category.show', ['id_cate' => $c->id_cate]) }}">
                      <img src="{{ asset('images/category/' . $c->image_cate) }}" alt="{{ $c->name_cate }}" style="width: 30%;">
                    </a>
                  </td>
                  <td class="but">
                    <a class="action-link" href="{{ route('category.show', ['id_cate' => $c->id_cate]) }}">
                      <i class="bi bi-eye"></i>
                    </a>
                  </td>
                  <td class="but">
                    <a class="action-link" href="{{ route('category.edit', ['id_cate' => $c->id_cate]) }}">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                  </td>
                  <td class="but">
                    <a class="action-link" href="{{ route('category.confirm', ['id_cate' => $c->id_cate]) }}">
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
