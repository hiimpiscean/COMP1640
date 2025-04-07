<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
  <link href="{{asset('css/responsive.css')}}" rel="stylesheet" />

  <link rel="icon" type="image/x-icon" href="{{asset('images/handicraf/logo1.png')}}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
  <title>ATN Shop</title>

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

  <!-- Custom JS -->
  <script src="js/custom.js"></script>

  <!-- Google Map -->
  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>

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


  @yield('script')

</body>

</html>