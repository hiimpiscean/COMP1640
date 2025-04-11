@extends('masters.dashboardMaster')

@section('main')
  <style>
    body {
    background: #f8f9fa;
    color: #333;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    }

    .main-container {
    padding: 30px;
    margin-left: 250px;
    margin-top: 60px;
    width: calc(100% - 250px);
    }

    .dashboard-header {
    margin-bottom: 30px;
    }

    .dashboard-header h2 {
    color: #2c3e50;
    font-weight: 600;
    font-size: 28px;
    margin: 0;
    }

    .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
    }

    .stats-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-left: 4px solid #3498db;
    }

    .stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .stats-card h3 {
    color: #666;
    font-size: 16px;
    margin-bottom: 15px;
    font-weight: 500;
    }

    .stats-card .number {
    font-size: 32px;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 10px;
    }

    .stats-card .trend {
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 20px;
    display: inline-block;
    }

    .trend.up {
    background: rgba(46, 204, 113, 0.1);
    color: #27ae60;
    }

    .trend.down {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    }

    .chart-container {
    background: white;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .chart-container h3 {
    color: #2c3e50;
    margin-bottom: 25px;
    font-weight: 600;
    font-size: 18px;
    }

    .table-container {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 40px;
    }

    .table-container h3 {
    color: #2c3e50;
    margin-bottom: 25px;
    font-weight: 600;
    font-size: 18px;
    }

    .table-custom {
    width: 100%;
    border-collapse: collapse;
    }

    .table-custom th {
    background: #f8f9fa;
    color: #2c3e50;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    border-bottom: 2px solid #e9ecef;
    }

    .table-custom td {
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    color: #666;
    }

    .table-custom tr:hover {
    background-color: #f8f9fa;
    }

    .action-link {
    color: #3498db;
    text-decoration: none;
    margin-right: 15px;
    font-weight: 500;
    transition: color 0.3s ease;
    }

    .action-link:hover {
    color: #2980b9;
    }

    .chart-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
    }

    @media (max-width: 768px) {
    .main-container {
      margin-left: 0;
      width: 100%;
      padding: 20px;
    }

    .chart-row {
      grid-template-columns: 1fr;
    }

    .stats-grid {
      grid-template-columns: 1fr;
    }
    }
  </style>

  <div class="main-container">
    <div class="dashboard-header">
    <h2>Dashboard</h2>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="stats-grid">
    <div class="stats-card">
      <h3>Tổng số khóa học</h3>
      <div class="number">{{ $totalProducts }}</div>
      <div class="trend up">+{{ $currentMonthProducts }} khóa mới trong tháng này</div>
    </div>
    <div class="stats-card">
      <h3>Tổng số đăng ký</h3>
      <div class="number">{{ $totalRegistrations }}</div>
      <div class="trend up">+{{ $currentMonthRegistrations }} đăng ký mới trong tháng này</div>
    </div>
    <div class="stats-card">
      <h3>Tổng số blog</h3>
      <div class="number">{{ $totalBlogs }}</div>
      <div class="trend up">+{{ $currentMonthBlogs }} bài mới trong tháng này</div>
    </div>
    <div class="stats-card">
      <h3>Tài khoản giáo viên</h3>
      <div class="number">{{ $totalTeachers }}</div>
      <div class="trend up">+{{ $currentMonthTeachers }} giáo viên mới trong tháng này</div>
    </div>
    <div class="stats-card">
      <h3>Tài khoản học viên</h3>
      <div class="number">{{ $totalCustomers }}</div>
      <div class="trend up">+{{ $currentMonthStudents }} học viên mới trong tháng này</div>
    </div>
    </div>

    <!-- Biểu đồ và bảng thống kê -->
    <div class="chart-row">
    <div class="chart-container">
      <h3>Phân bố khóa học theo danh mục</h3>
      <canvas id="coursesByCategoryChart"></canvas>
    </div>
    <div class="chart-container">
      <h3>Top 5 khóa học có nhiều đăng ký nhất</h3>
      <canvas id="topCoursesChart"></canvas>
    </div>
    </div>

    <div class="chart-row">
    <div class="chart-container">
      <h3>Đăng ký khóa học trong tháng này</h3>
      <canvas id="monthlyRegistrationsChart"></canvas>
    </div>
    </div>

    <div class="table-container">
    <h3>Danh sách Admin</h3>
    <table class="table-custom">
      <thead>
      <tr>
        <th>Tên đăng nhập</th>
        <th>Họ tên</th>
        <th>Số điện thoại</th>
        <th>Email</th>
        <th>Thao tác</th>
      </tr>
      </thead>
      <tbody>
      @foreach($admin as $a)
      <tr>
      <td>{{ $a->username }}</td>
      <td>{{ $a->fullname_a }}</td>
      <td>{{ $a->phone_a }}</td>
      <td>{{ $a->email_a }}</td>
      <td>
      <a href="{{ route('admin.show', ['id_a' => $a->id_a]) }}" class="action-link">Xem</a>
      <a href="{{ route('admin.edit', ['id_a' => $a->id_a]) }}" class="action-link">Sửa</a>
      </td>
      </tr>
    @endforeach
      </tbody>
    </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Biểu đồ khóa học theo danh mục
    const coursesByCategoryCtx = document.getElementById('coursesByCategoryChart').getContext('2d');
    new Chart(coursesByCategoryCtx, {
    type: 'doughnut',
    data: {
      labels: {!! json_encode($coursesByCategory->pluck('name_cate')) !!},
      datasets: [{
      data: {!! json_encode($coursesByCategory->pluck('total')) !!},
      backgroundColor: [
        '#3498db',
        '#2ecc71',
        '#f1c40f',
        '#e74c3c',
        '#9b59b6',
        '#1abc9c',
        '#34495e'
      ]
      }]
    },
    options: {
      responsive: true,
      plugins: {
      legend: {
        position: 'right',
      }
      }
    }
    });

    // Biểu đồ top 5 khóa học có nhiều đăng ký nhất
    const topCoursesCtx = document.getElementById('topCoursesChart').getContext('2d');
    new Chart(topCoursesCtx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($topCourses->pluck('name_p')) !!},
      datasets: [{
      label: 'Số đăng ký',
      data: {!! json_encode($topCourses->pluck('registrations')) !!},
      backgroundColor: '#3498db'
      }]
    },
    options: {
      responsive: true,
      scales: {
      y: {
        beginAtZero: true
      }
      }
    }
    });

    // Biểu đồ đăng ký khóa học trong tháng này
    const monthlyRegistrationsCtx = document.getElementById('monthlyRegistrationsChart').getContext('2d');
    new Chart(monthlyRegistrationsCtx, {
    type: 'line',
    data: {
      labels: {!! json_encode($monthlyRegistrations->pluck('date')) !!},
      datasets: [{
      label: 'Số đăng ký',
      data: {!! json_encode($monthlyRegistrations->pluck('count')) !!},
      borderColor: '#2ecc71',
      backgroundColor: 'rgba(46, 204, 113, 0.1)',
      tension: 0.4,
      fill: true
      }]
    },
    options: {
      responsive: true,
      scales: {
      y: {
        beginAtZero: true
      }
      }
    }
    });
  </script>
@endsection