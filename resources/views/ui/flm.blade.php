@extends('masters.uiMaster')
@section('main')

  <style>
    .container-flm {
      width: 100%;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      margin-top: 100px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 24px;
      color: #333;
    }

    .course {
      margin-bottom: 20px;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h3 {
      margin-bottom: 10px;
      font-size: 20px;
      color: #333;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 10px;
    }

    .progress {
      height: 20px;
      background-color: #ddd;
      border-radius: 10px;
      overflow: hidden;
      position: relative;
    }

    .progress-bar {
      height: 100%;
      text-align: center;
      line-height: 20px;
      color: white;
      font-weight: bold;
      background: linear-gradient(135deg, #4caf50, #2e7d32);
      transition: width 0.5s ease-in-out;
    }

    @media (max-width: 768px) {
      .container-flm {
        padding: 20px;
      }

      .course {
        padding: 15px;
      }
    }
  </style>

  <div class="container-flm">
    <h2>Khóa Học Của Tôi</h2>

    <div class="course">
      <h3>HTML & CSS Cơ Bản</h3>
      <p>Tiến trình: 75%</p>
      <div class="progress">
        <div class="progress-bar" style="width: 75%;">75%</div>
      </div>
    </div>

    <div class="course">
      <h3>JavaScript Nâng Cao</h3>
      <p>Tiến trình: 50%</p>
      <div class="progress">
        <div class="progress-bar" style="width: 50%;">50%</div>
      </div>
    </div>

    <div class="course">
      <h3>Lập Trình Web Với React</h3>
      <p>Tiến trình: 30%</p>
      <div class="progress">
        <div class="progress-bar" style="width: 30%;">30%</div>
      </div>
    </div>

    <div class="course">
      <h3>Lập Trình Web Với React</h3>
      <p>Tiến trình: 30%</p>
      <div class="progress">
        <div class="progress-bar" style="width: 30%;">30%</div>
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
