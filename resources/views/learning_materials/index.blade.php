@extends('masters.uiMaster')

@section('main')
  <h1 class="mb-4">Approved Learning Materials</h1>

  <table class="table table-striped">
    <thead>
    <tr>
      <th>Title</th>
      <th>Description</th>
      <th>Uploaded By</th>
      <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($materials as $material)
    <tr>
      <td>{{ $material->title }}</td>
      <td>{{ $material->description ?? 'N/A' }}</td>
      <td>{{ $material->uploader->name }}</td>
      <td>
      <a href="{{ route('learning_materials.download', $material->id) }}" class="btn btn-primary btn-sm">Download</a>
      </td>
    </tr>
  @endforeach
    </tbody>
  </table>

  <style>
    body {
    padding-bottom: 50px;
    }

    .table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    }

    .table th,
    .table td {
    border: 1px solid #ddd;
    padding: 15px;
    text-align: left;
    }

    .table th {
    background-color: #a7d1fb;
    color: white;
    font-weight: bold;
    }

    .table tr:nth-child(even) {
    background-color: #f9f9f9;
    }

    .table tr:hover {
    background-color: #f1f1f1;
    }

    .btn-primary {
    background-color: #007bff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
    transition: background 0.3s;
    }

    .btn-primary:hover {
    background-color: #0056b3;
    text-decoration: none;
    }

    h1 {
    margin-bottom: 30px;
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