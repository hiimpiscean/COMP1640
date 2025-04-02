@extends('masters.dashboardMaster')

@section('main')
    <h1 class="mb-4">Upload New Learning Material</h1>

    <form action="{{ route('learning_materials.store') }}" method="POST" enctype="multipart/form-data" class="card p-4">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Upload File</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Upload</button>
    </form>
@endsection