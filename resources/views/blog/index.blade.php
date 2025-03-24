@extends('masters.uiMaster')

@section('main')
  <div class="blog-container">
    <h1 class="blog-heading">Recent Posts</h1>

    @if(session('msg'))
      <div class="alert alert-success" data-aos="fade-down">{{ session('msg') }}</div>
    @endif

    <!-- Nút thêm blog dạng floating (icon + dark theme) -->
    <a href="{{ route('blog.create') }}" class="btn-add-blog" id="btn-add-blog" title="Thêm Blog">
      <i class="fa fa-plus"></i>
    </a>

    <!-- Vùng danh sách bài viết -->
    <div class="blog-list">
      @foreach($blog as $item)
        <div class="blog-item" data-aos="fade-up">

          <!-- Nếu có ảnh thì hiển thị -->
          @if($item->image_b)
            <div class="blog-image">
              <img src="{{ asset('uploads/' . $item->image_b) }}" alt="{{ $item->title_b }}">
            </div>
          @endif

          <!-- Nội dung bài viết -->
          <div class="blog-content-wrapper">
            <p class="blog-meta">
              <span class="blog-date">{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</span>
              –
              <span class="blog-author">By {{ $item->author_b }}</span>
            </p>

            <h2 class="blog-title">{{ $item->title_b }}</h2>

            <p class="blog-excerpt">
              {{ \Illuminate\Support\Str::limit($item->content_b, 150) }}
            </p>

            <!-- Khu vực các nút hành động (chỉ hiển thị icon) -->
            <div class="blog-actions">
              <a href="{{ route('blog.show', ['id' => $item->id_b]) }}" class="btn btn-info" title="Xem chi tiết">
                <i class="fa fa-eye"></i>
              </a>
              @if(Session::has('username'))
                <a href="{{ route('blog.edit', ['id' => $item->id_b]) }}" class="btn btn-warning" title="Sửa">
                  <i class="fa fa-edit"></i>
                </a>
                <form action="{{ route('blog.destroy', ['id' => $item->id_b]) }}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa Blog này không?');" style="display:inline-block;">
                  @csrf
                  <input type="hidden" name="id_b" value="{{ $item->id_b }}">
                  <button type="submit" class="btn btn-danger" title="Xóa Blog">
                    <i class="fa fa-trash"></i>
                  </button>
                </form>
              @endif
            </div>

            <!-- Khu vực bình luận -->
            <div class="comment-section">
              <p class="comment-count">
                Có {{ isset($item->comment) ? count($item->comment) : 0 }} bình luận
              </p>

              @if(Session::has('username'))
                <form action="{{ route('blog.comment.store', ['id' => $item->id_b]) }}" method="post" class="comment-form">
                  @csrf
                  <div class="form-group">
                    <textarea name="content_cmt" rows="2" class="form-control" placeholder="Bình luận của bạn"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary btn-comment" title="Gửi bình luận">
                    <i class="fa fa-paper-plane"></i>
                  </button>
                </form>
              @endif

              @if(isset($item->comment) && count($item->comment) > 0)
                <div class="comment-list">
                  @foreach($item->comment as $comment)
                    <div class="comment">
                      <!-- Nội dung bình luận -->
                      <div>
                        <p>{{ $comment->content_cmt }}</p>
                        <p>
                          <small>
                            {{ $comment->created_at }} - <strong>{{ $comment->author_cmt }}</strong>
                          </small>
                        </p>
                      </div>

                      <!-- Nút xóa bình luận (nếu đúng người đăng nhập) -->
                      @if(Session::has('username') && Session::get('username') === $comment->author_cmt)
                        <form action="{{ route('blog.comment.destroy', ['id' => $item->id_b, 'commentId' => $comment->id_cmt]) }}"
                              method="post"
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này không?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-comment" title="Xóa bình luận">
                            <i class="fa fa-trash"></i>
                          </button>
                        </form>
                      @endif
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
            <!-- Kết thúc khu vực bình luận -->

          </div><!-- /blog-content-wrapper -->
        </div><!-- /blog-item -->
      @endforeach
    </div><!-- /blog-list -->
  </div>
@endsection

@section('script')
  <!-- Bao gồm thư viện AOS -->
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
  }

  /* Vùng chứa tổng thể */
  .blog-container {
    max-width: 1500px;
    margin: 80px auto;
    padding: 20px;
    background: #1e1e1e;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.5);
  }

  /* Tiêu đề lớn */
  .blog-heading {
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 40px;
    color: #fff;
  }

  /* Nút thêm blog dạng floating */
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
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    text-decoration: none;
    transition: background 0.3s, transform 0.3s;
    z-index: 99;
  }
  .btn-add-blog:hover {
    background: #0056b3;
    transform: scale(1.1);
    color: #fff;
  }

  /* Danh sách blog (cột dọc) */
  .blog-list {
    display: flex;
    flex-direction: column;
    gap: 40px;
  }

  /* Mỗi bài blog */
  .blog-item {
    display: flex;
    flex-direction: column; /* Cho mobile */
    gap: 20px;
    border-bottom: 1px solid #444;
    padding-bottom: 30px;
  }

  /* Ảnh blog */
  .blog-image img {
    width: 100%;
    height: auto;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  /* Khối nội dung bên cạnh ảnh */
  .blog-content-wrapper {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  /* Meta (ngày và tác giả) */
  .blog-meta {
    font-size: 0.9rem;
    color: #aaa;
    margin: 0;
  }
  .blog-meta span {
    display: inline-block;
  }

  /* Tiêu đề bài viết */
  .blog-title {
    font-size: 1.6rem;
    color: #fff;
    margin: 0;
    line-height: 1.2;
  }

  /* Tóm tắt */
  .blog-excerpt {
    font-size: 1rem;
    color: #ccc;
    line-height: 1.6;
    margin: 0;
  }

  /* Khu vực các nút hành động */
  .blog-actions {
    margin-top: 10px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
    font-size: 1.2rem;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.3s;
  }
  .btn:hover {
    opacity: 0.85;
  }

  /* Nút thông tin (Xem chi tiết) */
  .btn-info {
    background-color: #17a2b8;
    color: #fff;
  }
  .btn-info:hover {
    background-color: #138496;
  }

  /* Nút cảnh báo (Sửa) */
  .btn-warning {
    background-color: #ffc107;
    color: #212529;
  }
  .btn-warning:hover {
    background-color: #e0a800;
  }

  /* Nút xóa / nguy hiểm */
  .btn-danger {
    background-color: #dc3545;
    color: #fff;
  }
  .btn-danger:hover {
    background-color: #c82333;
  }

  /* Nút chính (cho bình luận) */
  .btn-primary {
    background-color: #007bff;
    color: #fff;
  }
  .btn-primary:hover {
    background-color: #0069d9;
  }

  /* Chỉ hiển thị icon, không cần margin */
  .btn i {
    margin: 0;
  }

  /* Khu vực bình luận */
  .comment-section {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #444;
  }
  .comment-count {
    font-weight: bold;
    margin-bottom: 10px;
    color: #ccc;
  }
  .comment-form .form-group {
    margin-bottom: 10px;
  }
  .btn-comment {
    padding: 8px;
  }
  .comment-list {
    margin-top: 10px;
  }

  /* Phần mỗi comment */
  .comment {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #2a2a2a;
    border: 1px solid #444;
    padding: 8px;
    border-radius: 5px;
    margin-bottom: 8px;
    color: #ddd;
  }
  .comment p {
    margin: 0;
  }
  .comment small {
    color: #aaa;
  }

  @media (min-width: 768px) {
    .blog-item {
      flex-direction: row;
      gap: 30px;
    }
    .blog-image, .blog-content-wrapper {
      flex: 1;
    }
  }
</style>
