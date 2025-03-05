@extends('masters.uiMaster')
@section('main')
  <!-- Spinner Start -->
  <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <style>
    #spinner {
      opacity: 0;
      visibility: hidden;
      transition: opacity .5s ease-out, visibility 0s linear .5s;
      z-index: 99999;
    }

    #spinner.show {
      transition: opacity .5s ease-out, visibility 0s linear 0s;
      visibility: visible;
      opacity: 1;
    }
  </style>
  <script>
    window.addEventListener("load", function () {
      document.getElementById("spinner").classList.remove("show");
    });
  </script>
  <!-- Spinner End -->

  <!-- Carousel Start -->
  <div class="container-fluid p-0 mb-5">
    <div class="owl-carousel owl-theme">
      <div class="item">
        <img class="carousel-img" src="{{ asset('images/images/carousel-1.jpg') }}" alt="Slide 1">
        <div class="overlay">
          <div class="content">
            <p class="sub-title">BEST ONLINE COURSES</p>
            <h1 class="main-title">The Best Online Learning Platform</h1>
            <p class="description">
              In fact, it's just a clita lorem. The very pain, but let it be the diam no.
              God bless him and his family justly, and God bless him.
            </p>
            <div class="buttons">
              <a href="#" class="btn btn-primary">Read More</a>
              <a href="#" class="btn btn-light">Join Now</a>
            </div>
          </div>
        </div>
      </div>
      <div class="item">
        <img class="carousel-img" src="{{ asset('images/images/carousel-2.jpg') }}" alt="Slide 2">
        <div class="overlay">
          <div class="content">
            <p class="sub-title">BEST ONLINE COURSES</p>
            <h1 class="main-title">Get Educated Online From Your Home</h1>
            <p class="description">
              God bless him and his family justly, and God bless him.
            </p>
            <div class="buttons">
              <a href="#" class="btn btn-primary">Read More</a>
              <a href="#" class="btn btn-light">Join Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Carousel End -->

  <!-- CSS -->
  <style>
    /* Định dạng chính cho carousel */
    .owl-carousel .item {
      position: relative;
      width: 100%;
      height: 600px;
    }

    /* Ảnh nền full width và giữ tỉ lệ đẹp */
    .carousel-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Lớp overlay làm nền tối */
    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      padding-left: 80px;
    }

    /* Nội dung hiển thị trên ảnh */
    .content {
      color: white;
      max-width: 600px;
      z-index: 2;
    }

    /* Tiêu đề nhỏ */
    .sub-title {
      font-size: 14px;
      font-weight: bold;
      color: #00D1D1;
      text-transform: uppercase;
    }

    /* Tiêu đề chính */
    .main-title {
      font-size: 50px;
      font-weight: bold;
      margin: 10px 0;
    }

    /* Mô tả */
    .description {
      font-size: 18px;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    /* Nút bấm */
    .buttons a {
      padding: 12px 20px;
      border-radius: 25px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
    }

    .btn-primary {
      background-color: #00D1D1;
      color: white;
      border: none;
    }

    .btn-primary:hover {
      background-color: #008080;
    }

    .btn-light {
      background-color: white;
      color: black;
    }

    .btn-light:hover {
      background-color: #ddd;
    }
  </style>

  <!-- Service Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-4 justify-content-center gap-4">
        <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
          <div class="service-item text-center pt-3">
            <a href="{{ route('ui.schedule') }}">
              <div class="p-4">
                <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                <h5 class="mb-3">School Schedule</h5>
                <p>Diam elitr kasd sed at elitr sed very just pain but clita amet diam</p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="700">
          <div class="service-item text-center pt-3">
            <a href="">
              <div class="p-4">
                <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                <h5 class="mb-3">Book Library</h5>
                <p>Diam elitr kasd sed at elitr sed very just pain but clita amet diam</p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Service End -->

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-5">
        <!-- Ảnh bên trái với hiệu ứng fade-in -->
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200" style="min-height: 400px;">
          <div class="position-relative h-100">
            <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('/images/images/about.jpg') }}" alt="" style="object-fit: cover;">
          </div>
        </div>

        <!-- Nội dung bên phải với hiệu ứng fade-up -->
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
          <h1 class="mb-4">Welcome to ATN</h1>
          <p class="mb-4">It was time to get rid of the vines. God, God, let it be God. Somewhere I'm going to have a backyard and them. Clita was the very same thing.</p>
          <p class="mb-4">It was time to get rid of the vines. God, God, let it be God. Somewhere I'm going to have a backyard and them. There was a great deal of pain and suffering, but it was a great deal of pain</p>

          <!-- Hiệu ứng từng dòng xuất hiện dần dần -->
          <div class="row gy-2 gx-4 mb-4">
            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="500">
              <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i> Skilled Instructors</p>
            </div>
            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="600">
              <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i> Online Classes</p>
            </div>
            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="700">
              <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i> International Certificate</p>
            </div>
            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="800">
              <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i> Skilled Instructors</p>
            </div>
            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="900">
              <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i> Online Classes</p>
            </div>
            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="1000">
              <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i> International Certificate</p>
            </div>
          </div>

          <!-- Nút Read More xuất hiện trễ hơn -->
          <a class="btn btn-primary py-3 px-5 mt-2" href="" data-aos="fade-up" data-aos-delay="1100">Read More</a>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

  <!-- Categories Start -->
  <div class="container-xxl py-5 category">
    <div class="container">
      <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h1 class="mb-5">Courses Categories</h1>
      </div>
      <div class="category-grid">
        @foreach($category as $index => $c)
          <div class="category-item" data-aos="fade-up" data-aos-delay="{{ 100 * $index }}">
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

  <!-- Courses Start -->
  <div class="text-center wow fadeInUp" data-wow-delay="0.1s" data-aos="fade-up">
    <h1 class="mb-5">Popular Courses</h1>
  </div>
  <div class="row grid" data-aos="fade-up">
    @include('partials.productLoop')
  </div>
  <!-- Courses End -->

  <!-- Team Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="text-center" data-aos="fade-up" data-aos-delay="100">
        <h1 class="mb-5">Expert Instructors</h1>
      </div>
      <div class="row g-4">
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="team-item bg-light">
            <div class="overflow-hidden">
              <img class="img-fluid" src="{{ asset('/images/images/team-1.jpg') }}" alt="">
            </div>
            <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
              <div class="bg-light d-flex justify-content-center pt-2 px-1">
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
              </div>
            </div>
            <div class="text-center p-4">
              <h5 class="mb-0">Instructor Name</h5>
              <small>Designation</small>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="team-item bg-light">
            <div class="overflow-hidden">
              <img class="img-fluid" src="{{ asset('/images/images/team-2.jpg') }}" alt="">
            </div>
            <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
              <div class="bg-light d-flex justify-content-center pt-2 px-1">
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
              </div>
            </div>
            <div class="text-center p-4">
              <h5 class="mb-0">Instructor Name</h5>
              <small>Designation</small>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
          <div class="team-item bg-light">
            <div class="overflow-hidden">
              <img class="img-fluid" src="{{ asset('/images/images/team-3.jpg') }}" alt="">
            </div>
            <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
              <div class="bg-light d-flex justify-content-center pt-2 px-1">
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
              </div>
            </div>
            <div class="text-center p-4">
              <h5 class="mb-0">Instructor Name</h5>
              <small>Designation</small>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="700">
          <div class="team-item bg-light">
            <div class="overflow-hidden">
              <img class="img-fluid" src="{{ asset('/images/images/team-4.jpg') }}" alt="">
            </div>
            <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
              <div class="bg-light d-flex justify-content-center pt-2 px-1">
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
              </div>
            </div>
            <div class="text-center p-4">
              <h5 class="mb-0">Instructor Name</h5>
              <small>Designation</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Team End -->

  <!-- Testimonial Start -->
  <div class="container-xxl py-5" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
      <div class="text-center">
        <h1 class="mb-5">Our Students Say!</h1>
      </div>
      <div class="owl-carousel testimonial-carousel position-relative">
        <div class="testimonial-item text-center">
          <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('/images/images/testimonial-1.jpg') }}" style="width: 80px; height: 80px;">
          <h5 class="mb-0">Client Name</h5>
          <p>Profession</p>
          <div class="testimonial-text bg-light text-center p-4 shadow-sm rounded">
            <p class="mb-0">It was time to get rid of the vines. Diam pain diam diam diam diam diam diam diam and them. Clita was the very same thing.</p>
          </div>
        </div>
        <div class="testimonial-item text-center">
          <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('/images/images/testimonial-2.jpg') }}" style="width: 80px; height: 80px;">
          <h5 class="mb-0">Client Name</h5>
          <p>Profession</p>
          <div class="testimonial-text bg-light text-center p-4 shadow-sm rounded">
            <p class="mb-0">It was time to get rid of the vines. Diam pain diam diam diam diam diam diam diam and them. Clita was the very same thing.</p>
          </div>
        </div>
        <div class="testimonial-item text-center">
          <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('/images/images/testimonial-3.jpg') }}" style="width: 80px; height: 80px;">
          <h5 class="mb-0">Client Name</h5>
          <p>Profession</p>
          <div class="testimonial-text bg-light text-center p-4 shadow-sm rounded">
            <p class="mb-0">It was time to get rid of the vines. Diam pain diam diam diam diam diam diam diam and them. Clita was the very same thing.</p>
          </div>
        </div>
        <div class="testimonial-item text-center">
          <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('/images/images/testimonial-4.jpg') }}" style="width: 80px; height: 80px;">
          <h5 class="mb-0">Client Name</h5>
          <p>Profession</p>
          <div class="testimonial-text bg-light text-center p-4 shadow-sm rounded">
            <p class="mb-0">It was time to get rid of the vines. Diam pain diam diam diam diam diam diam diam and them. Clita was the very same thing.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Testimonial End -->

  <style>
    /* Cấu trúc cơ bản cho mỗi service */
    .service-item {
      background: #fff;
      border-radius: 10px;
      transition: 0.3s ease-in-out;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      position: relative;
    }

    .service-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .service-item a:hover {
      text-decoration: none;
    }

    .service-item i {
      transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
    }

    .service-item:hover i {
      transform: translateY(-5px);
      color: #004a99;
    }

    .service-item h5 {
      font-size: 18px;
      font-weight: bold;
      color: #333;
    }

    .service-item p {
      font-size: 14px;
      color: #666;
    }

    /* Giới thiệu */
    .about .section-title {
      display: inline-block;
      padding: 0 10px;
      background: #fff;
      position: relative;
      z-index: 1;
    }
    .about .section-title::before {
      content: '';
      background: #f39c12;
      width: 100%;
      height: 100%;
      position: absolute;
      top: 50%;
      left: 0;
      z-index: -1;
      transform: translateY(-50%);
    }
    .about h1 {
      font-size: 36px;
      font-weight: 700;
      margin-bottom: 20px;
    }
    .about p {
      margin-bottom: 20px;
    }
    .about .row gy-2 gx-4 .col-sm-6 p {
      margin-bottom: 0;
    }
    .about .btn {
      border-radius: 50px;
    }

    /* Căn chỉnh container chính */
    .category {
      padding: 50px 0;
      background-color: #f8f9fa;
      text-align: center;
    }

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

    .category-item:hover img {
      transform: scale(1.05);
      opacity: 0.9;
    }

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

    /* Responsive */
    @media (max-width: 768px) {
      .category-grid {
        grid-template-columns: 1fr;
      }
    }

    /* ========== Expert Instructors Styles ========== */
    .container-xxl {
      padding: 60px 0;
      background-color: #f8f9fa;
    }

    .text-center h1 {
      font-size: 2.5rem;
      font-weight: bold;
      color: #333;
      text-transform: uppercase;
      margin-bottom: 30px;
      position: relative;
    }

    .text-center h1::after {
      content: "";
      width: 80px;
      height: 4px;
      background-color: #007bff;
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 2px;
    }

    .team-item {
      border-radius: 10px;
      overflow: hidden;
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .team-item:hover {
      transform: translateY(-5px);
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
    }

    .team-item img {
      width: 100%;
      height: 260px;
      object-fit: cover;
      transition: transform 0.3s ease-in-out;
    }

    .team-item:hover img {
      transform: scale(1.05);
    }

    .position-relative .bg-light {
      border-radius: 50px;
      padding: 5px 10px;
      box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease-in-out;
    }

    .team-item:hover .bg-light {
      background-color: #007bff;
    }

    .btn-sm-square {
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      border-radius: 50%;
      transition: all 0.3s ease-in-out;
    }

    .btn-sm-square:hover {
      background-color: white !important;
      color: #007bff !important;
    }

    .text-center h5 {
      font-size: 1.2rem;
      font-weight: bold;
      color: #333;
      margin-bottom: 5px;
    }

    .text-center small {
      font-size: 0.9rem;
      color: #666;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .text-center h1 {
        font-size: 2rem;
      }
      .team-item img {
        height: 220px;
      }
    }

    /* Tùy chỉnh khối testimonial */
    .testimonial-item {
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
      padding: 20px;
      border-radius: 10px;
    }

    /* Hiệu ứng hover làm nổi bật review */
    .testimonial-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Ảnh đại diện khách hàng */
    .testimonial-item img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 3px solid #007bff;
      transition: transform 0.3s ease-in-out;
    }

    /* Khi hover vào testimonial, ảnh khách hàng phóng to nhẹ */
    .testimonial-item:hover img {
      transform: scale(1.1);
    }

    /* Tùy chỉnh phần text */
    .testimonial-text {
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      font-style: italic;
      color: #333;
    }

    /* Tăng cỡ chữ tên khách hàng */
    .testimonial-item h5 {
      font-size: 18px;
      font-weight: bold;
      color: #004a99;
    }

    /* Căn chỉnh phần nghề nghiệp */
    .testimonial-item p {
      font-size: 14px;
      color: #777;
    }

    /* Cải thiện hiển thị carousel nếu dùng Owl Carousel */
    .owl-carousel .owl-nav {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
    }

    .owl-carousel .owl-nav button {
      background-color: #007bff !important;
      color: white !important;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      transition: 0.3s ease-in-out;
    }

    .owl-carousel .owl-nav button:hover {
      background-color: #004a99 !important;
    }

    /* Tùy chỉnh dot (chấm chuyển đổi slide) */
    .owl-carousel .owl-dots {
      margin-top: 20px;
    }

    .owl-carousel .owl-dot {
      width: 12px;
      height: 12px;
      margin: 5px;
      background: #ddd !important;
      border-radius: 50%;
      transition: 0.3s;
    }

    .owl-carousel .owl-dot.active {
      background: #007bff !important;
    }

  </style>

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
