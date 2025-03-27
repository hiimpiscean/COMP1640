<div class="container-fluid">
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="{{ route('ui.index') }}">
      <img src="{{ asset('images/handicraf/logo1.png') }}" width="35" height="40" alt="Logo">
      ATN
    </a>

    <!-- Thanh tìm kiếm -->
    <form class="search-bar" action="{{ route('ui.search') }}" method="GET">
      <input type="text" name="query" class="search-input" placeholder="Search...">
      <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
    </form>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><i class="fa-solid fa-bars"></i></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item {{ request()->routeIs('ui.index') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('ui.index') }}">HOME</a>
        </li>
        <li class="nav-item {{ request()->routeIs('blog.index') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('blog.index') }}">BLOG</a>
        </li>
        <li class="nav-item {{ request()->routeIs('ui.home') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('ui.home') }}">COURSES</a>
        </li>
        <li class="nav-item dropdown {{ request()->is('pages*') ? 'active' : '' }}">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown">
            PAGES
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('ui.team') }}">Our Team</a>
            <a class="dropdown-item" href="{{ route('ui.testimonial') }}">Testimonial</a>
            <a class="dropdown-item" href="#">404 Page</a>
          </div>
        </li>
      </ul>

      <!-- Kiểm tra đăng nhập -->
      <div class="user_option">
        @if(Auth::check())
          <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown">
              <img src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}" width="30" height="30" class="rounded-circle">
              {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
              <a class="dropdown-item" href="{{ route('logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </div>
        @else
          <a href="{{ route('auth.signin') }}" class="join-now">Join Now →</a>
        @endif
      </div>
    </div>
  </nav>
</div>

<style>
  /* Reset mặc định */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  /* Navbar */
  .navbar {
    background-color: #ffffff;
    padding: 12px 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
  }

  /* Logo */
  .navbar-brand {
    font-weight: bold;
    font-size: 1.6rem;
    color: #00bcd4 !important;
    display: flex;
    align-items: center;
  }

  .navbar-brand img {
    margin-right: 10px;
  }

  /* Menu */
  .navbar-nav .nav-link {
    color: #333;
    font-weight: 600;
    margin: 0 12px;
    transition: all 0.3s ease;
  }

  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link.active {
    color: #0097a7;
    transform: translateY(-2px);
  }

  /* Dropdown */
  .dropdown-menu {
    display: none;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
  }

  .dropdown:hover .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0);
  }

  .dropdown-menu a {
    color: #333;
    padding: 10px 15px;
    transition: all 0.3s ease;
  }

  .dropdown-menu a:hover {
    background-color: #00bcd4;
    color: #fff;
    padding-left: 20px;
  }

  /* Thanh tìm kiếm */
  .search-bar {
    display: flex;
    align-items: center;
    background: #f1f1f1;
    border-radius: 30px;
    padding: 6px 12px;
    transition: all 0.3s ease-in-out;
    width: 220px;
    position: relative;
    margin-right: 20px;
  }

  .search-input {
    border: none;
    outline: none;
    background: transparent;
    flex: 1;
    font-size: 14px;
    padding: 5px;
  }

  .search-button {
    background: transparent;
    border: none;
    color: #00bcd4;
    font-size: 18px;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
  }

  .search-button:hover {
    transform: scale(1.2);
  }

  /* User Options */
  .user_option {
    display: flex;
    align-items: center;
  }

  .user_option a {
    background-color: #00bcd4;
    color: #ffffff;
    padding: 10px 15px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.3s ease;
  }

  .user_option a:hover {
    background-color: #008ba3;
    transform: scale(1.05);
  }

  .user_option img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 8px;
  }

  /* Responsive */
  @media (max-width: 991px) {
    .navbar-nav {
      text-align: center;
    }
    .search-bar {
      width: 100%;
      max-width: 250px;
      margin: 10px auto;
    }
  }
</style>
