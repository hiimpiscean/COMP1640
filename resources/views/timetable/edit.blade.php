<div class="modal fade" id="editTimetableModal{{ $entry->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('timetable.update', $entry->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Timetable</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Course</label>
                        <select name="course_id" class="form-control" required>
                            @foreach($courses as $course)
                                <option value="{{ $course->course_id }}" {{ $entry->course_id == $course->course_id ? 'selected' : '' }}>
                                    {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teacher</label>
                        <select name="teacher_id" class="form-control" required>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id_t }}" {{ $entry->teacher_id == $teacher->id_t ? 'selected' : '' }}>
                                    {{ $teacher->fullname_t }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Day of Week</label>
                        <select name="day_of_week" class="form-control" required>
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <option value="{{ $day }}" {{ $entry->day_of_week == $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="time" name="start_time" class="form-control" value="{{ $entry->start_time }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="time" name="end_time" class="form-control" value="{{ $entry->end_time }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <select name="location" class="form-control" required>
                            <option value="online" {{ $entry->location == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="offline" {{ $entry->location == 'offline' ? 'selected' : '' }}>Offline</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>