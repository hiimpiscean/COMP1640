@extends('masters.uiMaster')

@section('main')

  <style>
    /* ==== Định dạng chung ==== */
    body {
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }

    /* ==== Carousel ==== */
    .carousel {
      width: 100%;
      max-height: 400px;
      overflow: hidden;
    }

    .carousel-item {
      width: 100%;
      height: 400px;
      position: relative;
    }

    .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      filter: brightness(0.7);
    }

    .carousel-caption {
      position: absolute;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(0, 0, 0, 0.7);
      padding: 10px 20px;
      border-radius: 12px;
      text-align: center;
      color: #fff;
      font-size: 1.8rem;
      font-weight: bold;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
      max-width: 90%;
    }

    /* ==== Section Product ==== */
    .heading_container {
      text-align: center;
      margin: 50px 0;
    }

    .heading_container h1 {
      font-size: 2.5rem;
      font-weight: bold;
      color: #333;
      text-transform: capitalize;
    }

    /* ==== Card Product ==== */
    .product_card {
      border-radius: 10px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .product_card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .product_card:hover {
      transform: translateY(-10px);
    }

    .product_card .info {
      padding: 15px;
      text-align: center;
    }

    .product_card .info h5 {
      font-size: 1.2rem;
      color: #333;
      margin-bottom: 10px;
    }

    .product_card .info p {
      font-size: 1rem;
      color: #666;
    }

    .product_card .info .price {
      font-size: 1.3rem;
      color: #27ae60;
      font-weight: bold;
      margin-top: 10px;
    }
  </style>

  <body class="sub_page">
  <section class="food_section">
    <div class="container">
      <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active" data-interval="10000">
            <img src="{{ asset('images/images/cate-courses.jpg') }}" class="d-block w-100" alt="...">
            <div class="carousel-caption">
              <h1>Welcome to ATN Website</h1>
            </div>
          </div>
        </div>
      </div>

      <?php $cat_lower = strtolower($category->name_cate); ?>
      <div class="heading_container">
        <h1>Products from <?php echo $cat_lower; ?></h1>
      </div>

      <div class="filters-content">
        <div class="row grid">
          @include('partials.productLoop')
        </div>
      </div>
    </div>
  </section>
  </body>

@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true,
    });
  </script>
@endsection
