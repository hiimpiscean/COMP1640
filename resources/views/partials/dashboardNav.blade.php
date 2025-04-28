<nav class="sidebar">
  <div class="sidebar-header">
    <div>
      <li class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
        <a href="{{ route('admin.index') }}">ATN portal</a>
    </div>
  </div>
  <ul class="sidebar-menu">
    <li>
      <a href="{{route('ui.index')}}">Home Page</a>
    </li>
    <li>
      <a href="{{route('learning_materials.pending')}}">Learning Materials</a>
    </li>
    <li class="{{ request()->routeIs('staff.registrations') ? 'active' : '' }}">
      <a href="{{ route('staff.registrations') }}">Course Registrations</a>
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

<style>
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    padding: 20px;
    overflow-y: auto;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    display: flex;
    flex-direction: column;
  }

  .sidebar-header {
    margin-bottom: 30px;
    color: #fff;
    text-align: center;
    padding: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .sidebar-header li {
    list-style: none;
  }

  .sidebar-header a {
    color: #fff;
    font-size: 1.5rem;
    font-weight: bold;
    text-decoration: none;
    display: block;
    padding: 10px;
  }

  .sidebar-menu,
  .submenu {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .sidebar-menu li {
    margin-bottom: 5px;
  }

  .sidebar-menu>li>a {
    color: #ecf0f1;
    display: block;
    text-decoration: none;
    padding: 12px 15px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .sidebar-menu>li>a:hover,
  .submenu li a:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
  }

  .submenu {
    margin-left: 20px;
    margin-top: 5px;
  }

  .submenu li a {
    font-size: 0.9rem;
    color: #bdc3c7;
    display: block;
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 6px;
    transition: all 0.3s ease;
  }

  .sidebar-menu>li.active>a,
  .submenu li.active a {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
  }

  .sidebar-footer {
    margin-top: auto;
    padding: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.1);
  }

  .sidebar-footer a {
    color: #ecf0f1;
    display: block;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 6px;
    transition: all 0.3s ease;
  }

  .sidebar-footer a:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
  }

  .sidebar-footer i {
    margin-right: 10px;
  }

  body {
    margin-left: 250px;
    min-height: 100vh;
  }
</style>