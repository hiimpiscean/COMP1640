@extends('masters.uiMaster')
@section('main')

  <style>
    .container-flm {
      max-width: 1500px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 100px;
      margin-bottom: 20px;
    }
    h2 {
      text-align: center;
    }
    .document {
      display: flex;
      justify-content: space-between;
      background: #e8e8e8;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
    }
    .download-btn {
      background: #28a745;
      color: white;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      border-radius: 5px;
    }
    .download-btn:hover {
      background: #218838;
    }
  </style>

  <div class="container-flm">
    <h2>Danh Sách Tài Liệu Học Tập</h2>
    <div class="document">
      <span>Bài giảng 1: Giới thiệu về HTML</span>
      <a href="documents/html_intro.pdf" download><button class="download-btn">Tải xuống</button></a>
    </div>
    <div class="document">
      <span>Bài giảng 2: CSS Cơ Bản</span>
      <a href="documents/css_basics.pdf" download><button class="download-btn">Tải xuống</button></a>
    </div>
    <div class="document">
      <span>Bài giảng 3: JavaScript Nâng Cao</span>
      <a href="documents/js_advanced.pdf" download><button class="download-btn">Tải xuống</button></a>
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
