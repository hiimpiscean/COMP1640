<div class="modal fade" id="addTimetableModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('timetable.add') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Timetable</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('timeTable.timetable_form', ['entry' => null])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-primary-add">Add</button>
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
    .modal-footer .btn-primary-add {
        background-color: #007bff;
        border: none;
        color: white;
    }

    .modal-footer .btn-primary-add:hover {
        background-color: #0056b3;
    }
</style>