@extends('masters.dashboardMaster')

@section('main')
  <div class="confirm-container">
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

<style>
  /* Global Reset */
  *,
  *::before,
  *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    background: #4e657a;
    color: #fff;
    font-family: 'Roboto', Helvetica, Arial, sans-serif;
  }

  a {
    color: inherit;
    transition: color 0.3s ease;
    text-decoration: none;
  }

  a:hover,
  a:focus {
    text-decoration: none;
  }

  /* Layout */
  .confirm-container {
    padding: 2rem;
    width: 600px;
    margin: 50px auto;
    background: #50697f;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
  }

  .confirm-container h2 {
    color: white;
    margin-bottom: 1.5rem;
  }

  .confirm-container p {
    font-size: 1rem;
    margin-bottom: 1.5rem;
    border-bottom: 1px solid #415a70;
    padding-bottom: 0.5rem;
  }

  form {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
  }

  .btn-danger,
  .btn-secondary {
    width: 120px;
    padding: 10px;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    border: none;
    transition: background 0.3s ease, transform 0.2s ease;
    text-decoration: none;
  }

  .btn-danger {
    background: #d9534f;
    color: #fff;
  }

  .btn-danger:hover {
    background: #c9302c;
    transform: scale(1.05);
  }

  .btn-secondary {
    background: #60a6dd;
    color: #fff;
  }

  .btn-secondary:hover {
    background: #394e64;
    transform: scale(1.05);
  }
</style>