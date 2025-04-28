@extends('masters.uiMaster')

@section('main')
  <div class="container-b">
    <!-- Header -->
    <header class="header">
    <h1 class="header-title">Recent Posts</h1>
    @if(session('msg'))
    <div class="alert alert-success">{{ session('msg') }}</div>
  @endif
    </header>

    <!-- Nút thêm blog dạng floating -->
    <a href="{{ route('blog.create') }}" class="btn-add-blog" title="Thêm Blog">
    <i class="fa fa-plus"></i>
    </a>

    <!-- Danh sách bài viết (feed) -->
    <section class="feed">
    @foreach($blog as $item)
    <article class="post" data-aos="fade-up">
      <!-- Hiển thị ảnh nếu có -->
      @if($item->image_b)
      <div class="post-image">
      <img src="{{ asset('uploads/' . $item->image_b) }}" alt="{{ $item->title_b }}">
      </div>
    @endif

      <!-- Nội dung bài đăng -->
      <div class="post-content">
      <div class="post-meta">
      <span class="post-date">{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</span>
      <span class="dot">•</span>
      <span class="post-author">By {{ $item->author_b }}</span>
      </div>
      <h2 class="post-title">{{ $item->title_b }}</h2>
      <p class="post-excerpt">{{ \Illuminate\Support\Str::limit($item->content_b, 150) }}</p>

      <!-- Các nút hành động -->
      <div class="post-actions">
      <a href="{{ route('blog.show', ['id' => $item->id_b]) }}" class="action-btn" title="Xem chi tiết">
      <i class="fa fa-eye"></i>
      </a>
      @if(Session::has('username') && (Session::get('username') === $item->author_b || in_array(Session::get('role'), ['admin', 'staff'])))
      <a href="{{ route('blog.edit', ['id' => $item->id_b]) }}" class="action-btn" title="Sửa">
      <i class="fa fa-edit"></i>
      </a>
      <form action="{{ route('blog.destroy', ['id' => $item->id_b]) }}" method="post"
      onsubmit="return confirm('Bạn có chắc chắn muốn xóa Blog này không?');" class="inline-form">
      @csrf
      <input type="hidden" name="id_b" value="{{ $item->id_b }}">
      <button type="submit" class="action-btn" title="Xóa">
      <i class="fa fa-trash"></i>
      </button>
      </form>
    @endif
      </div>

      <!-- Khu vực bình luận -->
      <div class="comments-section">
      <div class="comments-header">
      <span>{{ isset($item->comment) ? count($item->comment) : 0 }} bình luận</span>
      </div>
      @if(Session::has('username'))
      <form action="{{ route('blog.comment.store', ['id' => $item->id_b]) }}" method="post" class="comment-form">
      @csrf
      <textarea name="content_cmt" placeholder="Bình luận của bạn"></textarea>
      <button type="submit" class="comment-submit" title="Gửi bình luận">
      <i class="fa fa-paper-plane"></i>
      </button>
      </form>
    @endif

      @if(isset($item->comment) && count($item->comment) > 0)
      <div class="comments-list">
      @foreach($item->comment as $comment)
      <div class="comment-item">
      <div class="comment-text">
      <p>{{ $comment->content_cmt }}</p>
      <small>{{ $comment->created_at }} - <strong>{{ $comment->author_cmt }}</strong></small>
      </div>
      @if(Session::has('username') && (Session::get('username') === $comment->author_cmt || in_array(Session::get('role'), ['admin', 'staff'])))
      <form action="{{ route('blog.comment.destroy', ['id' => $item->id_b, 'commentId' => $comment->id_cmt]) }}"
      method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này không?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="delete-comment" title="Xóa bình luận">
      <i class="fa fa-trash"></i>
      </button>
      </form>
    @endif
      </div>
    @endforeach
      </div>
    @endif
      </div>
      <!-- End bình luận -->
      </div>
    </article>
  @endforeach
    </section>
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
  /* Phông chữ & reset cơ bản */
  body {
    background: #fafafa;
    color: #262626;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  }

  /* Khung chứa chính */
  .container-b {
    max-width: 935px;
    margin: 40px auto;
    padding: 20px;
    background: #fff;
    border: 1px solid #dbdbdb;
    border-radius: 3px;
    margin-top: 100px;
  }

  /* Header */
  .header {
    text-align: center;
    margin-bottom: 20px;
  }

  .header-title {
    font-size: 30px;
    font-weight: 300;
    color: #262626;
    margin-bottom: 20px
  }

  .alert {
    margin-top: 10px;
    padding: 10px;
    background: #dff0d8;
    border: 1px solid #d0e9c6;
    border-radius: 3px;
    color: #3c763d;
  }

  /* Nút thêm blog dạng floating */
  .btn-add-blog {
    position: fixed;
    top: 80px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: #3897f0;
    color: #fff;
    font-size: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
    z-index: 100;
  }

  .btn-add-blog:hover {
    transform: scale(1.1);
    text-decoration: none;
  }

  /* Feed (danh sách bài viết) */
  .feed {
    display: flex;
    flex-direction: column;
    gap: 40px;
  }

  /* Mỗi bài post */
  .post {
    border: 1px solid #dbdbdb;
    border-radius: 3px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }

  /* Ảnh bài post */
  .post-image img {
    width: 100%;
    display: block;
  }

  /* Nội dung bài post */
  .post-content {
    padding: 15px;
  }

  /* Meta thông tin */
  .post-meta {
    font-size: 12px;
    color: #8e8e8e;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .dot {
    font-size: 14px;
  }

  /* Tiêu đề & tóm tắt */
  .post-title {
    font-size: 20px;
    margin: 0 0 10px;
    color: #262626;
    font-weight: 500;
  }

  .post-excerpt {
    font-size: 14px;
    color: #262626;
    line-height: 1.5;
    margin-bottom: 15px;
  }

  /* Nút hành động */
  .post-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
  }

  .action-btn {
    background: none;
    border: none;
    color: #3897f0;
    font-size: 18px;
    cursor: pointer;
    transition: color 0.3s ease;
    text-decoration: none;
  }

  .action-btn:hover {
    color: #0073e6;
  }

  .inline-form {
    display: inline;
  }

  /* Khu vực bình luận */
  .comments-section {
    border-top: 1px solid #efefef;
    padding-top: 10px;
  }

  .comments-header {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 8px;
    color: #8e8e8e;
  }

  /* Form bình luận */
  .comment-form {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
  }

  .comment-form textarea {
    flex: 1;
    border: 1px solid #dbdbdb;
    border-radius: 3px;
    padding: 8px;
    font-size: 14px;
    resize: none;
    height: 40px;
  }

  .comment-submit {
    background: none;
    border: none;
    color: #3897f0;
    font-size: 20px;
    cursor: pointer;
  }

  /* Danh sách bình luận */
  .comments-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .comment-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
  }

  .comment-text p {
    font-size: 14px;
    margin: 0;
    color: #262626;
  }

  .comment-text small {
    font-size: 12px;
    color: #8e8e8e;
  }

  .delete-comment {
    background: none;
    border: none;
    color: #ed4956;
    font-size: 16px;
    cursor: pointer;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .container {
      margin: 20px;
      padding: 10px;
    }
  }
</style>