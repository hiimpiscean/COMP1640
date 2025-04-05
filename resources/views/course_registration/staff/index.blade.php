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
    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tổng quan đăng ký</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-warning bg-opacity-10 h-100">
                        <div class="card-body text-center">
                            <h3 class="card-title">Đang chờ duyệt</h3>
                            <h2 class="mt-3 mb-2" id="pendingCount">{{ count(array_filter($registrations, function($r) { return $r->status === 'pending'; })) }}</h2>
                            <p class="card-text text-muted">đăng ký đang chờ xử lý</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success bg-opacity-10 h-100">
                        <div class="card-body text-center">
                            <h3 class="card-title">Đã phê duyệt</h3>
                            <h2 class="mt-3 mb-2" id="approvedCount">{{ count(array_filter($registrations, function($r) { return $r->status === 'approved'; })) }}</h2>
                            <p class="card-text text-muted">đăng ký đã được duyệt</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger bg-opacity-10 h-100">
                        <div class="card-body text-center">
                            <h3 class="card-title">Đã từ chối</h3>
                            <h2 class="mt-3 mb-2" id="rejectedCount">{{ count(array_filter($registrations, function($r) { return $r->status === 'rejected'; })) }}</h2>
                            <p class="card-text text-muted">đăng ký đã bị từ chối</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách đăng ký đang chờ xử lý</h5>
        </div>
        <div class="card-body">
            @php
                $pendingRegistrations = array_filter($registrations, function($r) { return $r->status === 'pending'; });
            @endphp
            
            @if(count($pendingRegistrations) > 0)
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
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRegistrations as $registration)
                        <tr data-registration-id="{{ $registration->id }}">
                            <td>{{ $registration->id }}</td>
                            <td>{{ $registration->student->fullname_c ?? 'N/A' }}</td>
                            <td>{{ $registration->student->email ?? 'N/A' }}</td>
                            <td>{{ $registration->course->name_p ?? 'N/A' }}</td>
                            <td>{{ $registration->teacher->fullname_t ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($registration->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge bg-warning status-badge">Chờ duyệt</span>
                            </td>
                            <td>
                                <div class="d-flex action-buttons">
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
    
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Danh sách đăng ký đã duyệt</h5>
        </div>
        <div class="card-body">
            @php
                $approvedRegistrations = array_filter($registrations, function($r) { return $r->status === 'approved'; });
            @endphp
            
            @if(count($approvedRegistrations) > 0)
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
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approvedRegistrations as $registration)
                        <tr data-registration-id="{{ $registration->id }}">
                            <td>{{ $registration->id }}</td>
                            <td>{{ $registration->student->fullname_c ?? 'N/A' }}</td>
                            <td>{{ $registration->student->email ?? 'N/A' }}</td>
                            <td>{{ $registration->course->name_p ?? 'N/A' }}</td>
                            <td>{{ $registration->teacher->fullname_t ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($registration->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge bg-success status-badge">Đã duyệt</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info mb-0">
                Chưa có đăng ký nào được duyệt.
            </div>
            @endif
        </div>
    </div>
    
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Danh sách đăng ký đã từ chối</h5>
        </div>
        <div class="card-body">
            @php
                $rejectedRegistrations = array_filter($registrations, function($r) { return $r->status === 'rejected'; });
            @endphp
            
            @if(count($rejectedRegistrations) > 0)
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
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rejectedRegistrations as $registration)
                        <tr data-registration-id="{{ $registration->id }}">
                            <td>{{ $registration->id }}</td>
                            <td>{{ $registration->student->fullname_c ?? 'N/A' }}</td>
                            <td>{{ $registration->student->email ?? 'N/A' }}</td>
                            <td>{{ $registration->course->name_p ?? 'N/A' }}</td>
                            <td>{{ $registration->teacher->fullname_t ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($registration->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge bg-danger status-badge">Đã từ chối</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info mb-0">
                Chưa có đăng ký nào bị từ chối.
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
        // Hiển thị loading
        Swal.fire({
            title: 'Đang xử lý...',
            text: 'Vui lòng đợi trong giây lát',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
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
        // Hiển thị loading
        Swal.fire({
            title: 'Đang xử lý...',
            text: 'Vui lòng đợi trong giây lát',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
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