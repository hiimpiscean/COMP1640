@extends('masters.dashboardMaster')

@section('main')

  <style>
    .but {
      margin: 30px 20px 40px 280px;
    }
    .cancel {
      margin-left: 400px;
    }
    .han {
      margin-top: 50px;
    }
  </style>

  <div class="container">
    <h1 class="display-4 text-center han">Update An Existing Customer</h1>

    {{-- Hiển thị thông báo thành công hoặc lỗi --}}
    @if (session('msg'))
      <div class="alert alert-success">
        {{ session('msg') }}
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    @include('partials.errors')

    <form action="{{ route('customer.update', ['id_c' => old('id_c') ?? $customer->id_c]) }}" method="post">
      @csrf
      @method('PUT')

      <input type="hidden" name="id_c" value="{{ $customer->id_c }}">

      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="fullname_c" class="form-control" value="{{ old('fullname_c') ?? $customer->fullname_c }}" required>
      </div>

      <div class="form-group">
        <label>Date of Birth</label>
        <input type="date" name="dob" class="form-control" value="{{ old('dob') ?? $customer->dob }}" required>
      </div>

      <div class="form-group">
        <label>Gender</label>
        <select name="gender" class="form-control">
          <option value="Male" {{ (old('gender') ?? $customer->gender) == 'Male' ? 'selected' : '' }}>Male</option>
          <option value="Female" {{ (old('gender') ?? $customer->gender) == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
      </div>

      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone_c" class="form-control" value="{{ old('phone_c') ?? $customer->phone_c }}" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') ?? $customer->email }}" required>
      </div>

      <div class="form-group">
        <label>Address</label>
        <input type="text" name="address_c" class="form-control" value="{{ old('address_c') ?? $customer->address_c }}" required>
      </div>

      <div class="form-group">
        <label>Old Password (Enter if you want to change password)</label>
        <input type="password" name="old_password" class="form-control">
      </div>

      <div class="form-group">
        <label>New Password (Leave empty if not changing)</label>
        <input type="password" name="password" class="form-control">
      </div>

      <div class="form-group">
        <label>Confirm New Password</label>
        <input type="password" name="password_confirmation" class="form-control">
      </div>

      <button type="submit" class="btn btn-dark but">Submit</button>
      <a href="{{ route('customer.index') }}" class="btn btn-info cancel">Cancel</a>
    </form>
  </div>

@endsection
