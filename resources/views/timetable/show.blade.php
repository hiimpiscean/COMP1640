<div class="mb-3">
    <label class="form-label">Course</label>
    <input type="text" name="course_id" class="form-control" value="{{ $entry->course_id ?? '' }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Teacher</label>
    <input type="text" name="teacher_id" class="form-control" value="{{ $entry->teacher_id ?? '' }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Day of Week</label>
    <input type="date" name="day_of_week" class="form-control" value="{{ $entry->day_of_week ?? '' }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Start Time</label>
    <input type="time" name="start_time" class="form-control" value="{{ $entry->start_time ?? '' }}" required>
</div>

<div class="mb-3">
    <label class="form-label">End Time</label>
    <input type="time" name="end_time" class="form-control" value="{{ $entry->end_time ?? '' }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Location</label>
    <input type="text" name="location" class="form-control" value="{{ $entry->location ?? '' }}">
</div>

<div class="mb-3">
    <label class="form-label">Meet Link</label>
    <div class="input-group">
        <input type="text" id="meet_link" name="meet_link" class="form-control" readonly>
        <button type="button" class="btn btn-primary" id="generate-meet">Generate</button>
    </div>
</div>
<script>
    document.getElementById('generate-meet').addEventListener('click', function () {
        let startTime = document.querySelector('input[name="start_time"]').value;
        let endTime = document.querySelector('input[name="end_time"]').value;

        if (!startTime || !endTime) {
            alert("Vui lòng nhập Start Time và End Time trước khi tạo link.");
            return;
        }

        fetch('/generate-meet', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ start_time: startTime, end_time: endTime })
        })
            .then(response => response.json())
            .then(data => {
                if (data.meet_link) {
                    document.getElementById('meet_link').value = data.meet_link;
                } else {
                    alert("Lỗi khi tạo Meet Link.");
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>