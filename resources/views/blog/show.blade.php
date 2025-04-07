@extends('masters.uiMaster')

@section('main')
  <div class="blog-detail-container" data-aos="fade-up">
    <header class="blog-header">
    <h1 class="blog-title">{{ $blog->title_b }}</h1>
    <p class="blog-author"><strong>Tác giả:</strong> {{ $blog->author_b }}</p>
    </header>

    @if($blog->image_b)
    <figure class="blog-image">
    <img src="{{ asset('uploads/' . $blog->image_b) }}" alt="{{ $blog->title_b }}">
    </figure>
  @endif

    <article class="blog-content">
    {!! $blog->content_b !!}
    </article>

    <footer class="blog-footer">
    <p class="blog-date"><strong>Ngày tạo:</strong> {{ $blog->created_at }}</p>
    </footer>

    <a href="{{ route('blog.index') }}" class="btn-back" title="Quay lại danh sách">Quay lại danh sách</a>
  </div>
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true
    });
  </script>
@endsection

<style>
  /* Nền chung cho trang */
  body {
    background: #f5f5f5;
    color: #333;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  /* Container chính cho chi tiết Blog */
  .blog-detail-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 30px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    line-height: 1.6;
    margin-top: 100px;
  }

  /* Header - tiêu đề và tác giả */
  .blog-header {
    border-bottom: 1px solid #eaeaea;
    margin-bottom: 20px;
    padding-bottom: 10px;
    text-align: left;
  }

  .blog-title {
    font-size: 2.2rem;
    margin: 0;
    color: #222;
  }

  .blog-author {
    font-size: 0.95rem;
    margin-top: 5px;
    color: #666;
  }

  /* Ảnh chính của blog */
  .blog-image {
    margin: 20px 0;
    text-align: center;
  }

  .blog-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  /* Nội dung Blog */
  .blog-content {
    font-size: 1.1rem;
    color: #444;
    text-align: justify;
  }

  /* Footer - thông tin ngày tạo */
  .blog-footer {
    border-top: 1px solid #eaeaea;
    margin-top: 20px;
    padding-top: 10px;
    text-align: left;
    font-size: 0.9rem;
    color: #777;
  }

  /* Nút quay lại danh sách */
  .btn-back {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s;
  }

  .btn-back:hover {
    background: #0056b3;
  }
</style>