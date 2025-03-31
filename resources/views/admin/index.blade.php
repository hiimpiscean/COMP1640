@extends('masters.dashboardMaster')

@section('main')
  <style>
    body {
    background: #eef1f5;
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

    /* Định dạng Container chính */
    .main-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    }

    .main-container h2 {
    margin-left: 150px;
    margin-bottom: 10px;
    }

    /* Dashboard Container */
    .dashboard-container {
    max-width: 1500px;
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

    /* Dashboard Card */
    .dashboard-card {
    padding: 20px;
    border-radius: 12px;
    color: white;
    font-weight: bold;
    font-size: 20px;
    text-align: center;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
    }

    .dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
    }

    .dashboard-card h3 {
    font-size: 18px;
    margin-bottom: 10px;
    text-transform: uppercase;
    }

    .dashboard-card p {
    font-size: 24px;
    font-weight: bold;
    }

    /* Màu sắc cho các card */
    .dashboard-card:nth-child(1) {
    background: #ff4757;
    }

    .dashboard-card:nth-child(2) {
    background: #1e90ff;
    }

    .dashboard-card:nth-child(3) {
    background: #2ed573;
    }

    .dashboard-card:nth-child(4) {
    background: #ffa502;
    }

    .dashboard-card:nth-child(5) {
    background: #8e44ad;
    }

    .dashboard-card:nth-child(6) {
    background: #34495e;
    }

    /* Bảng */
    .table-container {
    max-width: 1500px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-left: 150px;
    }

    .table-container h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
    }

    .table-custom {
    width: 100%;
    border-collapse: collapse;
    border-radius: 12px;
    overflow: hidden;
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
    font-size: 18px;
    text-transform: uppercase;
    }

    .table-custom tr:nth-child(even) {
    background-color: #f8f9fa;
    }

    .table-custom tr:hover {
    background-color: #e9ecef;
    transition: 0.3s ease;
    }

    /* Action Links */
    .action-link {
    text-decoration: none;
    font-size: 22px;
    padding: 5px 10px;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    }

    .action-link:hover {
    transform: scale(1.2);
    text-decoration: none;
    }

    .action-link:first-child {
    color: #007bff;
    }

    .action-link:last-child {
    color: #e67e22;
    }

    h2 {
    font-size: 28px;
    font-weight: bold;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    background: linear-gradient(to right, #3498db, #8e44ad);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    }
  </style>

  <div class="main-container">
    <h2>Dashboard</h2> <!-- Thêm tiêu đề vào đây -->

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
      <p>{{ $totalCustomers }}</p> <!-- Sửa lại biến ở đây cho đúng -->
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