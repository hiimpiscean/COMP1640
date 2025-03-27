<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo lớp học mới - E-Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tạo lớp học mới</div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('classroom.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Tên lớp học</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="teacher" class="form-label">Giảng viên</label>
                                <input type="text" class="form-control @error('teacher') is-invalid @enderror" 
                                    id="teacher" name="teacher" value="{{ old('teacher') }}" required>
                                @error('teacher')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start_time" class="form-label">Thời gian bắt đầu</label>
                                <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" 
                                    id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="duration" class="form-label">Thời lượng (phút)</label>
                                <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                    id="duration" name="duration" value="{{ old('duration', 60) }}" required min="30" max="300">
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="class_type" class="form-label">Loại lớp học</label>
                                <select class="form-select @error('class_type') is-invalid @enderror" 
                                    id="class_type" name="class_type" required onchange="toggleLocationField()">
                                    <option value="">Chọn loại lớp học</option>
                                    <option value="online" {{ old('class_type') === 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="offline" {{ old('class_type') === 'offline' ? 'selected' : '' }}>Offline</option>
                                </select>
                                @error('class_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="location_field" style="{{ old('class_type') === 'offline' ? '' : 'display: none;' }}">
                                <label for="location" class="form-label">Địa điểm phòng học</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                    id="location" name="location" value="{{ old('location') }}" placeholder="Ví dụ: Phòng 304">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Tạo lớp học
                                </button>
                                <a href="{{ route('classroom.index') }}" class="btn btn-secondary">
                                    Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleLocationField() {
            var classType = document.getElementById('class_type').value;
            var locationField = document.getElementById('location_field');

            if (classType === 'offline') {
                locationField.style.display = '';
            } else {
                locationField.style.display = 'none';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
