<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách lớp học - E-Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Danh sách lớp học</h5>
                        <a href="{{ route('classroom.create') }}" class="btn btn-primary">Tạo lớp học mới</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(count($classes) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tên lớp</th>
                                            <th>Giảng viên</th>
                                            <th>Thời gian bắt đầu</th>
                                            <th>Thời lượng (phút)</th>
                                            <th>Loại lớp</th>
                                            <th>Thông tin lớp học</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($classes as $class)
                                            <tr>
                                                <td>{{ $class['name'] }}</td>
                                                <td>{{ $class['teacher'] }}</td>
                                                <td>{{ $class['start_time'] }}</td>
                                                <td>{{ $class['duration'] }}</td>
                                                <td>
                                                    <span class="badge {{ $class['class_type'] === 'online' ? 'bg-success' : 'bg-primary' }}">
                                                        {{ $class['class_type'] === 'online' ? 'Online' : 'Offline' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($class['class_type'] === 'online' && isset($class['meet_link']) && $class['meet_link'])
                                                        <a href="{{ $class['meet_link'] }}" target="_blank" class="btn btn-sm btn-info">
                                                            Link Meet
                                                        </a>
                                                    @elseif($class['class_type'] === 'offline' && isset($class['location']) && $class['location'])
                                                        <span class="badge bg-secondary">
                                                            {{ $class['location'] }}
                                                        </span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('classroom.show', $class['id']) }}" class="btn btn-sm btn-primary">
                                                        Chi tiết
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Chưa có lớp học nào được tạo.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
