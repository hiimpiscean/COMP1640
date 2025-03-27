@extends('masters.uiMaster')

@section('main')
  <style>
    .container {
      max-width: 1000px;
      margin: auto;
      padding: 30px;
      animation: fadeInUp 0.8s ease-in-out;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .heading_container h1 {
      font-size: 40px;
      font-weight: bold;
      color: #333;
      text-align: center;
      margin-bottom: 30px;
      position: relative;
      animation: fadeIn 1s ease-in-out;
    }

    .heading_container h1::after {
      content: "";
      display: block;
      width: 120px;
      height: 4px;
      background-color: #007bff;
      margin: 12px auto 0;
      border-radius: 2px;
    }

    .course-wrapper {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
      gap: 50px;
    }

    .course-image img {
      max-width: 380px;
      border-radius: 15px;
      box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease-in-out;
    }

    .course-image img:hover {
      transform: scale(1.05);
    }

    .course-info {
      max-width: 500px;
    }

    .course-info h3 {
      font-size: 22px;
      font-weight: bold;
      color: #222;
      margin-bottom: 10px;
    }

    .course-info p {
      font-size: 16px;
      line-height: 1.6;
      color: #555;
      margin-bottom: 15px;
    }

    .price {
      font-size: 26px;
      color: #e74c3c;
      font-weight: bold;
    }

    .btn-register {
      display: inline-block;
      font-size: 18px;
      font-weight: 700;
      padding: 14px 32px;
      border-radius: 8px;
      background: linear-gradient(135deg, #28a745, #218838);
      color: #fff;
      text-decoration: none;
      transition: 0.3s ease-in-out;
      box-shadow: 0px 5px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-register:hover {
      background: linear-gradient(135deg, #218838, #1e7e34);
      transform: scale(1.05);
      box-shadow: 0px 8px 20px rgba(33, 136, 56, 0.4);
      text-decoration: none;
      color: #fff;
    }

    @media (max-width: 768px) {
      .course-wrapper {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 30px;
      }
      .course-image img {
        max-width: 100%;
      }
      .course-info {
        max-width: 100%;
      }
    }
  </style>

  <div class="container">
    <div class="heading_container">
      <h1>Course Details</h1>
    </div>

    <div class="course-wrapper">
      <div class="course-image">
        @if (!empty($product->image_p))
          <img src="{{ asset('images/handicraf/' . $product->image_p) }}" alt="Product Image">
        @else
          <img src="{{ asset('images/default-placeholder.png') }}" alt="No Image Available">
        @endif
      </div>

      <div class="course-info">
        <h3>Course Name</h3>
        <p>{{ $product->name_p ?? 'N/A' }}</p>

        <h3>About This Course</h3>
        <p>{{ $product->description_p ?? 'N/A' }}</p>

        <h3>Price</h3>
        <p class="price">{{ isset($product->price_p) ? number_format($product->price_p, 0, ',', '.') : 'N/A' }} VND</p>

        <a href="{{ url('shoppingbasket') }}" class="btn-register">Register Now</a>
      </div>
    </div>
  </div>
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
