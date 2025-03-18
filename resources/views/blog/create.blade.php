@extends('masters.uiMaster')

@section('main')
  <div class="container-blog">
    <h1>Tạo Blog mới</h1>
    <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-group mb-3">
        <label for="title_b">Tiêu đề</label>
        <input type="text" name="title_b" id="title_b" class="form-control" value="{{ old('title_b', $blog->title_b) }}">
        @error('title_b')
        <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group mb-3">
        <label for="content_b">Nội dung</label>
        <textarea name="content_b" id="content_b" class="form-control" rows="5">{{ old('content_b', $blog->content_b) }}</textarea>
        @error('content_b')
        <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group mb-3">
        <label for="image_b">Hình ảnh</label>
        <input type="file" name="image_b" id="image_b" class="form-control">
        @error('image_b')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        @if(isset($blog->image_b) && $blog->image_b)
          <img src="{{ asset('uploads/' . $blog->image_b) }}" alt="Hình ảnh hiện tại" class="img-thumbnail mt-2" style="max-width: 200px;">
        @endif
      </div>
      <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
    <a href="{{ route('blog.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
  </div>
@endsection

@section('script')
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
  /* ======= Thiết lập tổng thể ======= */
  body {
    font-family: 'Poppins', sans-serif;
    background: #f4f6f9;
  }

  /* ======= Container chính ======= */
  .container-blog {
    max-width: 700px;
    margin: 50px auto;
    padding: 35px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    margin-top: 100px;
  }

  .container:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  }

  /* ======= Tiêu đề ======= */
  .container h1 {
    text-align: center;
    color: #007bff;
    font-weight: 700;
    margin-bottom: 20px;
  }

  /* ======= Form Group ======= */
  .form-group {
    margin-bottom: 20px;
  }

  label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: block;
  }

  /* ======= Input và Textarea ======= */
  .form-control {
    border-radius: 10px;
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #ced4da;
    transition: border-color 0.3s, box-shadow 0.3s;
  }

  .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
  }

  /* ======= Ảnh Preview ======= */
  .img-thumbnail {
    display: block;
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-top: 15px;
    transition: transform 0.3s ease-in-out;
  }

  .img-thumbnail:hover {
    transform: scale(1.05);
  }

  /* ======= Nút bấm ======= */
  .btn {
    padding: 12px;
    border-radius: 8px;
    font-weight: 700;
    text-transform: uppercase;
    width: 100%;
    transition: all 0.3s ease-in-out;
  }

  /* ======= Nút Lưu ======= */
  .btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    color: #fff;
  }

  .btn-primary:hover {
    background: linear-gradient(45deg, #0056b3, #003d82);
    transform: scale(1.02);
  }

  /* ======= Nút Quay Lại ======= */
  .btn-secondary {
    background: linear-gradient(45deg, #6c757d, #5a6268);
    border: none;
    color: #fff;
  }

  .btn-secondary:hover {
    background: linear-gradient(45deg, #5a6268, #3e4347);
    transform: scale(1.02);
  }

  /* ======= Responsive ======= */
  @media (max-width: 768px) {
    .container {
      max-width: 90%;
      padding: 25px;
    }

    .btn {
      width: 100%;
      margin-top: 10px;
    }
  }
</style>
