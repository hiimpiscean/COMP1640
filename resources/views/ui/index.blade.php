@extends('masters.uiMaster')

@section('main')

  <style>
    /* === CAROUSEL === */
    /* Làm cho carousel full màn hình */
    .carousel {
      width: 100%;
      height: 40vh;
      overflow: hidden;
    }

    .carousel-img {
      width: 100%;
      height: 40vh;
      object-fit: cover;
      filter: brightness(50%);
    }

    .carousel-caption {
      position: absolute;
      top: 70%;
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

    /* === COURSES CATEGORY === */
    /* Căn chỉnh container chính */
    .category {
      padding: 50px 0;
      background-color: #f8f9fa;
      text-align: center;
    }

    /* Bố cục grid */
    .category-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-template-rows: auto auto;
      gap: 15px;
    }

    /* Item danh mục */
    .category-item {
      position: relative;
      border-radius: 10px;
      overflow: hidden;
      grid-column: span 1;
      height: 150px;
    }

    /* Hình ảnh danh mục */
    .category-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
    }

    /* Hiệu ứng hover */
    .category-item:hover img {
      transform: scale(1.05);
      opacity: 0.9;
    }

    /* Hộp chứa text */
    .category-text {
      position: absolute;
      bottom: 10px;
      right: 10px;
      background: rgb(255, 255, 255);
      padding: 10px 15px;
      border-radius: 5px;
      text-align: right;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .category-text h5 {
      margin: 0;
      font-size: 1.1rem;
      font-weight: bold;
    }

    .category-text small {
      color: #007bff;
      font-weight: bold;
    }

    @media (max-width: 768px) {
      .category-grid {
        grid-template-columns: 1fr;
      }
    }

    /* === POPULAR COURSES === */
    .heading_container {
      text-align: center;
      margin-bottom: 40px;
    }

    .heading_container h1 {
      font-size: 2.5rem;
      font-weight: bold;
      color: #333;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .filters-content {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
    }
  </style>

  <body class="sub_page">
  <section class="food_section">

    <!-- Carousel -->
    <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active" data-interval="10000">
          <img src="{{ asset('images/images/carousel-1.jpg') }}" class="d-block w-100 carousel-img" alt="Courses">
          <div class="carousel-caption">
            <h1>Courses</h1>
          </div>
        </div>
      </div>
    </div>

    <div class="container-xxl py-5 category">
      <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
          <div class="heading_container" data-aos="fade-up">
            <h1 class="mb-5">Courses Categories</h1>
          </div>
        </div>
        <div class="category-grid">
          @foreach($category as $index => $c)
            <div class="category-item" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
              <a href="{{ route('ui.showproducts', ['id_cate' => $c->id_cate]) }}">
                <img src="{{ asset('images/category/' . $c->image_cate) }}" alt="{{ $c->name_cate }}">
                <div class="category-text">
                  <h5>{{ $c->name_cate }}</h5>
                  <small>49 Courses</small>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <!-- Categories End -->

    <!-- Popular Courses -->
    <div class="heading_container" data-aos="fade-up">
      <h1>All Courses</h1>
    </div>

    <div class="filters-content" data-aos="fade-up">
      <div class="row grid">
        @include('partials.productLoop')
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
