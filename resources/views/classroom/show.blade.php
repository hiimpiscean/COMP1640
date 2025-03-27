<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lớp học - E-Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Chi tiết lớp học</div>

                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="card-title">{{ $class['name'] }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Giảng viên: {{ $class['teacher'] }}</h6>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Thời gian bắt đầu:</strong></p>
                                <p>{{ $class['start_time'] }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Thời lượng:</strong></p>
                                <p>{{ $class['duration'] }} phút</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>Loại lớp học:</strong></p>
                                <span class="badge {{ $class['class_type'] === 'online' ? 'bg-success' : 'bg-primary' }}">
                                    {{ $class['class_type'] === 'online' ? 'Online' : 'Offline' }}
                                </span>
                            </div>
                            @if($class['class_type'] === 'online' && $class['meet_link'])
                                <div class="col-md-6">
                                    <p><strong>Link Google Meet:</strong></p>
                                    <a href="{{ $class['meet_link'] }}" target="_blank" class="btn btn-info">
                                        Vào lớp học
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('classroom.index') }}" class="btn btn-secondary">
                                Quay lại danh sách
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
