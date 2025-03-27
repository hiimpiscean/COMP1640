@extends('masters.uiMaster')
@section('main')
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

  <style>
    .container-xxl{
      margin-top: 106px;
      margin-bottom: 40px;
    }

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
