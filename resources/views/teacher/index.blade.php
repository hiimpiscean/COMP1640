@extends('masters.dashboardMaster')

@section('main')
  <div class="teacher-container">
    <h2>Danh sách Giáo Viên</h2>
    <div class="table-container">
      <table class="table-custom">
        <thead>
        <tr>
          <th>ID</th>
          <th>Họ và Tên</th>
          <th>Số điện thoại</th>
          <th>Email</th>
          <th>Password</th>
          <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($teacher as $t)
          <tr>
            <td data-label="ID">{{ $t->id_t }}</td>
            <td data-label="Họ và Tên">{{ $t->fullname_t }}</td>
            <td data-label="Số điện thoại">{{ $t->phone_t }}</td>
            <td data-label="Email">{{ $t->email }}</td>
            <td data-label="password">{{ $t->password }}</td>
            <td data-label="Hành động">
              <a class="action-link" href="{{ route('teacher.show', $t->id_t) }}">
                <i class="bi bi-eye"></i>
              </a>
              <a class="action-link" href="{{ route('teacher.edit', $t->id_t) }}">
                <i class="bi bi-pencil-square"></i>
              </a>
              <a class="action-link" href="{{ route('teacher.confirm', $t->id_t) }}">
                <i class="bi bi-trash3-fill"></i>
              </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

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
    .teacher-container {
      padding: 2rem;
      max-width: 100%;
      overflow-x: auto;
    }

    /* Table Styling */
    .table-container {
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
      .table-container {
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
@endsection
