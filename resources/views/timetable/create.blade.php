<div class="modal fade" id="addTimetableModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('timetable.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Timetable</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Course</label>
                        <select name="course_id" class="form-control" required>
                            @foreach($courses as $course)
                                <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teacher</label>
                        <select name="teacher_id" class="form-control" required>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id_t }}">{{ $teacher->fullname_t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Day of Week</label>
                        <select name="day_of_week" class="form-control" required>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <select name="location" class="form-control" required>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Đảm bảo modal hiển thị đúng */
    .modal {
        display: none;
        overflow: hidden;
    }

    /* Hiệu ứng nền mờ modal */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* Điều chỉnh vị trí modal */
    .modal-dialog {
        transform: translate(0, 0);
        transition: transform 0.3s ease-out;
    }

    /* Bo góc và hiệu ứng nổi */
    .modal-content {
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }

    /* Header của modal */
    .modal-header {
        background-color: #007bff;
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    /* Nút đóng */
    .btn-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: white;
        opacity: 0.8;
    }

    .btn-close:hover {
        opacity: 1;
    }

    /* Căn chỉnh footer */
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        /* Căn đều 2 nút */
        align-items: flex-start;
        padding: 10px 20px;
    }


    /* Định dạng nút */
    .modal-footer .btn {
        border-radius: 5px;
        min-width: 100px;
    }

    /* Nút Add */
    .modal-footer .btn-primary {
        background-color: #007bff;
        border: none;
        color: white;
    }

    .modal-footer .btn-primary:hover {
        background-color: #0056b3;
    }
</style>