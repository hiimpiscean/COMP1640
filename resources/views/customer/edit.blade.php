@extends('masters.dashboardMaster')

@section('main')
  <style>
    /* Global Reset */
    *, *::before, *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      background: #4e657a;
      color: #fff;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    a {
      color: inherit;
      transition: color 0.3s ease;
    }
    a:focus, a:hover {
      text-decoration: none;
    }

    /* Layout */
    .form-container {
      padding: 2rem;
      width: 1000px;
      margin: auto;
      background: #50697f;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    /* Form Styling */
    .form-group {
      margin-bottom: 1rem;
    }
    .form-group label {
      font-weight: bold;
      display: block;
      margin-bottom: 0.5rem;
    }
    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #415a70;
      border-radius: 5px;
      background: #394e64;
      color: #fff;
      margin-bottom: 1rem;
    }

    .button-group {
      display: flex;
      gap: 15px;
      justify-content: space-around;
      margin-top: 30px;
    }

    .btn-dark, .btn-info {
      width: 120px; /* Đảm bảo cả hai nút có cùng kích thước */
      padding: 10px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      text-align: center;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-dark {
      background: #f5a623;
      color: #fff;
    }

    .btn-dark:hover {
      background: #e6951d;
      transform: scale(1.05);
    }

    .btn-info {
      background: #60a6dd;
      color: #fff;
    }

    .btn-info:hover {
      background: #394e64;
      transform: scale(1.05);
    }
  </style>

  <div class="form-container">
    <h2 class="text-center">Update An Existing Customer</h2>

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

      <div class="button-group">
        <button type="submit" class="btn-dark">Submit</button>
        <a href="{{ route('customer.index') }}" class="btn-info">Cancel</a>
      </div>
    </form>
  </div>
@endsection
