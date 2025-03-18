<!-- Courses Start -->
<div class="container">
  <div class="row justify-content-center">
    @foreach($product as $p)
      <!-- Course Item -->
      <div class="col-lg-4 col-md-6 col-sm-12 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
        <div class="course-item shadow-sm">
          <div class="course-image">
            <a href="{{ route('ui.details', $p->id_p) }}">
              <img src="{{ asset('images/handicraf/' . $p->image_p) }}" alt="{{ $p->name_p }}" class="img-fluid">
            </a>
            <div class="course-buttons">
              <a href="{{ route('ui.details', $p->id_p) }}" class="btn btn-primary">Read More</a>
              <a href="{{ route('auth.ask') }}" class="btn btn-outline-primary">Join Now</a>
            </div>
          </div>
          <div class="course-content text-center p-3">
            <h3 class="price">VND {{ number_format($p->price_p, 0, ',', '.') }}</h3>
            <div class="rating mb-2">
              <i class="fa fa-star text-warning"></i>
              <i class="fa fa-star text-warning"></i>
              <i class="fa fa-star text-warning"></i>
              <i class="fa fa-star text-warning"></i>
              <i class="fa fa-star text-warning"></i>
              <small>(123)</small>
            </div>
            <h5 class="course-title"><a href="{{ route('ui.details', $p->id_p) }}">{{ $p->name_p }}</a></h5>
          </div>
          <div class="course-meta d-flex border-top">
            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>John Doe</small>
            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>1.49 Hrs</small>
            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30 Students</small>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
<!-- Courses End -->

<style>
  .container {
    max-width: 1200px;
    margin: auto;
  }

  /* Bố cục sản phẩm */
  .course-item {
    position: relative;
    overflow: hidden;
    background: #fff;
    border-radius: 12px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    max-width: 350px;
    margin: auto;
  }

  /* Hiệu ứng khi hover */
  .course-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
  }

  /* Hình ảnh sản phẩm */
  .course-image {
    position: relative;
    overflow: hidden;
    border-radius: 12px 12px 0 0;
  }

  .course-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
    transition: transform 0.3s ease-in-out;
  }

  .course-item:hover .course-image img {
    transform: scale(1.05);
    filter: brightness(0.7); /* Làm tối ảnh khi hover để nổi bật nút */
  }

  /* Nút hiển thị trên hình ảnh */
  .course-buttons {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    justify-content: center;
    gap: 12px;
    width: 80%; /* Giữ nút gọn gàng trong khung */
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
  }

  .course-item:hover .course-buttons {
    opacity: 1;
    visibility: visible;
  }

  /* Nút bấm */
  .course-buttons .btn {
    flex: 1;
    text-align: center;
    border-radius: 20px;
    padding: 8px 0;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease-in-out;
    white-space: nowrap;
  }

  .course-buttons .btn-primary {
    background-color: #007bff;
    border: none;
    color: white;
  }

  .course-buttons .btn-outline-primary {
    border: 2px solid #fff;
    color: #fff;
    background: rgba(255, 255, 255, 0.2);
  }

  .course-buttons .btn:hover {
    transform: scale(1.1);
    background-color: #0056b3;
    border-color: #fff;
  }

  /* Nội dung khóa học */
  .course-content {
    text-align: center;
    padding: 16px;
  }

  /* Giá tiền */
  .course-content .price {
    font-size: 18px;
    font-weight: bold;
    color: #e74c3c;
  }

  /* Tiêu đề khóa học */
  .course-title a {
    color: #333;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: color 0.3s ease-in-out;
  }

  .course-title a:hover {
    color: #007bff;
  }

  /* Meta thông tin */
  .course-meta {
    display: flex;
    justify-content: space-between;
    background: #f9f9f9;
    padding: 10px;
    border-top: 1px solid #ddd;
    font-size: 13px;
    color: #555;
  }

  .course-meta small {
    flex: 1;
    text-align: center;
  }

  .course-meta i {
    color: #007bff;
  }
</style>
