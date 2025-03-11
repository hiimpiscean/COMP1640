@extends('masters.dashboardMaster')

@section('main')
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-title {
      font-size: 1.8em;
      color: #333;
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .form label {
      display: block;
      font-weight: bold;
      margin-top: 10px;
      color: #555;
    }

    .form input, .form select {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1em;
      background: #fff;
      transition: 0.3s;
    }

    .form input:focus, .form select:focus {
      border-color: #d4a50c;
      outline: none;
      box-shadow: 0 0 5px rgba(212, 165, 12, 0.5);
    }

    .form input::placeholder {
      color: #aaa;
    }

    .btn-container {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .btn {
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    .btn-dark:hover {
      background-color: #23272b;
    }

    .btn-info:hover {
      background-color: #117a8b;
    }
  </style>

  <div class="container">
    <h1 class="form-title">New Customer</h1>

    @include('partials.errors')

    <form action="{{ route('customer.store') }}" method="post">
      @csrf
      <input type="hidden" name="id_c" value="{{old('id_c')?? $customer->id_c}}">
      <div class="form">
        <label>Full Name
          <input type="text" id="fullname_c" name="fullname_c" placeholder="Enter your full name" value="{{old('fullname_c')?? $customer->fullname_c}}">
        </label>
        <label>DOB
          <input type="date" id="dob" name="dob" value="{{old('dob')?? $customer->dob}}">
        </label>
        <label>Gender
          <select id="gender" name="gender">
            <option>Female</option>
            <option>Male</option>
            <option>Other</option>
          </select>
        </label>
        <label>Email
          <input type="email" id="email_c" name="email_c" placeholder="Enter your email" value="{{old('email_c')?? $customer->email_c}}">
        </label>
        <label>Address
          <input type="text" id="address_c" name="address_c" placeholder="Enter your address" value="{{old('address_c')?? $customer->address_c}}">
        </label>
        <label>Phone
          <input type="tel" id="phone_c" name="phone_c" placeholder="Enter your phone number" value="{{old('phone_c')?? $customer->phone_c}}">
        </label>
        <label>Password
          <input type="password" name="password_c" placeholder="Enter Password"
                 @if(!isset($customer->id_c)) required @endif>
        </label>
        <label>Confirm Password
          <input type="password" name="password_c_confirmation" placeholder="Enter Confirm Password"
                 @if(!isset($customer->id_c)) required @endif>
        </label>
        <div class="btn-container">
          <button type="submit" class="btn btn-dark">Sign up</button>
          <a href="{{ route('customer.index') }}" class="btn btn-info">Cancel</a>
        </div>
      </div>
    </form>
  </div>
@endsection
