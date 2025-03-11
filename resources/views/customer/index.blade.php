@extends('masters.dashboardMaster')

@section('main')
  <style>
    /* Global Reset & Base */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Roboto', Helvetica, Arial, sans-serif;
      background-color: #4e657a;
      color: #fff;
      line-height: 1.6;
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
      outline: none;
    }

    /* Container & Layout */
    .customer-container {
      width: 100%;
      padding: 2rem;
    }
    h1.display-4 {
      text-align: center;
      margin-bottom: 2rem;
      font-size: 2.5rem;
      color: #e9ecef;
    }

    /* Table Container */
    .table-container {
      width: 100%;
      overflow-x: auto;
    }

    /* Table Styling */
    .table-custom {
      width: 100%;
      border-collapse: collapse;
      background-color: #50697f;
      color: #fff;
      font-size: 85%;
    }
    .table-custom thead {
      background-color: #486177;
    }
    .table-custom thead th {
      padding: 1rem;
      text-align: left;
      border-bottom: 2px solid #415a70;
    }
    .table-custom td,
    .table-custom th {
      padding: 15px 25px;
      border-top: 1px solid #415a70;
      vertical-align: middle;
    }
    .table-custom tbody tr {
      transition: background-color 0.2s ease;
    }
    .table-custom tbody tr:hover {
      background-color: rgba(245, 166, 35, 0.2);
    }

    /* Action Links */
    .action-link {
      display: inline-block;
      padding: 10px;
      border-radius: 50%;
      background-color: #394e64;
      width: 40px;
      height: 40px;
      text-align: center;
      margin-right: 0.5rem;
      color: #fff;
      transition: color 0.3s ease;
    }
    .action-link:hover {
      color: #f5a623;
    }

    /* Responsive Table */
    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
      }
      tbody tr {
        border: 1px solid #415a70;
        margin-bottom: 1rem;
      }
      tbody td {
        border: none;
        padding: 0.5rem;
        position: relative;
        padding-left: 50%;
      }
      tbody td:before {
        position: absolute;
        left: 0;
        width: 45%;
        padding-left: 1rem;
        font-weight: bold;
        white-space: nowrap;
      }
      tbody td:nth-of-type(1):before { content: "Full Name"; }
      tbody td:nth-of-type(2):before { content: "DOB"; }
      tbody td:nth-of-type(3):before { content: "Gender"; }
      tbody td:nth-of-type(4):before { content: "Phone"; }
      tbody td:nth-of-type(5):before { content: "Email"; }
      tbody td:nth-of-type(6):before { content: "Address"; }
      tbody td:nth-of-type(7):before { content: "Password"; }
      tbody td:nth-of-type(8):before { content: "Actions"; }
    }
  </style>

  <div class="customer-container">
    <h1 class="display-4">Customer Index</h1>
    @include('customer.sessionmessage')
    <div class="table-container">
      <table class="table-custom">
        <thead>
        <tr>
          <th scope="col">Full Name</th>
          <th scope="col">DOB</th>
          <th scope="col">Gender</th>
          <th scope="col">Phone</th>
          <th scope="col">Email</th>
          <th scope="col">Address</th>
          <th scope="col">Password</th>
          <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customer as $c)
          <tr>
            <td>{{ $c->fullname_c }}</td>
            <td>{{ $c->dob }}</td>
            <td>{{ $c->gender }}</td>
            <td>{{ $c->phone_c }}</td>
            <td>{{ $c->email_c }}</td>
            <td>{{ $c->address_c }}</td>
            <td>{{ $c->password_c }}</td>
            <td>
              <a class="action-link" href="{{ route('customer.show', ['id_c' => $c->id_c]) }}">
                <i class="bi bi-eye"></i>
              </a>
              <a class="action-link" href="{{ route('customer.edit', ['id_c' => $c->id_c]) }}">
                <i class="bi bi-plus-square"></i>
              </a>
              <a class="action-link" href="{{ route('customer.confirm', ['id_c' => $c->id_c]) }}">
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

@section('script')
@endsection
