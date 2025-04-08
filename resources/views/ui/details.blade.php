@extends('masters.uiMaster')

@section('main')
  <style>
    .container-detail {
    max-width: 1000px;
    padding: 30px;
    animation: fadeInUp 0.8s ease-in-out;
    margin: auto;
    margin-top: 60px;
    background-color: #f0f8ff;
    border-radius: 15px;
    box-shadow: 0px 10px 30px rgba(0, 123, 255, 0.2);
    }

    @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
    }

    .heading_container h1 {
    font-size: 40px;
    font-weight: bold;
    color: #0056b3;
    text-align: center;
    margin-bottom: 30px;
    position: relative;
    animation: fadeIn 1s ease-in-out;
    }

    .heading_container h1::after {
    content: "";
    display: block;
    width: 120px;
    height: 4px;
    background-color: #007bff;
    margin: 12px auto 0;
    border-radius: 2px;
    }

    .course-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0px 10px 30px rgba(0, 123, 255, 0.2);
    gap: 50px;
    }

    .course-image img {
    max-width: 100%;
    border-radius: 15px;
    box-shadow: 0px 10px 25px rgba(0, 123, 255, 0.2);
    transition: transform 0.3s ease-in-out;
    }

    .course-image img:hover {
    transform: scale(1.05);
    }

    .course-info {
    max-width: 600px;
    }

    .course-info h3 {
    font-size: 22px;
    font-weight: bold;
    color: #004080;
    margin-bottom: 10px;
    }

    .course-info p {
    font-size: 16px;
    line-height: 1.6;
    color: #333;
    margin-bottom: 15px;
    }

    .price {
    font-size: 26px;
    color: #007bff;
    font-weight: bold;
    }

    .btn-register {
    display: inline-block;
    font-size: 18px;
    font-weight: 700;
    padding: 14px 32px;
    border-radius: 8px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: #fff;
    text-decoration: none;
    transition: 0.3s ease-in-out;
    box-shadow: 0px 5px 15px rgba(0, 123, 255, 0.3);
    margin-top: 20px;
    }

    .btn-register:hover {
    background: linear-gradient(135deg, #0056b3, #003f7f);
    transform: scale(1.05);
    box-shadow: 0px 8px 20px rgba(0, 123, 255, 0.4);
    text-decoration: none;
    color: #fff;
    }
  </style>

  <div class="container-detail">
    <div class="heading_container">
    <h1>Course Details</h1>
    </div>

    <div class="course-wrapper">
    <div class="course-image">
      @if (!empty($product->image_p))
      <img src="{{ asset('images/handicraf/' . $product->image_p) }}" alt="Product Image">
    @else
      <img src="{{ asset('images/default-placeholder.png') }}" alt="No Image Available">
    @endif
    </div>

    <div class="course-info">
      <h3>Course Name</h3>
      <p>{{ $product->name_p ?? 'N/A' }}</p>

      <h3>About This Course</h3>
      <p style="white-space: pre-wrap;">{{ $product->description_p ?? 'N/A' }}</p>

      <h3>Price</h3>
      <p class="price">{{ isset($product->price_p) ? number_format($product->price_p, 0, ',', '.') : 'N/A' }} VND</p>

      <button type="button" class="btn-register" data-bs-toggle="modal" data-bs-target="#confirmModal">Register
      Now</button>
    </div>
    </div>
  </div>

  <!-- Modal Xác Nhận -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="confirmModalLabel">Confirm Registration</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      Are you sure you want to register for this course?
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      <button type="button" class="btn btn-success" id="confirmRegister">Accept</button>
      </div>
    </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
    AOS.init({
      duration: 1000,
      offset: 100,
      easing: 'ease-in-out',
      once: true
    });

    // Kiểm tra xem người dùng đã đăng nhập chưa
    const isLoggedIn = {{ Session::has('username') ? 'true' : 'false' }};
    const userRole = '{{ Session::get('role') }}';
    const username = '{{ Session::get('username') }}';
    
    console.log('Thông tin đăng nhập:', {
      isLoggedIn,
      userRole,
      username
    });

    // Đảm bảo modal đã được khởi tạo
    var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));

    // Xử lý sự kiện khi người dùng xác nhận đăng ký
    document.getElementById('confirmRegister').addEventListener('click', function() {
      // Kiểm tra trước nếu chưa đăng nhập
      if (!isLoggedIn) {
        Swal.fire({
          icon: 'error',
          title: 'You are not logged in',
          text: 'Please login to register for a course.',
          confirmButtonText: 'Login now'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '{{ route("auth.ask") }}';
          }
        });
        return;
      }
      
      // Kiểm tra role
      if (userRole !== 'student' && userRole !== 'customer') {
        Swal.fire({
          icon: 'error',
          title: 'You do not have permission to register',
          text: 'Only student accounts can register for courses.',
          confirmButtonText: 'I understand'
        });
        return;
      }
      
      // Hiển thị trạng thái đang xử lý
      const confirmButton = this;
      confirmButton.disabled = true;
      confirmButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
      
      // Đóng modal
      confirmModal.hide();
      
      // Lấy timetable_id từ dữ liệu
      const timetableId = '{{ $timetable_id ?? 0 }}';
      
      if (!timetableId || timetableId === '0') {
        console.warn('Cannot find timetable_id, please check the data');
      }
      
      // Gửi yêu cầu đăng ký khóa học
      fetch('{{ route("course.register", $product->id_p) }}', {
        method: 'POST',
        credentials: 'same-origin', // Đảm bảo gửi cookies và session với request
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          course_id: '{{ $product->id_p }}',
          timetable_id: timetableId // Thêm timetable_id vào request
        })
      })
      .then(response => {
        // Lấy response text và cố gắng parse như JSON
        return response.text().then(text => {
          try {
            return JSON.parse(text);
          } catch(e) {
            // Nếu không phải JSON, trả về object với error message
            console.error("Cannot parse JSON:", text);
            return { 
              success: false, 
              message: 'An error occurred: ' + (text || 'No response from server')
            };
          }
        });
      })
      .then(data => {
        console.log("Response data:", data);
        
        if (data.success) {
          // Hiển thị thông báo thành công
          Swal.fire({
            icon: 'success',
            title: 'Registration successful!',
            text: data.message || 'Your registration request has been recorded. Please wait for confirmation from the staff.',
            confirmButtonText: 'I understand'
          }).then((result) => {
            // Khi người dùng đóng thông báo thành công, tải lại trang chi tiết
            if (result.isConfirmed) {
              window.location.reload(); // Tải lại trang chi tiết hiện tại
              // Hoặc có thể dùng: window.location.href = "{{ route('ui.details', $product->id_p) }}";
            }
          });
        } else {
          // Thêm debug info để dễ dàng xác định vấn đề
          console.error("Course registration error:", {
            data,
            isLoggedIn,
            userRole,
            username,
            courseId: '{{ $product->id_p }}'
          });
          
          // Hiển thị thông báo lỗi
          Swal.fire({
            icon: 'error',
            title: 'Registration failed!',
            text: data.message || 'An error occurred during the registration process. Please try again later.',
            confirmButtonText: 'Close'
          });
          
          // Nếu lỗi liên quan đến đăng nhập, chuyển hướng đến trang đăng nhập
          if (data.message && data.message.includes("You are not logged in")) {
            setTimeout(function() {
              window.location.href = '{{ route("auth.ask") }}';
            }, 2000);
          }
        }
      })
      .catch(error => {
        console.error('Error:', error);
        
        // Hiển thị thông báo lỗi
        Swal.fire({
          icon: 'error',
          title: 'Registration failed!',
          text: 'An error occurred during the registration process. Please try again later.',
          confirmButtonText: 'Close'
        });
      })
      .finally(() => {
        // Khôi phục trạng thái nút
        confirmButton.disabled = false;
        confirmButton.innerHTML = 'Accept';
      });
    });
  </script>
@endsection