@extends('masters.uiMaster')

@section('title', 'Quản lý đăng ký khóa học')

@section('main')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Quản lý đăng ký khóa học</h1>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách đăng ký đang chờ xử lý</h5>
        </div>
        <div class="card-body">
            @if(count($registrations) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Học viên</th>
                            <th>Email</th>
                            <th>Khóa học</th>
                            <th>Giáo viên</th>
                            <th>Ngày đăng ký</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                        <tr>
                            <td>{{ $registration->id }}</td>
                            <td>{{ $registration->student->name }}</td>
                            <td>{{ $registration->student->email }}</td>
                            <td>{{ $registration->course->name_p }}</td>
                            <td>{{ $registration->teacher->name_t }}</td>
                            <td>{{ \Carbon\Carbon::parse($registration->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-success btn-sm me-2" 
                                        onclick="confirmApprove({{ $registration->id }})">
                                        <i class="fas fa-check"></i> Duyệt
                                    </button>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="confirmReject({{ $registration->id }})">
                                        <i class="fas fa-times"></i> Từ chối
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info mb-0">
                Hiện tại không có đăng ký nào đang chờ xử lý.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmApprove(registrationId) {
        Swal.fire({
            title: 'Xác nhận duyệt',
            text: "Bạn có chắc chắn muốn phê duyệt đăng ký này?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                approveRegistration(registrationId);
            }
        });
    }
    
    function confirmReject(registrationId) {
        Swal.fire({
            title: 'Xác nhận từ chối',
            text: "Bạn có chắc chắn muốn từ chối đăng ký này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                rejectRegistration(registrationId);
            }
        });
    }
    
    function approveRegistration(registrationId) {
        // Gửi yêu cầu phê duyệt
        fetch('{{ url("staff/course-registrations") }}/' + registrationId + '/approve', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Đã phê duyệt đăng ký thành công.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Thất bại!',
                    text: data.message || 'Có lỗi xảy ra khi phê duyệt đăng ký.',
                    confirmButtonText: 'Đóng'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Có lỗi xảy ra trong quá trình xử lý.',
                confirmButtonText: 'Đóng'
            });
        });
    }
    
    function rejectRegistration(registrationId) {
        // Gửi yêu cầu từ chối
        fetch('{{ url("staff/course-registrations") }}/' + registrationId + '/reject', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Đã từ chối đăng ký thành công.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Thất bại!',
                    text: data.message || 'Có lỗi xảy ra khi từ chối đăng ký.',
                    confirmButtonText: 'Đóng'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Có lỗi xảy ra trong quá trình xử lý.',
                confirmButtonText: 'Đóng'
            });
        });
    }
</script>
@endsection 