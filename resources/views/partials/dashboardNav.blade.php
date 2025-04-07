<nav class="sidebar">
  <div class="sidebar-header">
    <h3>ATN portal</h3>
  </div>
  <ul class="sidebar-menu">
    <li>
      <a href="{{route('ui.index')}}">Home Page</a>
    </li>
    <li>
      <a href="{{route('learning_materials.pending')}}">Learning Materials</a>
    </li>
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

    @if(Session::get('role') === 'admin')
    <li class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
      <a href="#">Admin</a>
      <ul class="submenu">
      <li class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
        <a href="{{ route('admin.index') }}">View All</a>
      </li>
      </ul>
    </li>
  @endif

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

    @if(Session::get('role') === 'admin' || Session::get('role') === 'staff')
    <li class="{{ request()->routeIs('staff.registrations') ? 'active' : '' }}">
      <a href="#">Course Registrations</a>
      <ul class="submenu">
        <li class="{{ request()->routeIs('staff.registrations') ? 'active' : '' }}">
          <a href="{{ route('staff.registrations') }}">Pending Registrations</a>
        </li>
      </ul>
    </li>
    @endif

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

<style>
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    background: #343a40;
    padding: 20px;
    overflow-y: auto;
  }

  .sidebar-header {
    margin-bottom: 30px;
    color: #fff;
    text-align: center;
  }

  .sidebar-menu,
  .submenu {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .sidebar-menu li {
    margin-bottom: 10px;
  }

  .sidebar-menu>li>a {
    color: #adb5bd;
    display: block;
    text-decoration: none;
    padding: 10px;
    border-radius: 5px;
    font-weight: bold;
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
    padding: 8px 10px;
    border-radius: 5px;
  }

  /* Hiệu ứng khi menu đang được chọn */
  .sidebar-menu>li.active>a,
  .submenu li.active a {
    background: #17a2b8;
    color: #fff;
  }

  .sidebar-footer {
    margin-top: auto;
    border-top: 1px solid #495057;
    padding-top: 20px;
    color: #adb5bd;
  }

  .sidebar-footer a {
    color: #adb5bd;
    display: block;
    text-decoration: none;
    margin-bottom: 10px;
  }

  .sidebar-footer a:hover {
    color: #fff;
  }

  body {
    margin-left: 250px;
  }
</style>