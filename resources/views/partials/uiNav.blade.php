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
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                        data-toggle="dropdown">
                        PAGES
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('ui.team') }}">Our Team</a>
                        <a class="dropdown-item" href="{{ route('ui.testimonial') }}">Testimonial</a>
                        <a class="dropdown-item" href="#">404 Page</a>
                    </div>
                </li>

                <!-- <li class="nav-item {{ request()->routeIs('ui.approval') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('ui.approval') }}">TEACHER</a>
        </li> -->

            </ul>
            <ul class="nav-item chatbox-item {{ request()->routeIs('chat.index') ? 'active' : '' }}">
                <a class="nav-link" href="#" id="chat-icon" title="Chatbox">
                    <i class="fa fa-comments"></i>
                    <span id="unread-badge" class="badge badge-danger chat-badge" style="display: none;">0</span>
                </a>

                <div class="messages-dropdown" id="unread-messages-container">
                    <div class="dropdown-header">
                        <h6>Unread Messages</h6>
                    </div>
                    <div class="dropdown-list-content" id="unread-messages-dropdown">
                        <div class="message-item text-center">Loading...</div>
                    </div>
                    <div class="dropdown-footer">
                        <a href="{{ route('chat.index') }}" class="view-all">View All Messages</a>
                    </div>
                </div>

            </ul>

            <!-- Kiểm tra đăng nhập -->
            <div class="user_option">
                @if (Session::has('username'))
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown">
                            <img src="{{ asset('images/default-avatar.png') }}" width="30" height="30"
                                class="rounded-circle">
                            {{ Session::get('username') }}
                        </a>
                        <div class="dropdown-menu">
                            @if (Session::has('role') && (Session::get('role') == 'admin' || Session::get('role') == 'staff'))
                                <a class="nav-link" href="{{ route('admin.index') }}">Back to Admin Web</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('auth.signout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('auth.signout') }}" method="GET"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('auth.ask') }}" class="join-now">Join Now →</a>
                @endif
            </div>
        </div>
    </nav>
</div>

<style>
    body {
        overflow-x: hidden;
    }

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

    /* Đối với phần tử chatbox */
    .chatbox-item {
        margin: 0;
        margin-right: 10px;
        position: relative;
    }

    .chatbox-item .nav-link {
        font-size: 1.5rem;
        color: #00bcd4;
        transition: color 0.3s ease, transform 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
    }

    .chatbox-item .nav-link:hover {
        color: #0097a7;
        transform: scale(1.1);
    }

    /* Badge thông báo tin nhắn */
    .chat-badge {
        position: absolute;
        top: 0;
        right: -5px;
        background-color: #e41e3f;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: bold;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        z-index: 1001;
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
        gap: 15px;
    }

    /* Nút đăng nhập / đăng ký */
    .user_option a.join-now {
        background-color: #00bcd4;
        color: #ffffff;
        padding: 10px 18px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.3s ease-in-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 188, 212, 0.3);
    }

    .user_option a.join-now:hover {
        background-color: #008ba3;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 139, 163, 0.4);
    }

    /* Avatar và dropdown user */
    .user_option .dropdown {
        position: relative;
    }

    .user_option .dropdown-toggle {
        display: flex;
        align-items: center;
        font-size: 14px;
        font-weight: 600;
        color: #333;
        text-decoration: none;
        border-radius: 20px;
        background-color: #f1f1f1;
        transition: all 0.3s ease-in-out;
        padding: 10px;
    }

    .user_option .dropdown-toggle img {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        margin-right: 8px;
        border: 2px solid #00bcd4;
    }

    .user_option .dropdown-toggle:hover {
        background-color: #e0f7fa;
    }

    .user_option .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 10px 0;
        display: none;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease-in-out;
        min-width: 100%;
        width: 100%;
    }

    .user_option .dropdown:hover .dropdown-menu {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .user_option .dropdown-menu a {
        display: block;
        padding: 10px 15px;
        color: #333;
        font-size: 14px;
        transition: all 0.3s ease-in-out;
    }

    .user_option .dropdown-menu a:hover {
        background-color: #00bcd4;
        color: white;
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

        .user_option {
            flex-direction: column;
            gap: 10px;
        }

        .user_option .dropdown-menu {
            right: auto;
            left: 50%;
            transform: translate(-50%, 10px);
        }
    }

    /* Dropdown thông báo tin nhắn */
    .messages-dropdown {
        position: absolute;
        right: -100px;
        top: 45px;
        width: 350px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        z-index: 1050;
        display: none;
        transition: all 0.3s ease;
    }

    .messages-dropdown.show {
        display: block;
        opacity: 1;
        z-index: 1100;
    }

    .dropdown-header {
        background-color: #00bcd4;
        color: white;
        padding: 12px 15px;
        font-weight: 600;
        border-radius: 8px 8px 0 0;
    }

    .dropdown-header h6 {
        margin: 0;
        font-size: 16px;
    }

    .dropdown-list-content {
        max-height: 300px;
        overflow-y: auto;
    }

    .message-item {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background-color 0.2s;
        display: flex;
        align-items: flex-start;
    }

    .message-item:hover {
        background-color: #f8f9fa;
    }

    .message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #00bcd4;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 18px;
    }

    .message-content {
        flex: 1;
    }

    .message-sender {
        font-weight: 600;
        color: #333;
        margin-bottom: 3px;
    }

    .message-text {
        color: #666;
        margin-bottom: 3px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .message-time {
        font-size: 12px;
        color: #999;
    }

    .dropdown-footer {
        padding: 10px;
        text-align: center;
        border-top: 1px solid #f0f0f0;
    }

    .view-all {
        color: #00bcd4;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
    }

    .view-all:hover {
        text-decoration: underline;
    }

    /* Hiệu ứng pulse cho biểu tượng chat */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    .message-pulse {
        animation: pulse 1.5s infinite;
    }
</style>
