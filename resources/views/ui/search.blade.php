@extends('masters.uiMaster')

@section('main')

  <style>
    .container-search {
        max-width: 1700px;
      margin: auto;
    }

    .pa {
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .view {
      margin-bottom: 30px;
      text-align: center;
    }

    .view a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background 0.3s ease-in-out;
    }

    .view a:hover {
      background-color: #0056b3;
    }

    /* Carousel */
    .carousel {
      width: 100%;
      height: 40vh;
      overflow: hidden;
      position: relative;
    }

    .carousel img {
      width: 100%;
      object-fit: cover;
      filter: brightness(60%);
    }

    .carousel-caption {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: #fff;
      text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
    }

    .carousel-caption h1 {
      font-size: 3rem;
      font-weight: bold;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .carousel-caption h1 {
        font-size: 2rem;
      }
    }
  </style>

  <body class="sub_page">
  <section class="food_section">
    <div class="container-search">
      <!-- Carousel -->
      <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active" data-interval="10000">
            <img src="{{ asset('images/images/carousel-1.jpg') }}" class="d-block w-100" alt="Courses">
            <div class="carousel-caption">
              <h1>COURSES</h1>
            </div>
          </div>
        </div>
      </div>

      <!-- Search Results -->
      <div class="heading_container heading_center pa">
        <h1>Your Search Product</h1>
      </div>

      <div class="filters-content flexitem">
        <div class="row grid">
          @if(count($product) > 0)
            @include('partials.productLoop')
          @else
            <div>
              <h2>No products found!</h2>
            </div>
          @endif
        </div>
      </div>

      @if($product->hasMorePages())
        <div class="btn-box view">
          <a href="{{ $product->appends(['query' => $query])->nextPageUrl() }}">
            View More
          </a>
        </div>
      @endif
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
