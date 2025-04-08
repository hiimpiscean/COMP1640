@extends('masters.uiMaster')
@section('main')
  <div class="container-t">
    <h2 class="mb-4">Timetable Schedule</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

    @if(session('role') !== 'customer' && session('role') !== 'teacher')
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTimetableModal">Add Schedule</button>
  @endif

    <div class="table-responsive">
    <table class="table table-bordered timetable-table">
      <thead class="table-dark">
      <tr>
        <th>Day</th>
        @php
        // Định nghĩa các khoảng thời gian
        $periods = [
        [
        'name' => 'Morning (7:30 - 11:30)',
        'condition' => function ($time) {
          return strtotime($time) < strtotime('12:00:00');
        }
        ],
        [
        'name' => 'Afternoon (13:00 - 17:00)',
        'condition' => function ($time) {
          return strtotime($time) >= strtotime('12:00:00') && strtotime($time) < strtotime('17:00:00');
        }
        ],
        [
        'name' => 'Evening (18:00 - 21:00)',
        'condition' => function ($time) {
          return strtotime($time) >= strtotime('17:00:00');
        }
        ],
        ];
    @endphp
        @foreach($periods as $period)
      <th>{{ $period['name'] }}</th>
    @endforeach
      </tr>
      </thead>
      <tbody>
      @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
      <tr>
      <td class="day-header">{{ $day }}</td>
      @foreach($periods as $period)
      <td>
      @foreach($timetable as $entry)
      @if($entry->day_of_week == $day && $period['condition']($entry->start_time))
      <div class="class-block">
      @php
      $courseName = 'N/A';
      if ($entry->course_id) {
      $course = App\Repository\ProductRepos::getProductById($entry->course_id);
      if (!empty($course) && is_array($course) && count($course) > 0) {
      $courseName = $course[0]->name_p ?? 'N/A';
      }
      }
      $teacherName = $entry->teacher_name ?? 'N/A';
  @endphp
      <div class="course-name">{{ $courseName }}</div>
      <div class="time-range">{{ $entry->start_time }} - {{ $entry->end_time }}</div>
      <div class="teacher-name">Teacher: {{ $teacherName }}</div>
      <div class="location">{{ $entry->location }}</div>

      <!-- Hiển thị Meet Link -->
      <div class="meet-link">
      @if($entry->meet_link)
      <a href="{{ $entry->meet_link }}" target="_blank" class="btn btn-sm btn-info">
      <i class="fas fa-video"></i> Join Meet
      </a>
    @else
      @if(session('role') !== 'customer' && session('role') !== 'teacher')
      <a href="{{ route('timetable.generate-meet', $entry->id) }}" class="btn btn-sm btn-outline-primary">
      <i class="fas fa-plus-circle"></i> Generate Meet
      </a>
    @else
      <span class="badge bg-secondary">No Meet Link</span>
    @endif
    @endif
      </div>

      @if(session('role') !== 'customer' && session('role') !== 'teacher')
      <div class="action-buttons">
      <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
      data-bs-target="#editTimetableModal{{ $entry->id }}">Edit</button>
      <form action="{{ route('timetable.delete', $entry->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-sm btn-danger"
      onclick="return confirm('Are you sure?')">Delete</button>
      </form>
      </div>
    @endif
      </div>
    @endif
    @endforeach
      </td>
    @endforeach
      </tr>
    @endforeach
      </tbody>
    </table>
    </div>
  </div>

  @include('timetable.create')
  @foreach($timetable as $entry)
    @include('timetable.edit', ['entry' => $entry])
  @endforeach

  <style>
    /* Container styling and spacing */
    .container-t {
    max-width: 95%;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    margin-top: 100px;
    }

    h2 {
    text-align: center;
    font-weight: bold;
    margin-bottom: 30px;
    color: #333;
    text-transform: uppercase;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
    }

    .timetable-table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
    border: 1px solid #dee2e6;
    }

    .timetable-table th {
    background-color: #343a40;
    color: white;
    text-align: center;
    padding: 12px;
    font-weight: bold;
    text-transform: uppercase;
    }

    .timetable-table td {
    padding: 10px;
    border: 1px solid #dee2e6;
    vertical-align: top;
    min-height: 100px;
    }

    .day-header {
    background-color: #f8f9fa;
    font-weight: bold;
    color: #495057;
    text-align: center;
    vertical-align: middle;
    width: 100px;
    }

    .class-block {
    background-color: #e3f2fd;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
    border-left: 4px solid #007bff;
    transition: all 0.3s ease;
    }

    .class-block:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .course-name {
    font-weight: bold;
    color: #0D47A1;
    font-size: 14px;
    margin-bottom: 5px;
    }

    .time-range {
    color: #4CAF50;
    font-size: 12px;
    margin-bottom: 5px;
    }

    .teacher-name {
    color: #6A1B9A;
    font-size: 12px;
    margin-bottom: 5px;
    }

    .location {
    color: #E65100;
    font-size: 12px;
    font-style: italic;
    margin-bottom: 5px;
    }

    /* Meet Link styling */
    .meet-link {
    margin: 8px 0;
    }

    .meet-link .btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: white;
    padding: 2px 8px;
    font-size: 11px;
    }

    .meet-link .btn-info:hover {
    background-color: #138496;
    border-color: #117a8b;
    }

    .meet-link .btn-outline-primary {
    color: #007bff;
    border-color: #007bff;
    background-color: transparent;
    padding: 2px 8px;
    font-size: 11px;
    }

    .meet-link .btn-outline-primary:hover {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    }

    .meet-link .badge {
    font-size: 11px;
    padding: 4px 8px;
    }

    .meet-link i {
    margin-right: 3px;
    }

    .btn-primary {
    background-color: #1976d2;
    border: none;
    padding: 10px 20px;
    font-weight: bold;
    border-radius: 30px;
    transition: all 0.3s ease;
    }

    .btn-primary:hover {
    background-color: #1565c0;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .action-buttons {
    margin-top: 5px;
    display: flex;
    gap: 5px;
    }

    @media (max-width: 768px) {
    .container-t {
      max-width: 100%;
      padding: 10px;
    }

    .timetable-table th,
    .timetable-table td {
      padding: 5px;
      font-size: 12px;
    }

    .day-header {
      width: 60px;
    }

    .class-block {
      padding: 5px;
    }
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