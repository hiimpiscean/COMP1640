<!DOCTYPE html>
<html lang="en">
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
<style>
  header {
    background: #f5d8c0;
  }

  body {
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    background: url({{asset('images/images/bg.jpg')}});
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
  }

  h2 {
    font-weight: 700;
    font-size: 40px;
    line-height: 1.618em;
  }

  section {
    max-width: 800px;
    margin: 8% auto 1em auto;
    background-color: #222;
    opacity: 0.8;
    filter: alpha(opacity=80); /* For IE8 and earlier */
    color: #fff;
    padding: 1em 5%;
  }

  a {
    color: #00CC66;
  }

  a:focus {
    outline: none;
    outline-offset: inherit;
  }

  @media (max-device-width: 1027px) {

    body {
      text-align: center;
      font-size: larger;
    }

    section {
      max-width: 90%;
    }

  }

  @media (max-device-width: 640px) {
    section {
      max-width: 97%;
    }

  }


</style>

<section>
  <h2>Registration successful!</h2>
  <p>...You will be redirected to the homepage in 5 seconds...</p>

  <p>If you have waited more than a few seconds and you are still seeing this message, please click on <a
      href="{{route('ui.index')}}">this link</a>! Thank you.</p>
</section>

<script>
  setTimeout(function () {
    window.location.href = "{{route('ui.index')}}"
  }, 5000); // 5 second
</script>
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
</body>
</html>
