@extends('masters.uiMaster')

@section('main')
  <div class="container-blog">
    <p><strong>Tác giả:</strong> {{ $blog->author_b }}</p>
    <header class="blog-header">
      <h1 class="blog-title">{{ $blog->title_b }}</h1>
    </header>

    @if($blog->image_b)
      <figure class="blog-image">
        <img src="{{ asset('uploads/' . $blog->image_b) }}" alt="{{ $blog->title_b }}">
      </figure>
    @endif

    <article class="blog-content">
      {!! $blog->content_b !!}
    </article>

    <footer class="blog-meta">
      <p><strong>Ngày tạo:</strong> {{ $blog->created_at }}</p>
    </footer>

    <a href="{{ route('blog.index') }}" class="btn-back">Quay lại danh sách</a>
  </div>
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({ duration: 800, easing: 'ease-in-out', once: true });
  </script>
@endsection

<style>
  .container-blog {
    max-width: 800px;
    margin: 100px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .blog-header {
    text-align: center;
    margin-bottom: 20px;
  }

  .blog-title {
    font-size: 2rem;
    color: #007bff;
    text-align: left; /* Đưa tiêu đề về bên trái */
  }

  .blog-image {
    max-width: 100%;
    margin-bottom: 20px;
  }

  .blog-image img {
    width: 100%; /* Đảm bảo ảnh rộng bằng phần tử cha */
    display: block;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .blog-content {
    font-size: 1.1rem;
    color: #333;
    line-height: 1.6;
    text-align: justify;
    max-width: 100%;
  }

  .blog-meta {
    margin-top: 20px;
    font-style: italic;
    color: #555;
    text-align: left; /* Canh lề trái luôn thẳng hàng */
  }

  .btn-back {
    display: inline-block;
    padding: 10px 20px;
    background: #007bff;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s;
  }

  .btn-back:hover {
    background: #0056b3;
    color: #fff;
    text-decoration: none;
  }
</style>
