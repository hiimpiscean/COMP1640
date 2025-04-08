@extends('masters.dashboardMaster')

@section('main')

@section('main')
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Manager course registration</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Total registration</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-warning bg-opacity-10 h-100">
                            <div class="card-body text-center">
                                <h3 class="card-title">Waiting for approval</h3>
                                <h2 class="mt-3 mb-2" id="pendingCount">
                                    {{ count(array_filter($registrations, function ($r) {
        return $r->status === 'pending'; })) }}
                                </h2>
                                <p class="card-text text-muted">registration is waiting for approval</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success bg-opacity-10 h-100">
                            <div class="card-body text-center">
                                <h3 class="card-title">Approved</h3>
                                <h2 class="mt-3 mb-2" id="approvedCount">
                                    {{ count(array_filter($registrations, function ($r) {
        return $r->status === 'approved'; })) }}
                                </h2>
                                <p class="card-text text-muted">registration is approved</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger bg-opacity-10 h-100">
                            <div class="card-body text-center">
                                <h3 class="card-title">Rejected</h3>
                                <h2 class="mt-3 mb-2" id="rejectedCount">
                                    {{ count(array_filter($registrations, function ($r) {
        return $r->status === 'rejected'; })) }}
                                </h2>
                                <p class="card-text text-muted">registration is rejected</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">List of registrations waiting for approval</h5>
            </div>
            <div class="card-body">
                @php
                    $pendingRegistrations = array_filter($registrations, function ($r) {
                        return $r->status === 'pending';
                    });
                @endphp

                @if(count($pendingRegistrations) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Teacher</th>
                                    <th>Registration date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingRegistrations as $registration)
                                    <tr data-registration-id="{{ $registration->id }}">
                                        <td>{{ $registration->id }}</td>
                                        <td>{{ $registration->student->fullname_c ?? 'N/A' }}</td>
                                        <td>{{ $registration->student->email ?? 'N/A' }}</td>
                                        <td>{{ $registration->course->name_p ?? 'N/A' }}</td>
                                        <td>{{ $registration->teacher->fullname_t ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($registration->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-warning status-badge">Waiting for approval</span>
                                        </td>
                                        <td>
                                            <div class="d-flex action-buttons">
                                                <button class="btn btn-success btn-sm me-2"
                                                    onclick="confirmApprove({{ $registration->id }})">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="confirmReject({{ $registration->id }})">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        Currently, there are no registrations waiting for approval.
                    </div>
                @endif
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">List of approved registrations</h5>
            </div>
            <div class="card-body">
                @php
                    $approvedRegistrations = array_filter($registrations, function ($r) {
                        return $r->status === 'approved';
                    });
                @endphp

                @if(count($approvedRegistrations) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Teacher</th>
                                    <th>Registration date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($approvedRegistrations as $registration)
                                    <tr data-registration-id="{{ $registration->id }}">
                                        <td>{{ $registration->id }}</td>
                                        <td>{{ $registration->student->fullname_c ?? 'N/A' }}</td>
                                        <td>{{ $registration->student->email ?? 'N/A' }}</td>
                                        <td>{{ $registration->course->name_p ?? 'N/A' }}</td>
                                        <td>{{ $registration->teacher->fullname_t ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($registration->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-success status-badge">Approved</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        Currently, there are no approved registrations.
                    </div>
                @endif
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">List of rejected registrations</h5>
            </div>
            <div class="card-body">
                @php
                    $rejectedRegistrations = array_filter($registrations, function ($r) {
                        return $r->status === 'rejected';
                    });
                @endphp

                @if(count($rejectedRegistrations) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Teacher</th>
                                    <th>Registration date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rejectedRegistrations as $registration)
                                    <tr data-registration-id="{{ $registration->id }}">
                                        <td>{{ $registration->id }}</td>
                                        <td>{{ $registration->student->fullname_c ?? 'N/A' }}</td>
                                        <td>{{ $registration->student->email ?? 'N/A' }}</td>
                                        <td>{{ $registration->course->name_p ?? 'N/A' }}</td>
                                        <td>{{ $registration->teacher->fullname_t ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($registration->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-danger status-badge">Rejected</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        Currently, there are no rejected registrations.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmApprove(registrationId) {
            Swal.fire({
                title: 'Confirm approval',
                text: "Are you sure you want to approve this registration?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    approveRegistration(registrationId);
                }
            });
        }

        function confirmReject(registrationId) {
            Swal.fire({
                title: 'Confirm rejection',
                text: "Are you sure you want to reject this registration?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    rejectRegistration(registrationId);
                }
            });
        }

        function approveRegistration(registrationId) {
            // Hiển thị loading
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait for a moment',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Gửi yêu cầu phê duyệt
            fetch('{{ url("staff/course-registrations") }}/' + registrationId + '/approve', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'The registration has been approved successfully.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: data.message || 'An error occurred while approving the registration.',
                            confirmButtonText: 'Close'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while processing the registration.',
                        confirmButtonText: 'Close'
                    });
                });
        }

        function rejectRegistration(registrationId) {
            // Hiển thị loading
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait for a moment',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Gửi yêu cầu từ chối
            fetch('{{ url("staff/course-registrations") }}/' + registrationId + '/reject', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'The registration has been rejected successfully.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: data.message || 'An error occurred while rejecting the registration.',
                            confirmButtonText: 'Close'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while processing the registration.',
                        confirmButtonText: 'Close'
                    });
                });
        }
    </script>
@endsection