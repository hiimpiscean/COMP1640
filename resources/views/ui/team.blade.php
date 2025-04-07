@extends('masters.uiMaster')
@section('main')
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
<style>
  /* Khoảng cách và màu nền */
  .container-xxl {
    padding: 60px 0;
    background-color: #f8f9fa;
  }

  /* Tiêu đề chính */
  .text-center h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
    text-transform: uppercase;
    margin-bottom: 30px;
    position: relative;
  }

  /* Hiệu ứng underline cho tiêu đề */
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

  /* Khối thông tin giảng viên */
  .team-item {
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
  }

  /* Hiệu ứng hover nổi bật */
  .team-item:hover {
    transform: translateY(-5px);
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
  }

  /* Hình ảnh giảng viên */
  .team-item img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
  }

  /* Hiệu ứng zoom ảnh khi hover */
  .team-item:hover img {
    transform: scale(1.05);
  }

  /* Khối chứa icon mạng xã hội */
  .position-relative .bg-light {
    border-radius: 50px;
    padding: 5px 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
  }

  /* Hiệu ứng hover làm nổi icon */
  .team-item:hover .bg-light {
    background-color: #007bff;
  }

  /* Màu icon mạng xã hội */
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

  /* Hover icon mạng xã hội */
  .btn-sm-square:hover {
    background-color: white !important;
    color: #007bff !important;
  }

  /* Thông tin giảng viên */
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
