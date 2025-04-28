@extends('masters.uiMaster')

@section('main')
  <div class="container edit-blog">
    <h1 class="heading">Sửa Blog</h1>
    <form action="{{ route('blog.update', ['id' => $blog->id_b]) }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_b" value="{{ $blog->id_b }}">
    <input type="hidden" name="current_image" value="{{ $blog->image_b }}">

    <div class="form-group">
      <label for="title_b">Tiêu đề</label>
      <input type="text" name="title_b" id="title_b" class="form-control" value="{{ old('title_b', $blog->title_b) }}">
      @error('title_b')
      <div class="error">{{ $message }}</div>
    @enderror
    </div>

    <div class="form-group">
      <label for="content_b">Nội dung</label>
      <textarea name="content_b" id="content_b" class="form-control"
      rows="5">{{ old('content_b', $blog->content_b) }}</textarea>
      @error('content_b')
      <div class="error">{{ $message }}</div>
    @enderror
    </div>

    <div class="form-group file-group">
      <label for="image_b">Hình ảnh</label>
      @if($blog->image_b)
      <div class="image-preview">
      <img src="{{ asset('uploads/' . $blog->image_b) }}" alt="Ảnh hiện tại" class="preview-img">
      </div>
    @endif
      <input type="file" name="image_b" id="image_b" class="form-control-file">
      @error('image_b')
      <div class="error">{{ $message }}</div>
    @enderror
    </div>

    <div class="button-group">
      <button type="submit" class="btn btn-primary" title="Cập nhật">
      <i class="fa fa-save"></i> Cập nhật
      </button>
      <a href="{{ route('blog.index') }}" class="btn btn-secondary" title="Quay lại">
      <i class="fa fa-arrow-left"></i> Quay lại
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
  /* Reset cơ bản & font chữ */
  body {
    background: #fafafa;
    color: #333;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  /* Container cho form Sửa Blog */
  .container.edit-blog {
    max-width: 700px;
    margin: 20px auto;
    padding: 30px;
    background: #fff;
    border: 1px solid #dbdbdb;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-top: 100px
  }

  /* Tiêu đề trang */
  .heading {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 30px;
    color: #262626;
  }

  /* Form group & label */
  .form-group {
    margin-bottom: 20px;
  }

  label {
    font-weight: 600;
    display: block;
    margin-bottom: 8px;
    color: #555;
  }

  /* Input & Textarea */
  .form-control,
  .form-control-file {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: border-color 0.3s;
  }

  .form-control:focus,
  .form-control-file:focus {
    border-color: #007bff;
    outline: none;
  }

  /* Hiển thị lỗi */
  .error {
    color: #d9534f;
    margin-top: 5px;
    font-size: 0.875rem;
  }

  /* Ảnh Preview */
  .image-preview {
    margin-bottom: 10px;
  }

  .preview-img {
    max-width: 300px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s;
  }

  .preview-img:hover {
    transform: scale(1.05);
  }

  /* Nhóm nút hành động */
  .button-group {
    display: flex;
    gap: 10px;
    margin-top: 20px;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 15px;
    font-size: 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.3s;
  }

  .btn i {
    margin-right: 5px;
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

  /* Responsive */
  @media (max-width: 768px) {
    .container.edit-blog {
      margin: 40px auto;
      padding: 20px;
    }
  }
</style>