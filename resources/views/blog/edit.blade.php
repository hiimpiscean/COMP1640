@extends('masters.uiMaster')

@section('main')
  <div class="blog-container">
    <h1 class="blog-heading">Sửa Blog</h1>
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
        <input type="file" name="image_b" id="image_b" class="form-control-i">
        @error('image_b')
        <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="button-group">
        <button type="submit" class="btn btn-primary" title="Cập nhật">
          <i class="fa fa-save"></i>
        </button>
        <a href="{{ route('blog.index') }}" class="btn btn-secondary" title="Quay lại">
          <i class="fa fa-arrow-left"></i>
        </a>
      </div>
    </form>
  </div>
@endsection

@section('script')
  <!-- Bao gồm thư viện AOS nếu cần -->
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

  /* ======= Tiêu đề ======= */
  .blog-heading {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 30px;
    color: #fff;
  }

  /* ======= Form Group ======= */
  .form-group {
    margin-bottom: 20px;
  }

  label {
    font-weight: 600;
    color: #ccc;
    margin-bottom: 8px;
    display: block;
  }

  /* ======= Input và Textarea ======= */
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
    box-shadow: 0 0 6px rgba(0,123,255,0.4);
    outline: none;
  }

  /* ======= Ảnh Preview ======= */
  .preview-img {
    max-width: 200px;
    display: block;
    margin: 10px auto;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.4);
    transition: transform 0.3s;
  }
  .preview-img:hover {
    transform: scale(1.05);
  }

  /* ======= Nút bấm ======= */
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
    margin-right: 10px;
  }
  .btn i {
    margin: 0;
  }
  .btn:hover {
    opacity: 0.85;
  }

  /* ======= Nút Primary ======= */
  .btn-primary {
    background-color: #007bff;
    color: #fff;
  }
  .btn-primary:hover {
    background-color: #0069d9;
  }

  /* ======= Nút Secondary ======= */
  .btn-secondary {
    background-color: #6c757d;
    color: #fff;
  }
  .btn-secondary:hover {
    background-color: #5a6268;
  }

  /* ======= Nhóm nút ======= */
  .button-group {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 20px;
  }

  /* ======= Responsive ======= */
  @media (max-width: 768px) {
    .blog-container {
      margin: 60px auto;
      padding: 20px;
    }
  }
</style>
