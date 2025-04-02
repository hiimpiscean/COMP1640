<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  {{--
  <link rel="stylesheet" href="{{asset('css/hanstyle.css')}}">--}}
  {{--///////////////////////////--}}
  <link rel="stylesheet" href="{{asset('mau/font.css')}}" />
  <link rel="stylesheet" href="{{'mau/bootstrap.css'}}" />
  <link rel="stylesheet" href="{{'mau/templatemo.css'}}}">
  {{-- ////////////////////////////--}}

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">


  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,600i,700,700i" rel="stylesheet">

  <title>ATN Shop</title>

</head>

<body>
  <header>
    {{-- @if(1 + 1 == 2)--}}
    {{-- @include('partials.bookNav')--}}
    {{-- @else--}}
    {{-- @include('partials.bookdemoNav')--}}
    {{-- @endif--}}
    @include('partials.dashboardNav')

  </header>

  <main role="main">
    @yield('main')
  </main>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
    integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF"
    crossorigin="anonymous"></script>


  {{--
  <script src="jquery.js" type="text/javascript"></script>--}}

  {{--
  <script src="main.js" type="text/javascript"></script>--}}
  {{--nếu trang nào có scrip riêng thì sẽ loat vào đây--}}
  @yield('script')


</body>

</html>