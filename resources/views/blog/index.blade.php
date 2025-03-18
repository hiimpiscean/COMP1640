@extends('masters.uiMaster')

@section('main')
  <div class="container-blog">
    <h1 class="title">Danh sách Blog</h1>

    @if(session('msg'))
      <div class="alert alert-success" data-aos="fade-down">{{ session('msg') }}</div>
    @endif

    <a href="{{ route('blog.create') }}" class="btn-add-blog" id="btn-add-blog">+</a>

    <div class="blog-list">
      @foreach($blog as $item)
        <div class="blog-item" data-aos="fade-up">
          <p class="blog-author"><strong>Tác giả:</strong> {{ $item->author_b }}</p>
          <h2 class="blog-title">{{ $item->title_b }}</h2>

          @if($item->image_b)
            <div class="blog-image">
              <img src="{{ asset('uploads/' . $item->image_b) }}" alt="{{ $item->title_b }}">
            </div>
          @endif

          <p class="blog-content">
            {{ \Illuminate\Support\Str::limit($item->content_b, 150) }}
          </p>

          <div class="blog-actions">
            <a href="{{ route('blog.show', ['id' => $item->id_b]) }}" class="btn btn-info">Xem chi tiết</a>
            @if(Session::has('username'))
            <a href="{{ route('blog.edit', ['id' => $item->id_b]) }}" class="btn btn-warning">Sửa</a>
            <form action="{{ route('blog.destroy', ['id' => $item->id_b]) }}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa Blog này không?');">
              @csrf
              <input type="hidden" name="id_b" value="{{ $item->id_b }}">
              <button type="submit" class="btn btn-danger">Xóa Blog</button>
            </form>
            @endif
          </div>

          <!-- Phần bình luận -->
          <div class="comment-section">
            <p class="comment-count">
              Có {{ isset($item->comment) ? count($item->comment) : 0 }} bình luận
            </p>

            {{-- Nếu người dùng đã đăng nhập thì hiển thị form thêm bình luận --}}
            @if(Session::has('username'))
              <form action="{{ route('blog.comment.store', ['id' => $item->id_b]) }}" method="post" class="comment-form">
                @csrf
                <div class="form-group">
                  <textarea name="content_cmt" rows="2" class="form-control" placeholder="Bình luận của bạn"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-comment">Gửi bình luận</button>
              </form>
            @endif

            {{-- Danh sách bình luận --}}
            @if(isset($item->comment) && count($item->comment) > 0)
              <div class="comment-list">
                @foreach($item->comment as $comment)
                  <div class="comment">
                    <p>{{ $comment->content_cmt }}</p>
                    <p><small>{{ $comment->created_at }}</small></p>
                    {{-- Cho phép xóa bình luận nếu cần, bạn có thể thêm điều kiện kiểm tra quyền --}}
                    @if(Session::has('username'))
                      <form action="{{ route('blog.comment.destroy', ['id' => $item->id_b, 'commentId' => $comment->id_cmt]) }}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này không?');">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-comment">Xóa bình luận</button>
                      </form>
                    @endif
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      @endforeach
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
  .container-blog {
    max-width: 1000px;
    margin: 100px auto 40px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    background: #fff;
  }

  .title {
    font-size: 2rem;
    margin-bottom: 20px;
    color: #007bff;
    text-align: center;
  }

  .btn-add-blog {
    position: fixed;
    top: 100px;
    right: 20px;
    width: 50px;
    height: 50px;
    background: #007bff;
    color: #fff;
    font-size: 24px;
    text-align: center;
    line-height: 50px;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    transition: background 0.3s, transform 0.3s;
  }

  .btn-add-blog:hover {
    background: #0056b3;
    transform: scale(1.1);
    color: #fff;
    text-decoration: none;
  }

  .blog-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 20px;
  }

  .blog-item {
    width: 100%;
    background: #ffffff;
    border-radius: 10px;
    padding: 20px;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
  }

  .blog-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  }

  .blog-author {
    font-style: italic;
    color: #444;
    margin-bottom: 10px;
  }

  .blog-title {
    font-size: 1.5rem;
    color: #0056b3;
    margin-bottom: 10px;
  }

  .blog-image img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
  }

  .blog-content {
    font-size: 1rem;
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
  }

  .blog-actions {
    margin-top: 15px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }

  .btn {
    border-radius: 5px;
    transition: 0.3s;
  }

  .btn:hover {
    opacity: 0.85;
  }

  .comment-section {
    margin-top: 20px;
    border-top: 1px solid #ddd;
    padding-top: 10px;
  }

  .comment-count {
    font-weight: bold;
    margin-bottom: 10px;
  }

  .comment-form .form-group {
    margin-bottom: 10px;
  }

  .btn-comment {
    padding: 5px 10px;
  }

  .comment-list {
    margin-top: 10px;
  }

  .comment {
    background: #f8f8f8;
    border: 1px solid #eee;
    padding: 8px;
    border-radius: 5px;
    margin-bottom: 8px;
  }

  .comment p {
    margin: 0;
  }

  .comment small {
    color: #888;
  }
</style>
