@extends('masters.uiMaster')

@section('main')
  <div class="container create-blog">
    <h1 class="heading">Tạo Blog mới</h1>

    <!-- Thông báo nếu có -->
    @if(session('msg'))
    <div class="alert" data-aos="fade-down">{{ session('msg') }}</div>
  @endif

    <!-- Form tạo blog -->
    <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
    @csrf
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
      <input type="file" name="image_b" id="image_b" class="form-control-file">
      @error('image_b')
      <div class="error">{{ $message }}</div>
    @enderror

      @if(isset($blog->image_b) && $blog->image_b)
      <img src="{{ asset('uploads/' . $blog->image_b) }}" alt="Hình ảnh hiện tại" class="img-thumbnail">
    @endif
    </div>

    <div class="button-group">
      <button type="submit" class="btn btn-primary" title="Lưu">
      <i class="fa fa-save"></i> Lưu
      </button>
      <a href="{{ route('blog.index') }}" class="btn btn-secondary" title="Quay lại">
      <i class="fa fa-arrow-left"></i> Quay lại
      </a>
    </div>
    </form>
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
  /* Reset & cơ bản */
  body {
    background: #fafafa;
    color: #333;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  /* Khung chứa form */
  .container.create-blog {
    max-width: 700px;
    margin: 20px auto;
    padding: 30px;
    background: #fff;
    border: 1px solid #dbdbdb;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-top: 100px;
  }

  /* Tiêu đề trang */
  .heading {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 30px;
    color: #262626;
  }

  /* Thông báo */
  .alert {
    margin-bottom: 20px;
    padding: 10px;
    background: #dff0d8;
    border: 1px solid #d0e9c6;
    border-radius: 4px;
    text-align: center;
    color: #3c763d;
  }

  /* Form Group */
  .form-group {
    margin-bottom: 20px;
  }

  label {
    font-weight: 600;
    display: block;
    margin-bottom: 5px;
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
  .img-thumbnail {
    max-width: 200px;
    margin-top: 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
  }

  /* Nút hành động */
  .button-group {
    display: flex;
    gap: 10px;
    align-items: center;
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
    transition: background 0.3s, transform 0.3s;
  }

  .btn i {
    margin-right: 5px;
  }

  .btn-primary {
    background-color: #007bff;
    color: #fff;
  }

  .btn-primary:hover {
    background-color: #0069d9;
  }

  .btn-secondary {
    background-color: #6c757d;
    color: #fff;
  }

  .btn-secondary:hover {
    background-color: #5a6268;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .container.create-blog {
      margin: 40px auto;
      padding: 20px;
    }
  }
</style>