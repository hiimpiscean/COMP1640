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
    .form-label {
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
      height: auto !important;
    }

    .button-group {
      display: flex;
      gap: 15px;
      justify-content: space-evenly;
    }

    .btn-primary, .btn-info {
      width: 120px; /* Đảm bảo cả hai nút có cùng kích thước */
      text-align: center;
      padding: 10px;
      border-radius: 5px;
      text-decoration: none;
      transition: background 0.3s ease;
      border: none;
      cursor: pointer;
      font-size: 1rem;
    }

    .btn-primary {
      background: #f5a623;
      color: #fff;
    }

    .btn-primary:hover {
      background: #e6951d;
    }

    .btn-info {
      background: #60a6dd;
      color: #fff;
    }

    .btn-info:hover {
      background: #394e64;
    }

    .mb-3 {
      margin-bottom: 1rem;
    }
  </style>

  <div class="form-container">
    <h2>New Student</h2>
    @include('partials.errors')
    <form action="{{ route('customer.store') }}" method="post">
      @csrf
      <input type="hidden" name="id_c" value="{{ old('id_c') ?? $customer->id_c }}">

      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" id="fullname_c" name="fullname_c" class="form-control" placeholder="Enter your full name" value="{{ old('fullname_c') ?? $customer->fullname_c }}">
      </div>

      <div class="mb-3">
        <label class="form-label">DOB</label>
        <input type="date" id="dob" name="dob" class="form-control" value="{{ old('dob') ?? $customer->dob }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Gender</label>
        <select id="gender" name="gender" class="form-control">
          <option>Female</option>
          <option>Male</option>
          <option>Other</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') ?? $customer->email }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" id="address_c" name="address_c" class="form-control" placeholder="Enter your address" value="{{ old('address_c') ?? $customer->address_c }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="tel" id="phone_c" name="phone_c" class="form-control" placeholder="Enter your phone number" value="{{ old('phone_c') ?? $customer->phone_c }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter Password" @if(!isset($customer->id_c)) required @endif>
      </div>

      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Enter Confirm Password" @if(!isset($customer->id_c)) required @endif>
      </div>

      <div class="button-group">
        <button type="submit" class="btn-primary">Sign up</button>
        <a href="{{ route('customer.index') }}" class="btn-info">Cancel</a>
      </div>
    </form>
  </div>
@endsection
