@extends('masters.dashboardMaster')

@section('main')
    <h1 class="mb-4">Pending Learning Materials</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Uploaded By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
                <tr>
                    <td>{{ $material->title }}</td>
                    <td>{{ $material->description ?? 'N/A' }}</td>
                    <td>{{ $material->uploader->name }}</td>
                    <td>
                        <form action="{{ route('learning_materials.approve', $material->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>

                        <form action="{{ route('learning_materials.reject', $material->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection