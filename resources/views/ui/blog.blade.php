@extends('masters.uiMaster')
@section('main')
  <div class="blog-header">Đánh giá khóa học</div>
  <div class="container-blog">
    <div class="left-panel">
      <div class="write-review">
        <h2>Viết đánh giá</h2>
        <textarea id="reviewText" placeholder="Nhập đánh giá của bạn" rows="4"></textarea>
        <div class="review-media">
          <input type="file" id="reviewImage" accept="image/*">
          <img id="imagePreview" class="image-preview" style="display:none;">
        </div>
        <button id="submitReview">Đăng bài</button>
      </div>
    </div>
    <div class="right-panel">
      <div class="reviews-section">
        <h2>Đánh giá từ học sinh</h2>
        <div id="reviews"></div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true,
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const reviewText = document.getElementById('reviewText');
      const reviewImage = document.getElementById('reviewImage');
      const imagePreview = document.getElementById('imagePreview');
      const reviewsContainer = document.getElementById('reviews');

      reviewImage.addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
          let reader = new FileReader();
          reader.onload = e => {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
          };
          reader.readAsDataURL(file);
        } else {
          imagePreview.style.display = 'none';
          imagePreview.src = '';
        }
      });

      document.getElementById('submitReview').addEventListener('click', function() {
        let text = reviewText.value.trim();
        let imageSrc = imagePreview.src;

        if (!text && imageSrc === "") {
          alert("Bạn phải nhập nội dung hoặc chọn ảnh trước khi đăng bài!");
          return;
        }

        let review = document.createElement('div');
        review.classList.add('review');
        review.innerHTML = `
        <div class="review-content">
          <span>${text}</span>
          ${imageSrc ? `<img src="${imageSrc}">` : ''}
        </div>
        <div class="review-actions">
          <button class="like-btn"><i class="fa fa-thumbs-up"></i> <span>0</span></button>
          <span class="comment-count">0 Bình luận</span>
          <button class="delete-review"><i class="fa fa-trash"></i> Delete</button>
        </div>
        <div class="comments">
          <div class="comments-list"></div>
          <div class="comment-input">
            <input type="text" placeholder="Viết bình luận...">
            <button class="submit-comment">Gửi</button>
          </div>
        </div>`;

        reviewsContainer.prepend(review);
        reviewText.value = '';
        reviewImage.value = '';
        imagePreview.style.display = 'none';
        imagePreview.src = '';
      });

      reviewsContainer.addEventListener('click', function(event) {
        let target = event.target;
        let review = target.closest('.review');

        // Xóa bài viết
        if (target.classList.contains('delete-review')) {
          if (confirm("Bạn có chắc chắn muốn xóa bài viết này không?")) {
            if (review) review.remove();
          }
        }

        // Like bài viết
        if (target.classList.contains('like-btn')) {
          let span = target.querySelector('span');
          let count = parseInt(span.textContent);
          target.classList.toggle('liked');
          span.textContent = target.classList.contains('liked') ? count + 1 : count - 1;
        }

        // Gửi bình luận
        if (target.classList.contains('submit-comment')) {
          let input = target.previousElementSibling;
          let commentsList = review.querySelector('.comments-list');
          if (input.value.trim()) {
            let comment = document.createElement('div');
            comment.classList.add('comment');
            comment.innerHTML = `${input.value} <button class="delete-comment">X</button>`;
            commentsList.appendChild(comment);
            input.value = '';

            let commentCount = review.querySelector('.comment-count');
            commentCount.textContent = (parseInt(commentCount.textContent) + 1) + " Bình luận";
          }
        }

        // Xóa bình luận
        if (target.classList.contains('delete-comment')) {
          let comment = target.parentElement;
          comment.remove();
          let commentCount = review.querySelector('.comment-count');
          commentCount.textContent = (parseInt(commentCount.textContent) - 1) + " Bình luận";
        }
      });
    });
  </script>
@endsection

<style>
  body {
    background: #f0f2f5;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  .blog-header {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: white;
    text-align: center;
    padding: 20px;
    font-size: 26px;
    font-weight: bold;
    border-radius: 0 0 12px 12px;
  }

  .container-blog {
    display: flex;
    max-width: 900px;
    margin: 20px auto;
    gap: 20px;
  }

  .left-panel, .right-panel {
    flex: 1;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
  }

  .write-review h2, .reviews-section h2 {
    font-size: 22px;
    margin-bottom: 15px;
  }

  textarea {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    resize: none;
  }

  .review-media {
    margin-top: 10px;
  }

  #reviewImage {
    display: block;
    margin-bottom: 10px;
  }

  .image-preview {
    width: 100%;
    max-height: 200px;
    border-radius: 8px;
    object-fit: cover;
  }

  #submitReview {
    background: #2575fc;
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
  }

  #submitReview:hover {
    background: #1a5ed1;
  }

  .review {
    border: 1px solid #ddd;
    padding: 15px;
    margin-top: 15px;
    border-radius: 8px;
    background: #fff;
    transition: 0.3s;
  }

  .review:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }

  .review-content span {
    font-size: 16px;
    display: block;
    margin-bottom: 10px;
  }

  .review-content img {
    width: 100%;
    max-height: 200px;
    border-radius: 8px;
    object-fit: cover;
  }

  .review-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 10px;
  }

  .review-actions button {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
  }

  .like-btn {
    color: #2575fc;
    font-weight: bold;
  }

  .like-btn:hover {
    color: #1a5ed1;
  }

  .liked {
    color: red !important;
  }

  .delete-review {
    color: red;
    font-weight: bold;
    cursor: pointer;
  }

  .delete-review:hover {
    color: darkred;
  }

  .comment-input {
    display: flex;
    margin-top: 10px;
  }

  .comment-input input {
    flex: 1;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-right: 5px;
  }

  .comment-input button {
    background: #28a745;
    color: white;
    border: none;
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
  }

  .comment-input button:hover {
    background: #218838;
  }

  .comments-list {
    margin-top: 10px;
  }

  .comment {
    background: #f0f0f0;
    padding: 8px 12px;
    border-radius: 6px;
    margin-bottom: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .comment .delete-comment {
    background: none;
    border: none;
    color: red;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
  }

  .comment .delete-comment:hover {
    color: darkred;
  }
</style>
