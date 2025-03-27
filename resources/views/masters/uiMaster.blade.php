<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l"
        crossorigin="anonymous">
  <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" type="text/css" href="{{asset('css/css/bootstrap.css')}}"/>

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
        integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ=="
        crossorigin="anonymous"/>
  <!-- font awesome style -->
  <link href="{{asset('css/css/font-awesome.min.css')}}" rel="stylesheet"/>

  <!-- Custom styles for this template -->
  <link href="{{asset('css/css/style.css')}}" rel="stylesheet"/>
  <!-- responsive style -->
  <link href="{{asset('css/css/responsive.css')}}" rel="stylesheet"/>
  <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>

  <link rel="icon" type="image/x-icon" href="{{asset('images/handicraf/logo1.png')}}"/>
  <title>ATN Shop</title>
</head>

<body>
<header>
  @include('partials.uiNav')


</header>

<main role="main">
  @yield('main')
</main>

<div role="other">
  @yield('other')
</div>

<!-- footer section -->
<footer class="footer_section">
  <div class="container">
    <div class="row">
      <div class="col-md-4 footer-col">
        <div class="footer_contact">
          <h4>
            Contact Us
          </h4>
          <div class="contact_link_box">
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-map-marker" aria-hidden="true"></i>
              <span>
                  Hanoi, Vietnam
                </span>
            </a>
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-phone" aria-hidden="true"></i>
              <span>
                  Call +84 123456789
                </span>
            </a>
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <span>
                  admin@gmail.com
                </span>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-4 footer-col">
        <div class="footer_detail">
          <a href="" class="footer-logo">
            ATN Company
          </a>
          <p>
            The brand is present worldwide and has been growing since 2020.
          </p>
          <div class="footer_social">
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-pinterest" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-4 footer-col">
        <h4>
          Opening Hours
        </h4>
        <p>
          Everyday
        </p>
        <p>
          6.00 Am -11.00 Pm
        </p>
      </div>
    </div>
    <div class="footer-info">
      <p>
        &copy; <span id="displayYear"></span> Copyright belongs to
        <a href="#">ATN Company</a><br><br>
        &copy; <span id="displayYear"></span> Distributed By
        <a href="#" target="_blank">ATN</a>
      </p>
    </div>
  </div>
</footer>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF"
        crossorigin="anonymous"></script>
<script src="js/jquery-3.4.1.min.js"></script>
<!-- popper js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<!-- bootstrap js -->
<script src="js/bootstrap.js"></script>
<!-- owl slider -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
</script>
<!-- isotope js -->
<script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
<!-- nice select -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
<!-- custom js -->
<script src="js/custom.js"></script>
<!-- Google Map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
</script>
@yield('script')
</body>

</html>
