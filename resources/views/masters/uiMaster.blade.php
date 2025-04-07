<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

  <!-- Custom styles -->
  <link href="{{asset('css/style.css')}}" rel="stylesheet" />

  <link rel="icon" type="image/x-icon" href="{{asset('images/handicraf/logo1.png')}}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
  <title>ATN e-Learning</title>

  <style>
    /* Định vị lại dot indicator */
    .owl-dots {
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      justify-content: center;
      width: 100%;
    }

    .owl-dot {
      width: 12px;
      height: 12px;
      margin: 5px;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.5);
      transition: all 0.3s ease;
    }

    .owl-dot.active {
      background-color: #00D1D1;
      transform: scale(1.2);
    }

    /* Hiệu ứng pulse cho biểu tượng chat khi có tin nhắn mới */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .message-pulse {
        animation: pulse 1.5s infinite;
    }
  </style>
</head>

<body>

  <header>
    @if (!Request::routeIs('ui.store'))
    @include('partials.uiNav')
  @endif
  </header>

  <main role="main">
    @yield('main')
  </main>

  <div role="other">
    @yield('other')
  </div>

  <!-- Footer -->
  <footer>
    @if (!Request::routeIs('ui.store'))
    @include('partials.uiFooter')
  @endif
  </footer>

  <!-- jQuery (FULL Version) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Owl Carousel JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <!-- Google Map -->
  <script>
    // Định nghĩa myMap function để tránh lỗi
    function myMap() {
      // Function này trống - chỉ để tránh lỗi
    }
  </script>
  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap&loading=async"></script>

  <!-- Khởi tạo Owl Carousel -->
  <script>
    $(document).ready(function () {
      $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        dots: true,
        autoplay: true,
        autoplayTimeout: 3000,
        dotsContainer: '.owl-dots',
        responsive: {
          0: { items: 1 },
          600: { items: 1 },
          1000: { items: 1 }
        }
      });
    });

  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var dropdowns = document.querySelectorAll(".nav-item.dropdown");

      dropdowns.forEach(function (dropdown) {
        var menu = dropdown.querySelector(".dropdown-menu");

        dropdown.addEventListener("mouseenter", function () {
          menu.style.display = "block";
          setTimeout(() => {
            menu.style.opacity = "1";
            menu.style.transform = "translateY(0)";
            menu.style.visibility = "visible";
          }, 10);
        });

        dropdown.addEventListener("mouseleave", function () {
          menu.style.opacity = "0";
          menu.style.transform = "translateY(-10px)";
          menu.style.visibility = "hidden";
          setTimeout(() => {
            menu.style.display = "none";
          }, 400);
        });
      });
    });
  </script>

  <!-- Script kiểm tra tin nhắn chưa đọc -->
  @if(Session::has('username'))
  <script>
    $(document).ready(function() {
      // Thiết lập token CSRF cho tất cả các request Ajax
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // Hàm để lấy số lượng tin nhắn chưa đọc
      function getUnreadMessageCount() {
        $.ajax({
          url: "{{ route('get.unread.count') }}",
          type: "GET",
          cache: false,
          success: function(response) {
            if (response.success) {
              if (response.unread_count > 0) {
                // Hiển thị badge với số lượng tin nhắn chưa đọc
                const badgeElement = document.getElementById('unread-badge');
                if (badgeElement) {
                  badgeElement.textContent = response.unread_count;
                  badgeElement.style.display = 'flex';
                } else {
                  // Tạo lại badge nếu không tìm thấy
                  $('.chatbox-item .nav-link').append('<span id="unread-badge" class="badge badge-danger chat-badge" style="display: flex !important;">' + response.unread_count + '</span>');
                }

                // Thêm hiệu ứng nhấp nháy cho biểu tượng chat
                $('.chatbox-item .nav-link').addClass('message-pulse');

                // Nếu có tin nhắn chưa đọc, cập nhật danh sách tin nhắn
                getUnreadMessages();
              } else {
                // Ẩn badge nếu không có tin nhắn chưa đọc
                const badgeElement = document.getElementById('unread-badge');
                if (badgeElement) {
                  badgeElement.style.display = 'none';
                }
                $('.chatbox-item .nav-link').removeClass('message-pulse');

                // Cập nhật dropdown để hiển thị "Không có tin nhắn mới"
                $('#unread-messages-dropdown').html('<div class="message-item text-center">No new messages</div>');
              }
            }
          },
          error: function(xhr, status, error) {
          }
        });
      }

      // Hàm để lấy danh sách tin nhắn chưa đọc
      function getUnreadMessages() {
        $.ajax({
          url: "{{ route('get.unread.messages') }}",
          type: "GET",
          cache: false,
          success: function(response) {
            if (response.success && response.messages && response.messages.length > 0) {
              // Xóa nội dung cũ của dropdown
              $('#unread-messages-dropdown').empty();

              // Thêm từng tin nhắn vào dropdown
              response.messages.forEach(function(message) {
                const initial = message.sender ? message.sender.charAt(0).toUpperCase() : '?';
                const messageText = message.text || "Tin nhắn mới"; // Fallback nếu không có nội dung
                const messageItem = `
                  <div class="message-item" onclick="goToChat('${message.sender}')">
                    <div class="message-avatar">${initial}</div>
                    <div class="message-content">
                      <div class="message-sender">${message.sender}</div>
                      <div class="message-text">${messageText}</div>
                      <div class="message-time">${message.timestamp || "Vừa xong"}</div>
                    </div>
                  </div>
                `;
                $('#unread-messages-dropdown').append(messageItem);
              });
            } else {
              // Nếu không có tin nhắn, hiển thị thông báo
              $('#unread-messages-dropdown').html('<div class="message-item text-center">No new messages</div>');
            }
          },
          error: function(xhr, status, error) {
            $('#unread-messages-dropdown').html('<div class="message-item text-center">Đã xảy ra lỗi</div>');
          }
        });
      }

      // Hàm điều hướng đến chat với người gửi
      window.goToChat = function(sender) {
        // Đánh dấu đã đọc
        $.ajax({
          url: "{{ route('mark.messages.read') }}",
          type: "POST",
          data: {
            sender_email: sender,
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            if (response.success) {
              // Cập nhật badge và dropdown
              getUnreadMessageCount();

              // Đặt localStorage để lưu người gửi tin nhắn được chọn
              localStorage.setItem('selected_chat_user', sender);

              // Chuyển hướng đến trang chat
              window.location.href = "/chat";
            } else {
              window.location.href = "/chat?user=" + encodeURIComponent(sender);
            }
          },
          error: function() {
            window.location.href = "/chat?user=" + encodeURIComponent(sender);
          }
        });
      };

      // Sửa click handler cho chat icon
      $('#chat-icon').on('click', function(e) {
        e.preventDefault(); // Ngăn chặn chuyển trang khi click

        // Hiển thị/ẩn dropdown tin nhắn
        $('#unread-messages-container').toggleClass('show');
      });

      // Đóng dropdown khi click ra ngoài
      $(document).on('click', function(e) {
        if (!$(e.target).closest('.chatbox-item').length) {
          $('#unread-messages-container').removeClass('show');
        }
      });

      // Lắng nghe sự kiện từ localStorage - sửa lại cách xử lý
      window.addEventListener('storage', function(e) {
        // Xử lý sự kiện khi có tin nhắn mới
        if (e.key === 'new_message_sent' || e.key === 'new_message_received' || e.key === 'unread_count_updated') {
          try {
            const data = JSON.parse(e.newValue || '{}');
            const now = Date.now();

            // Chỉ xử lý tin nhắn gửi trong vòng 10 giây gần đây
            if (data && now - data.timestamp < 10000) {
              // Kiểm tra xem người nhận có phải là người dùng hiện tại không
              const currentUser = "{{ Session::get('username') }}";
              if (data.receiver === currentUser || data.action === 'unread_count_updated') {
                // Cập nhật badge và danh sách tin nhắn
                getUnreadMessageCount();
              }
            }
          } catch (err) {
          }
        }

        // Xử lý sự kiện khi có tin nhắn được đánh dấu đã đọc
        if (e.key === 'messages_marked_read') {
          try {
            const data = JSON.parse(e.newValue || '{}');
            // Cập nhật lại UI nếu có tin nhắn được đánh dấu đã đọc
            getUnreadMessageCount();
          } catch (err) {
          }
        }
      });

      // Lắng nghe sự kiện trực tiếp cho các cập nhật tin nhắn
      window.addEventListener('unread_count_updated', function(e) {
        getUnreadMessageCount();
      });

      // Lắng nghe sự kiện mới tin nhắn mới
      window.addEventListener('new_message_received', function(e) {
        getUnreadMessageCount();
      });

      // Thêm cập nhật định kỳ thường xuyên hơn
      setInterval(function() {
        if (!document.hidden) { // Chỉ cập nhật khi tab đang active
          getUnreadMessageCount();
        }
      }, 5000); // Cập nhật mỗi 5 giây

      // Cập nhật khi tab được kích hoạt lại
      document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
          getUnreadMessageCount();
          getUnreadMessages();
        }
      });
    });
  </script>
  @endif

  @yield('script')

</body>

</html>
