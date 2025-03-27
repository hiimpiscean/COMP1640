@extends('masters.dashboardMaster')

@section('main')
  <div class="container">
    <h2>Xác Nhận Xóa Giáo Viên</h2>
    <p>Bạn có chắc chắn muốn xóa giáo viên <strong>{{ $teacher->fullname_t }}</strong> không?</p>
    <form action="{{ route('teacher.destroy', $teacher->id_t) }}" method="POST">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">Xóa</button>
      <a href="{{ route('teacher.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
  </div>
@endsection
