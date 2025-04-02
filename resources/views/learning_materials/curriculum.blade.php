@extends('masters.uiMaster')

@section('main')
  <div class="container curriculum-container">
    <h1 class="text-center mb-4">Curriculum Listing</h1>

    @if(!empty($product))
    <table class="curriculum-table">
    <thead>
      <tr>
      <th>CurriculumID</th>
      <th>Name</th>
      <th>IssuedDate</th>
      <th>Description</th>
      <th>DecisionNo</th>
      <th>Total Credit</th>
      </tr>
    </thead>
    <tbody>
      @foreach($product as $p)
      <tr>
      <td>{{ $p->id_p }}</td>
      <td><a href="{{ route('learning_materials.index', ['id_p' => $p->id_p]) }}">{{ $p->name_p }}</a></td>
      <td>{{ $p->issued_date ?? 'N/A' }}</td>
      <td>{{ $p->description ?? 'No description' }}</td>
      <td>{{ $p->decision_no ?? 'N/A' }}</td>
      <td>{{ $p->total_credit ?? 'N/A' }}</td>
      </tr>
    @endforeach
    </tbody>
    </table>
  @else
  <div class="col-12 text-center">
  <p class="text-danger">No products found for "{{ $productName }}".</p>
  </div>
@endif
  </div>

  <style>
    .curriculum-container {
    max-width: 1500px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 100px;
    margin-bottom: 20px;
    }

    .curriculum-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    }

    .curriculum-table th,
    .curriculum-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
    }

    .curriculum-table th {
    background-color: #a7d1fb;
    color: white;
    font-weight: bold;
    }

    .curriculum-table tr:nth-child(even) {
    background-color: #f9f9f9;
    }

    .curriculum-table tr:hover {
    background-color: #f1f1f1;
    }

    .curriculum-table a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
    }

    .curriculum-table a:hover {
    text-decoration: underline;
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