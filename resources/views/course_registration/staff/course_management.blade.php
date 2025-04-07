@extends('masters.dashboardMaster')

@section('main')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Quản lý khóa học</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên khóa học</th>
                                    <th>Giá</th>
                                    <th>Đăng ký chờ duyệt</th>
                                    <th>Đã phê duyệt</th>
                                    <th>Đã từ chối</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                <tr>
                                    <td>{{ $course->id_p }}</td>
                                    <td>{{ $course->name_p }}</td>
                                    <td>{{ number_format($course->price_p, 0, ',', '.') }} VND</td>
                                    <td>{{ $course->pending_count }}</td>
                                    <td>{{ $course->approved_count }}</td>
                                    <td>{{ $course->rejected_count }}</td>
                                    <td>
                                        @if($course->pending_count > 0)
                                            <button type="button" 
                                                class="btn btn-danger btn-sm reject-all-btn" 
                                                data-course-id="{{ $course->timetable_id ?? $course->id_p }}"
                                                data-course-name="{{ $course->name_p }}">
                                                Từ chối tất cả đăng ký
                                            </button>
                                        @else
                                            <span class="text-muted">Không có đăng ký chờ duyệt</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Không có khóa học nào</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận từ chối tất cả đăng ký -->
<div class="modal fade" id="rejectAllModal" tabindex="-1" aria-labelledby="rejectAllModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectAllModalLabel">Xác nhận từ chối tất cả đăng ký</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn từ chối <strong>tất cả</strong> các đăng ký đang chờ duyệt cho khóa học <span id="courseName"></span>?</p>
                <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác và sẽ gửi email thông báo đến tất cả học sinh đã đăng ký.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmRejectAll">Xác nhận từ chối tất cả</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
<script>
    $(function() {
        let courseId = null;
        
        // Hiển thị modal xác nhận
        $('.reject-all-btn').on('click', function() {
            courseId = $(this).data('course-id');
            const courseName = $(this).data('course-name');
            $('#courseName').text(courseName);
            $('#rejectAllModal').modal('show');
        });
        
        // Xử lý xác nhận từ chối tất cả
        $('#confirmRejectAll').on('click', function() {
            if (!courseId) return;
            
            $(this).attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');
            
            $.ajax({
                url: `/staff/course/${courseId}/reject-all-pending`,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#rejectAllModal').modal('hide');
                        Swal.fire({
                            title: 'Thành công!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Đóng'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Đóng'
                        });
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    Swal.fire({
                        title: 'Lỗi!',
                        text: response?.message || 'Có lỗi xảy ra khi xử lý yêu cầu.',
                        icon: 'error',
                        confirmButtonText: 'Đóng'
                    });
                },
                complete: function() {
                    $('#confirmRejectAll').attr('disabled', false).text('Xác nhận từ chối tất cả');
                }
            });
        });
    });
</script>
@endsection 