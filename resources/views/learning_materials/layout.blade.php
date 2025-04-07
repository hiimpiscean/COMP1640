{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Learning Materials')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('learning_materials.index') }}">Learning Materials</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
                    @else
                        @if(auth()->user()->role === 'teacher')
                            <li class="nav-item"><a class="nav-link" href="{{ route('learning_materials.create') }}">Upload</a>
                            </li>
                        @endif
                        @if(auth()->user()->role === 'staff')
                            <li class="nav-item"><a class="nav-link" href="{{ route('learning_materials.pending') }}">Pending
                                    Approvals</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>