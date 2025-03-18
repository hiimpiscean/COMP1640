@extends('masters.uiMaster')

@section('main')
  <div class="container">
    <div class="edit-blog-container">
      <h1 class="text-center">Sửa Blog</h1>
      <form action="{{ route('blog.update', ['id' => $blog->id_b]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_b" value="{{ $blog->id_b }}">
        <input type="hidden" name="current_image" value="{{ $blog->image_b }}">

        <div class="form-group">
          <label for="title_b">Tiêu đề</label>
          <input type="text" name="title_b" id="title_b" class="form-control" value="{{ old('title_b', $blog->title_b) }}">
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
          @if($blog->image_b)
            <div class="mb-2">
              <img src="{{ asset('uploads/' . $blog->image_b) }}" alt="Ảnh hiện tại" class="preview-img">
            </div>
          @endif
          <input type="file" name="image_b" id="image_b" class="form-control">
          @error('image_b')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('blog.index') }}" class="btn btn-secondary">Quay lại</a>
      </form>
    </div>
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
    background: #f8f9fa;
  }

  /* ======= Container chính ======= */
  .edit-blog-container {
    max-width: 700px;
    margin: 50px auto;
    padding: 35px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    margin-top: 100px;
  }

  .edit-blog-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  }

  /* ======= Tiêu đề ======= */
  .edit-blog-container h1 {
    margin-bottom: 25px;
    color: #007bff;
    font-weight: 700;
    text-align: center;
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
  .preview-img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    display: block;
    margin: 15px auto;
    transition: transform 0.3s ease-in-out;
  }

  .preview-img:hover {
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

  /* ======= Nút Cập Nhật ======= */
  .btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    color: #fff;
    margin: 10px auto;
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
    .edit-blog-container {
      max-width: 90%;
      padding: 25px;
    }

    .btn {
      width: 100%;
      margin-top: 10px;
    }
  }
</style>
