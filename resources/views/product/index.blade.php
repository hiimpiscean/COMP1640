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
    .product-container {
      padding: 2rem;
    }

    /* Table Styling */
    .table-container {
      overflow-x: auto;
    }
    .table-custom {
      width: 100%;
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
    }
    .table-custom tbody tr:hover {
      background: rgba(245, 166, 35, 0.1);
    }

    /* Image Styling */
    .product-image {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 5px;
      display: block;
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

  <div class="product-container">
    @include('product.sessionmessage')
    <div class="table-container">
      <table class="table-custom">
        <thead>
        <tr>
          <th>Image</th>
          <th>Product Name</th>
          <th>Price (VND)</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($product as $p)
          <tr>
            <td data-label="Image">
              <img src="{{asset('images/handicraf/'. $p->image_p)}}" alt="{{ $p->name_p }}" class="product-image">
            </td>
            <td data-label="Product Name">{{ $p->name_p }}</td>
            <td data-label="Price">{{ $p->price_p }}</td>
            <td data-label="Category">{{ $p->categoryname }}</td>
            <td data-label="Actions">
              <a class="action-link" href="{{ route('product.show', ['id_p' => $p->id_p]) }}">
                <i class="bi bi-eye"></i>
              </a>
              <a class="action-link" href="{{ route('product.edit', ['id_p' => $p->id_p]) }}">
                <i class="bi bi-pencil-square"></i>
              </a>
              <a class="action-link" href="{{ route('product.confirm', ['id_p' => $p->id_p]) }}">
                <i class="bi bi-trash3-fill"></i>
              </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
