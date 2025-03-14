@extends('masters.dashboardMaster')

@section('main')
  <div class="container">
    <h2 class="my-4 text-danger">Xác nhận xóa nhân viên</h2>
    <p>Bạn có chắc chắn muốn xóa nhân viên <strong>{{ $staff->fullname_s }}</strong> không?</p>

    <form action="{{ route('staff.destroy', $staff->id_s) }}" method="POST">
      @csrf
      @method('DELETE')

      <button type="submit" class="btn btn-danger">Xóa</button>
      <a href="{{ route('staff.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
  </div>
@endsection
