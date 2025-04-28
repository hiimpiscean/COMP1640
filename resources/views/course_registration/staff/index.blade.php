@extends('masters.dashboardMaster')

@section('styles')
<style>
    .search-wrapper {
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .search-wrapper:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
    }
    
    .search-wrapper .input-group {
        border-radius: 0.25rem;
        box-shadow: 0 2px 5px rgba(0,0,0,.05);
    }
    
    .search-wrapper .form-control {
        border-color: #dee2e6;
        height: 46px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .search-wrapper .form-control:focus {
        box-shadow: none;
        border-color: #a9c6ff;
        transform: scale(1.01);
    }
    
    .search-wrapper .form-control::placeholder {
        color: #adb5bd;
        font-style: italic;
        transition: all 0.3s ease;
    }
    
    .search-wrapper .form-control:focus::placeholder {
        opacity: 0.7;
        transform: translateX(10px);
    }
    
    .search-wrapper .input-group-text {
        border-color: #dee2e6;
        color: #6c757d;
        transition: all 0.3s ease;
    }
    
    .search-wrapper:hover .input-group-text i {
        color: #0d6efd !important;
        animation: pulse 1s;
    }
    
    .search-wrapper .btn-primary {
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .search-wrapper .btn-primary:hover {
        transform: translateY(-2px);
    }
    
    .search-wrapper .btn-outline-secondary {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }
    
    /* Highlight for new registrations */
    .table tr.new-registration {
        background-color: rgba(255, 243, 205, 0.5) !important;
        transition: background-color 0.3s;
    }
    
    .table tr.new-registration:hover {
        background-color: rgba(255, 243, 205, 0.8) !important;
    }
    
    .badge-new {
        position: relative;
        background-color: #ff3860;
        color: white;
        padding: 2px 8px;
        font-size: 0.7rem;
        font-weight: bold;
        border-radius: 10px;
        margin-left: 8px;
        animation: pulse-new 2s infinite;
    }
    
    @keyframes pulse-new {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 56, 96, 0.7);
        }
        70% {
            box-shadow: 0 0 0 6px rgba(255, 56, 96, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 56, 96, 0);
        }
    }
    
    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .search-wrapper .input-group {
            flex-wrap: wrap;
        }
        
        .search-wrapper .btn {
            margin-top: 0.5rem;
            border-radius: 0.25rem;
            width: 100%;
        }
        
        .search-wrapper .form-control,
        .search-wrapper .input-group-text {
            border-radius: 0.25rem;
        }
    }
</style>
@endsection

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
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">List of registrations waiting for approval</h5>
                <span class="badge bg-light text-dark small rounded-pill">
                    <i class="fas fa-sort-amount-down"></i> 
                </span>
            </div>
            <div class="card-body">
                <!-- Search form -->
                <div class="row mb-4">
                    <div class="col-md-8 col-lg-6 mx-auto">
                        <div class="search-wrapper shadow-sm rounded">
                            <form action="{{ route('staff.registrations') }}" method="GET" class="d-flex">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-primary"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control border-start-0" 
                                        placeholder="Search by student name, email or course..." 
                                        value="{{ $searchTerm ?? '' }}">
                                    <button type="submit" class="btn btn-primary px-4 d-flex align-items-center">
                                        <i class="fas fa-search me-2"></i> Search
                                    </button>
                                    @if(!empty($searchTerm))
                                        <a href="{{ route('staff.registrations') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i> Clear
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @php
                    $pendingRegistrations = array_filter($registrations, function ($r) {
                        return $r->status === 'pending';
                    });
                    
                    // Sắp xếp đăng ký mới nhất lên trên đầu
                    usort($pendingRegistrations, function($a, $b) {
                        return strtotime($b->created_at) - strtotime($a->created_at);
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
                                    @php
                                        $isNew = (time() - strtotime($registration->created_at)) < 86400; // 24 hours = 86400 seconds
                                    @endphp
                                    <tr data-registration-id="{{ $registration->id }}" class="{{ $isNew ? 'new-registration' : '' }}">
                                        <td>{{ $registration->id }}</td>
                                        <td>
                                            {{ $registration->student->fullname_c ?? 'N/A' }}
                                            @if($isNew)
                                                <span class="badge-new">New</span>
                                            @endif
                                        </td>
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
                        @if(!empty($searchTerm))
                            No registrations found matching "{{ $searchTerm }}". 
                            <a href="{{ route('staff.registrations') }}">Clear search</a> to view all registrations.
                        @else
                            Currently, there are no registrations waiting for approval.
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">List of approved registrations</h5>
                <span class="badge bg-light text-dark small rounded-pill">
                    <i class="fas fa-sort-amount-down"></i> 
                </span>
            </div>
            <div class="card-body">
                @php
                    $approvedRegistrations = array_filter($registrations, function ($r) {
                        return $r->status === 'approved';
                    });
                    
                    // Sắp xếp đăng ký mới nhất lên trên đầu
                    usort($approvedRegistrations, function($a, $b) {
                        return strtotime($b->created_at) - strtotime($a->created_at);
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
                                    @php
                                        $isNew = (time() - strtotime($registration->created_at)) < 86400; // 24 hours = 86400 seconds
                                    @endphp
                                    <tr data-registration-id="{{ $registration->id }}" class="{{ $isNew ? 'new-registration' : '' }}">
                                        <td>{{ $registration->id }}</td>
                                        <td>
                                            {{ $registration->student->fullname_c ?? 'N/A' }}
                                            @if($isNew)
                                                <span class="badge-new">New</span>
                                            @endif
                                        </td>
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
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">List of rejected registrations</h5>
                <span class="badge bg-light text-dark small rounded-pill">
                    <i class="fas fa-sort-amount-down"></i> 
                </span>
            </div>
            <div class="card-body">
                @php
                    $rejectedRegistrations = array_filter($registrations, function ($r) {
                        return $r->status === 'rejected';
                    });
                    
                    // Sắp xếp đăng ký mới nhất lên trên đầu
                    usort($rejectedRegistrations, function($a, $b) {
                        return strtotime($b->created_at) - strtotime($a->created_at);
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
                                    @php
                                        $isNew = (time() - strtotime($registration->created_at)) < 86400; // 24 hours = 86400 seconds
                                    @endphp
                                    <tr data-registration-id="{{ $registration->id }}" class="{{ $isNew ? 'new-registration' : '' }}">
                                        <td>{{ $registration->id }}</td>
                                        <td>
                                            {{ $registration->student->fullname_c ?? 'N/A' }}
                                            @if($isNew)
                                                <span class="badge-new">New</span>
                                            @endif
                                        </td>
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