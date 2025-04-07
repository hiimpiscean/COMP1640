<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>ATN Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap Icons CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* Sidebar container */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      height: 100vh;
      background: #212529;
      padding: 20px;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      transition: all 0.3s ease;
      z-index: 1000;
    }

    /* Sidebar Header */
    .sidebar-header {
      margin-bottom: 30px;
      color: #f8f9fa;
      text-align: center;
    }

    .sidebar-header h3 {
      margin: 0;
      font-size: 24px;
      font-weight: bold;
    }

    /* Sidebar Menu */
    .sidebar-menu,
    .submenu {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-menu>li {
      margin-bottom: 10px;
    }

    .sidebar-menu>li>a {
      color: #adb5bd;
      display: block;
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 8px;
      font-weight: 500;
      transition: background 0.2s ease;
    }

    .sidebar-menu>li>a:hover,
    .submenu li a:hover {
      background: #495057;
      color: #fff;
    }

    .submenu {
      margin-left: 15px;
      margin-top: 5px;
    }

    .submenu li a {
      font-size: 14px;
      color: #ced4da;
      display: block;
      text-decoration: none;
      padding: 8px 12px;
      border-radius: 6px;
      transition: background 0.2s ease;
    }

    .sidebar-menu>li.active>a,
    .submenu li.active a {
      background: #17a2b8;
      color: #fff;
    }

    /* Sidebar Footer */
    .sidebar-footer {
      margin-top: auto;
      padding-top: 20px;
      border-top: 1px solid #495057;
      color: #adb5bd;
      font-size: 14px;
    }

    .sidebar-footer a {
      color: #adb5bd;
      display: flex;
      align-items: center;
      text-decoration: none;
      margin-bottom: 10px;
      transition: color 0.2s ease;
    }

    .sidebar-footer a i {
      margin-right: 8px;
    }

    .sidebar-footer a:hover {
      color: #fff;
    }

    /* Body content shift */
    body {
      margin-left: 250px;
      transition: margin 0.3s ease;
    }

    /* Toggle Button for Mobile */
    .toggle-btn {
      display: none;
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 1100;
      background: #212529;
      color: white;
      padding: 10px;
      border-radius: 4px;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .sidebar {
        left: -250px;
      }

      .sidebar.show {
        left: 0;
      }

      .toggle-btn {
        display: block;
      }

      body {
        margin-left: 0;
      }

      body.sidebar-open {
        margin-left: 250px;
      }
    }
  </style>
</head>

<body>

  <!-- Toggle Button -->
  <div class="toggle-btn" onclick="toggleSidebar()">
    <i class="bi bi-list" style="font-size: 24px;"></i>
  </div>

  <!-- Sidebar -->
  <nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
      @if(Session::get('role') === 'admin')
      <div class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
      <a href="{{ route('admin.index') }}">
        <h3>ATN portal</h3>
      </a>
      </div>
    @endif
    </div>

    <ul class="sidebar-menu">
      <li>
        <a href="{{route('ui.index')}}">Home Page</a>
      </li>

      <li>
        <a href="{{route('learning_materials.pending')}}">Learning Materials</a>
      </li>

      @if(Session::get('role') === 'admin' || Session::get('role') === 'staff')
      <li class="{{ request()->routeIs('staff.registrations') ? 'active' : '' }}">
      <a href="{{ route('staff.registrations') }}">Pending Registrations</a>
      </li>
    @endif

      <li class="{{ request()->routeIs('product.*') ? 'active' : '' }}">
        <a href="#">Courses</a>
        <ul class="submenu">
          <li class="{{ request()->routeIs('product.index') ? 'active' : '' }}">
            <a href="{{ route('product.index') }}">View All</a>
          </li>
          <li class="{{ request()->routeIs('product.create') ? 'active' : '' }}">
            <a href="{{ route('product.create') }}">New Course</a>
          </li>
        </ul>
      </li>

      <li class="{{ request()->routeIs('category.*') ? 'active' : '' }}">
        <a href="#">Category</a>
        <ul class="submenu">
          <li class="{{ request()->routeIs('category.index') ? 'active' : '' }}">
            <a href="{{ route('category.index') }}">View All</a>
          </li>
          <li class="{{ request()->routeIs('category.create') ? 'active' : '' }}">
            <a href="{{ route('category.create') }}">New Category</a>
          </li>
        </ul>
      </li>

      <li class="{{ request()->routeIs('customer.*') ? 'active' : '' }}">
        <a href="#">Student</a>
        <ul class="submenu">
          <li class="{{ request()->routeIs('customer.index') ? 'active' : '' }}">
            <a href="{{ route('customer.index') }}">View All</a>
          </li>
          <li class="{{ request()->routeIs('ui.create') ? 'active' : '' }}">
            <a href="{{route('ui.create')}}">Create Student</a>
          </li>
        </ul>
      </li>

      <li class="{{ request()->routeIs('teacher.*') ? 'active' : '' }}">
        <a href="#">Teacher</a>
        <ul class="submenu">
          <li class="{{ request()->routeIs('teacher.index') ? 'active' : '' }}">
            <a href="{{ route('teacher.index') }}">View All</a>
          </li>
          <li class="{{ request()->routeIs('teacher.create') ? 'active' : '' }}">
            <a href="{{route('teacher.create')}}">Create Teacher</a>
          </li>
        </ul>
      </li>

      @if(Session::get('role') === 'admin')
      <li class="{{ request()->routeIs('staff.*') ? 'active' : '' }}">
      <a href="#">Staff</a>
      <ul class="submenu">
        <li class="{{ request()->routeIs('staff.index') ? 'active' : '' }}">
        <a href="{{ route('staff.index') }}">View All</a>
        </li>
        <li class="{{ request()->routeIs('staff.create') ? 'active' : '' }}">
        <a href="{{route('staff.create')}}">Create Staff</a>
        </li>
      </ul>
      </li>
    @endif
    </ul>

    <div class="sidebar-footer">
      <a href="#">
        <i class="bi bi-person"></i>
        {{ \Illuminate\Support\Facades\Session::has('username') ? \Illuminate\Support\Facades\Session::get('username') : '' }}
      </a>
      <a href="{{ route('auth.signout') }}">
        <i class="bi bi-box-arrow-left"></i>
        Logout
      </a>
    </div>
  </nav>

  <!-- JavaScript -->
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('show');
      document.body.classList.toggle('sidebar-open');
    }
  </script>

</body>

</html>