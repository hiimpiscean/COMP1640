@extends('masters.dashboardMaster')

@section('main')
  <style>
    body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #333;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    }

    .main-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 20px 0;
    }

    .main-container h2 {
    margin-left: 150px;
    }

    .dashboard-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 30px;
    background: #fff;
    border-radius: 12px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 30px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-left: 150px;
    }

    .dashboard-card {
    border-radius: 8px;
    padding: 20px;
    color: white;
    font-weight: bold;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .dashboard-card:nth-child(1) {
    background: linear-gradient(135deg, #ff9a9e, #fad0c4);
    }

    .dashboard-card:nth-child(2) {
    background: linear-gradient(135deg, #a18cd1, #fbc2eb);
    }

    .dashboard-card:nth-child(3) {
    background: linear-gradient(135deg, #ff758c, #ff7eb3);
    }

    .dashboard-card:nth-child(4) {
    background: linear-gradient(135deg, #67B26F, #4ca2cd);
    }

    .dashboard-card:nth-child(5) {
    background: linear-gradient(135deg, #ff9966, #ff5e62);
    }

    .dashboard-card:nth-child(6) {
    background: linear-gradient(135deg, #56CCF2, #2F80ED);
    }

    .dashboard-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .table-container {
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    overflow-x: auto;
    margin-left: 150px;
    }

    .table-custom {
    width: 100%;
    border-collapse: collapse;
    }

    .table-custom th,
    .table-custom td {
    padding: 15px;
    text-align: center;
    font-size: 16px;
    }

    .table-custom th {
    background: #2c3e50;
    color: white;
    }
    a:hover {
      text-decoration: none;
    }

    .table-custom tr:nth-child(even) {
    background-color: #f8f9fa;
    }

    .table-custom tr:hover {
    background-color: #e9ecef;
    transition: 0.3s ease;
    }
  </style>

  <div class="main-container">
    <h2>Dashboard</h2>

    <div class="dashboard-container">
    <div class="dashboard-card">
      <h3>All account</h3>
      <p>{{ $totalUsers }}</p>
    </div>
    <div class="dashboard-card">
      <h3>Accounts are logged in</h3>
      <p>{{ $loggedInUsers }}</p>
    </div>
    <div class="dashboard-card">
      <h3>All Courses</h3>
      <p>{{ $totalProducts }}</p>
    </div>
    <div class="dashboard-card">
      <h3>Blog</h3>
      <p>{{ $totalBlogs }}</p>
    </div>
    <div class="dashboard-card">
      <h3>All teachers account</h3>
      <p>{{ $totalTeachers }}</p>
    </div>
    <div class="dashboard-card">
      <h3>All students account</h3>
      <p>{{ $totalCustomers }}</p>
    </div>
    </div>
  </div>

  <div class="table-container">
    <h2>Admin List</h2>
    <table class="table-custom">
    <thead>
      <tr>
      <th>Username</th>
      <th>Full Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>View</th>
      <th>Edit</th>
      </tr>
    </thead>
    <tbody>
      @foreach($admin as $a)
      <tr>
      <td>{{ $a->username }}</td>
      <td>{{ $a->fullname_a }}</td>
      <td>{{ $a->phone_a }}</td>
      <td>{{ $a->email_a }}</td>
      <td><a href="{{ route('admin.show', ['id_a' => $a->id_a]) }}" class="action-link">👁</a></td>
      <td><a href="{{ route('admin.edit', ['id_a' => $a->id_a]) }}" class="action-link">✏️</a></td>
      </tr>
    @endforeach
    </tbody>
    </table>
  </div>
@endsection