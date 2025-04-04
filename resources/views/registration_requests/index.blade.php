@extends('masters.uiMaster')
@section('main')
    <div class="container-t">
        <h2 class="mb-4">Quản lý đăng ký khóa học</h2>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-clipboard-list"></i> Danh sách yêu cầu đăng ký chờ duyệt
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover registration-table">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Khóa học</th>
                                <th>Học sinh</th>
                                <th>Ngày đăng ký</th>
                                <th>Ghi chú</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>
                                        <span class="course-name">{{ $request->course_name }}</span>
                                    </td>
                                    <td>
                                        <span class="student-name">{{ $request->student_name }}</span>
                                    </td>
                                    <td>{{ date('d/m/Y H:i', strtotime($request->created_at)) }}</td>
                                    <td>{{ $request->description ?? 'Không có ghi chú' }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <form action="{{ route('registration.approve', $request->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm approval-btn">
                                                    <i class="fas fa-check"></i> Duyệt
                                                </button>
                                            </form>

                                            <form action="{{ route('registration.reject', $request->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Bạn có chắc chắn muốn từ chối yêu cầu này?');"
                                                    class="btn btn-danger btn-sm reject-btn">
                                                    <i class="fas fa-times"></i> Từ chối
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center empty-message">
                                        <i class="fas fa-info-circle"></i> Không có yêu cầu đăng ký nào đang chờ duyệt
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Căn giữa container và tạo khoảng cách */
        .container-t {
            max-width: 90%;
            margin: 20px auto;
        }

        /* Tiêu đề */
        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        /* Card */
        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            font-weight: bold;
            font-size: 18px;
        }

        /* Bảng hiển thị danh sách */
        .registration-table {
            margin-bottom: 0;
        }

        .table thead {
            background-color: #343a40;
            color: #fff;
        }

        /* Dòng dữ liệu */
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Tên khóa học */
        .course-name {
            font-weight: bold;
            color: #007bff;
        }

        /* Tên học sinh */
        .student-name {
            font-weight: 500;
        }

        /* Nút thao tác */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        /* Nút duyệt */
        .approval-btn {
            min-width: 80px;
        }

        /* Nút từ chối */
        .reject-btn {
            min-width: 80px;
        }

        /* Thông báo khi không có dữ liệu */
        .empty-message {
            padding: 20px;
            font-style: italic;
            color: #666;
        }
    </style>
@endsection