<div class="container-fluid">
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="{{route('ui.index')}}">
      <img src="{{asset('images/handicraf/logo1.png')}}" width="35" height="40" alt="">
      ATN
    </a>

    <!-- Thanh tìm kiếm đặt ngoài menu -->
    <form class="search-bar" action="{{ route('ui.search') }}" method="GET">
      <input type="text" name="query" class="search-input" placeholder="Search...">
      <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
    </form>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
          <a class="nav-link" href="{{route('ui.index')}}">HOME</a>
        </li>
        <li class="nav-item {{ request()->is('blog') ? 'active' : '' }}">
          <a class="nav-link" href="{{route('ui.blog')}}">BLOG</a>
        </li>
        <li class="nav-item {{ request()->is('home/products') ? 'active' : '' }}">
          <a class="nav-link" href="{{route('ui.home')}}">COURSES</a>
        </li>
        <li class="nav-item dropdown {{ request()->is('pages*') ? 'active' : '' }}">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown">PAGES</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('ui.team')}}">Our Team</a>
            <a class="dropdown-item" href="{{route('ui.testimonial')}}">Testimonial</a>
            <a class="dropdown-item" href="#">404 Page</a>
          </div>
        </li>
        <li class="nav-item {{ request()->is('contact') ? 'active' : '' }}">
          <a class="nav-link" href="#">CONTACT</a>
        </li>
      </ul>

      <div class="user_option">
        <a href="{{route('ui.create')}}">Join Now →</a>
      </div>
    </div>
  </nav>
</div>
<style>
  /* Reset chung */
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
    transition: background 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: space-between;
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
    width: 40px;
    height: 45px;
  }

  /* Menu */
  .navbar-nav {
    flex-wrap: wrap;
  }

  .navbar-nav .nav-link {
    color: #333;
    font-weight: 600;
    margin: 0 12px;
    transition: color 0.3s ease, transform 0.2s ease;
  }

  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link.active {
    color: #0097a7;
    transform: translateY(-2px);
  }

  /* Nút Toggle */
  .navbar-toggler {
    border: none;
    outline: none;
    background: none;
  }

  .navbar-toggler-icon {
    background-image: url("https://cdn-icons-png.flaticon.com/512/56/56763.png");
    background-size: cover;
    width: 30px;
    height: 30px;
  }

  /* User Options */
  .user_option a {
    background-color: #00bcd4;
    color: #ffffff;
    padding: 10px 15px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s ease, transform 0.2s ease;
  }

  .user_option a:hover {
    background-color: #008ba3;
    transform: scale(1.05);
  }

  /* Dropdown */
  .dropdown-menu {
    display: block;
    opacity: 0;
    transform: translateY(-10px);
    visibility: hidden;
    transition: opacity 0.4s ease, transform 0.4s ease;
  }

  .dropdown:hover .dropdown-menu {
    opacity: 1;
    transform: translateY(0);
    visibility: visible;
  }

  .dropdown-menu a {
    color: #333;
    padding: 10px 15px;
    display: block;
    transition: background 0.3s ease, padding-left 0.2s ease;
  }

  .dropdown-menu a:hover {
    background-color: #00bcd4;
    color: #fff;
    padding-left: 20px;
  }

  .search-bar {
    display: flex;
    align-items: center;
    background: #f1f1f1;
    border-radius: 30px;
    padding: 6px 12px;
    transition: all 0.3s ease-in-out;
    width: 220px;
    max-width: 40%; /* Giới hạn tối đa chiều rộng */
    min-width: 120px; /* Không để quá nhỏ */
    position: absolute;
    right: 180px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1050;
    margin-right: 20px;
  }

  .search-bar:hover {
    box-shadow: 0 0 10px rgba(0, 188, 212, 0.5);
    background: #ffffff;
  }

  .search-input {
    border: none;
    outline: none;
    background: transparent;
    flex: 1;
    font-size: 14px;
    padding: 5px;
    min-width: 80px; /* Giữ chữ không bị ẩn */
  }

  .search-button {
    background: transparent;
    border: none;
    color: #00bcd4;
    font-size: 18px;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
    flex-shrink: 0; /* Không cho nút search co lại */
  }

  .search-button:hover {
    transform: scale(1.2);
  }

  .container-fluid {
    padding: 0;
    margin-top: 65px;
  }

  @media (max-width: 992px) {
    .search-bar {
      width: 180px;
      max-width: 35%;
      right: 140px;
    }
  }

  @media (max-width: 768px) {
    .search-bar {
      width: 160px;
      max-width: 30%;
      right: 100px;
    }
  }

  @media (max-width: 576px) {
    .search-bar {
      width: 140px;
      max-width: 25%;
      right: 60px;
    }
  }

  /* Active state styling */
  .navbar-nav .nav-item.active .nav-link {
    color: #00bcd4;
    font-weight: bold;
  }
</style>
