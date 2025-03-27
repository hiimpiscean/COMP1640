@extends('masters.uiMaster')

@section('main')
  <div class="blog-container">
    <h1 class="blog-heading">Tạo Blog mới</h1>

    <!-- Thông báo nếu có -->
    @if(session('msg'))
      <div class="alert alert-success" data-aos="fade-down">{{ session('msg') }}</div>
    @endif

    <!-- Form tạo blog -->
    <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="title_b">Tiêu đề</label>
        <input type="text" name="title_b" id="title_b" class="form-control"
               value="{{ old('title_b', $blog->title_b) }}">
        @error('title_b')
        <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="content_b">Nội dung</label>
        <textarea name="content_b" id="content_b" class="form-control" rows="5">{{ old('content_b', $blog->content_b) }}</textarea>
        @error('content_b')
        <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="image_b">Hình ảnh</label>
        <input type="file" name="image_b" id="image_b" class="form-control-i">
        @error('image_b')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        @if(isset($blog->image_b) && $blog->image_b)
          <img src="{{ asset('uploads/' . $blog->image_b) }}"
               alt="Hình ảnh hiện tại"
               class="img-thumbnail mt-2">
        @endif
      </div>

      <button type="submit" class="btn btn-primary" title="Luu">
        <i class="fa fa-save"></i>
      </button>
    </form>

    <!-- Nút quay lại -->
    <a href="{{ route('blog.index') }}" class="btn btn-secondary mt-3" title="Quay lại">
      <i class="fa fa-arrow-left"></i>
    </a>
  </div>
@endsection

@section('script')
  <!-- AOS nếu cần -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true,
    });
  </script>
@endsection

<style>
  body {
    background: #121212;
    color: #e0e0e0;
    font-family: 'Poppins', sans-serif;
  }

  .blog-container {
    max-width: 1500px;
    margin: 100px auto 50px;
    padding: 30px;
    background: #1e1e1e;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.5);
  }

  .blog-heading {
    font-size: 2.0rem;
    text-align: center;
    margin-bottom: 30px;
    color: #fff;
  }

  /* ======== Form Group ======== */
  .form-group {
    margin-bottom: 20px;
  }

  label {
    font-weight: 600;
    color: #ccc;
    margin-bottom: 8px;
    display: block;
  }

  /* ======== Input, Textarea ======== */
  .form-control-i {
    background: #2a2a2a;
    color: #fff;
    border: 1px solid #444;
    border-radius: 6px;
    padding: 10px;
    width: 100%;
    transition: border-color 0.3s, box-shadow 0.3s;
  }
  .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 6px rgba(0, 123, 255, 0.4);
    outline: none;
  }

  /* ======== Ảnh Preview ======== */
  .img-thumbnail {
    display: block;
    max-width: 200px;
    height: auto;
    border-radius: 6px;
    margin-top: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.4);
  }

  /* ======== Nút bấm (giống index) ======== */
  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    font-size: 1.2rem;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.3s;
    margin-right: 5px; /* Tạo khoảng cách giữa các nút */
  }

  .btn i {
    margin: 0; /* Vì chỉ có icon, không cần margin */
  }

  .btn:hover {
    opacity: 0.85;
  }

  /* Nút Primary */
  .btn-primary {
    background-color: #007bff;
    color: #fff;
  }
  .btn-primary:hover {
    background-color: #0069d9;
  }

  /* Nút Secondary */
  .btn-secondary {
    background-color: #6c757d;
    color: #fff;
  }
  .btn-secondary:hover {
    background-color: #5a6268;
  }

  /* ======== Responsive ======== */
  @media (max-width: 768px) {
    .blog-container {
      margin: 60px auto;
      padding: 20px;
    }
  }
</style>
