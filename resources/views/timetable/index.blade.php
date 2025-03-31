@extends('masters.uiMaster')
@section('main')
  <div class="container-t">
    <h2 class="mb-4">Timetable Management</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

    <!-- Nút mở modal thêm -->
    @if(session('role') !== 'customer')
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTimetableModal">Add Timetable</button>
  @endif

    <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
      <th>ID</th>
      <th>Course</th>
      <th>Teacher</th>
      <th>Day</th>
      <th>Start Time</th>
      <th>End Time</th>
      <th>Location</th>
      <th>Meet Link</th>
      <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($timetable as $entry)
      <tr>
      <td>{{ $entry->id }}</td>
      <td>{{ $entry->course->name ?? 'N/A' }}</td>
      <td>{{ $entry->teacher->name ?? 'N/A' }}</td>
      <td>{{ $entry->day_of_week }}</td>
      <td>{{ $entry->start_time }}</td>
      <td>{{ $entry->end_time }}</td>
      <td>{{ $entry->location }}</td>
      <td><a href="{{ $entry->meet_link }}" target="_blank">Join</a></td>
      <td>
      @if(session('role') !== 'student')
      <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
      data-bs-target="#editTimetableModal{{ $entry->id }}">Edit</button>
      <form action="{{ route('timetable.delete', $entry->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger btn-sm"
      onclick="return confirm('Are you sure?')">Delete</button>
      </form>
    @endif
      </td>
      </tr>
      @include('timeTable.modal_edit', ['entry' => $entry])
    @endforeach
    </tbody>
    </table>
  </div>

  @include('timeTable.modal_add')

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

    /* Bảng hiển thị danh sách */
    .table {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    /* Header của bảng */
    .table thead {
    background-color: #343a40;
    color: #fff;
    }

    /* Dòng dữ liệu */
    .table tbody tr:hover {
    background-color: #f8f9fa;
    }

    /* Nút thêm */
    .btn-primary {
    display: block;
    width: fit-content;
    margin-bottom: 15px;
    font-weight: bold;
    }

    /* Nút chỉnh sửa */
    .btn-warning {
    color: #fff;
    }

    /* Nút xóa */
    .btn-danger {
    background-color: #dc3545;
    }

    /* Link Meet */
    a[target="_blank"] {
    color: #007bff;
    text-decoration: none;
    }

    a[target="_blank"]:hover {
    text-decoration: underline;
    }

    /* Hiệu ứng modal */
    .modal-content {
    border-radius: 10px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
    }
  </style>

@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
    duration: 1000,
    once: true,
    });
  </script>
@endsection