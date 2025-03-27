@extends('masters.uiMaster')

@section('main')
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #f8f9fa;
    }

    .content {
      width: 100%;
      max-width: 1280px;
      margin: 0 auto;
      padding: 20px;
    }

    .shadow-box {
      background: white;
      border-radius: 10px;
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .signup-wrapper {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: center;
      max-width: 900px;
      margin: 50px auto;
    }

    .signup-wrapper .company-details {
      background: url('{{ asset('images/images/login.jpg') }}') no-repeat center center;
      background-size: cover;
      width: 100%;
      min-height: 130vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
      padding: 20px;
      position: relative;
    }

    .signup-wrapper .company-details:before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
    }

    .signup-wrapper .company-details h1 {
      font-size: 2em;
      text-transform: uppercase;
      position: relative;
      z-index: 1;
    }
    .signup-wrapper .company-details p {
      position: relative;
      z-index: 1;
    }

    .signup-wrapper .signup-form {
      width: 100%;
      padding: 30px;
    }

    .signup-wrapper .signup-form .form-title {
      font-size: 1.5em;
      color: #d4a50c;
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .signup-wrapper .signup-form .form input,
    .signup-wrapper .signup-form .form select {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1em;
    }

    .signup-wrapper .signup-form .form input::placeholder {
      color: #999;
    }

    .signup-wrapper .signup-form .signup {
      width: 100%;
      background-color: #d4a50c;
      border: none;
      color: white;
      padding: 15px;
      font-size: 1em;
      text-transform: uppercase;
      margin-top: 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .signup-wrapper .signup-form .signup:hover {
      background-color: #b38d0a;
    }

    .signup-wrapper .signup-form .login-link {
      text-align: center;
      margin-top: 15px;
    }

    .signup-wrapper .signup-form .login-link a {
      color: #d4a50c;
      text-decoration: none;
      font-weight: bold;
    }

    @media (min-width: 768px) {
      .signup-wrapper {
        flex-direction: row;
      }

      .signup-wrapper .company-details {
        width: 50%;
        height: auto;
      }

      .signup-wrapper .signup-form {
        width: 50%;
      }
    }
  </style>

  @include('partials.errors')

  <body>
  <form action="{{route('ui.store')}}" method="post">
    @csrf
    <input type="hidden" name="id_c" value="{{old('id_c')?? $customer->id_c}}">

    <div class="content">
      <div class="signup-wrapper shadow-box">
        <div class="company-details">
          <h1>ATN Website</h1>
          <p>We bring happiness to you!</p>
        </div>
        <div class="signup-form">
          <div class="form-title">Sign Up</div>
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
              <input type="text" id="email_c" name="email_c" placeholder="Enter your email" value="{{old('email_c')?? $customer->email_c}}">
            </label>
            <label>Address
              <input type="text" id="address_c" name="address_c" placeholder="Enter your address" value="{{old('address_c')?? $customer->address_c}}">
            </label>
            <label>Phone
              <input type="text" id="phone_c" name="phone_c" placeholder="Enter your phone number" value="{{old('phone_c')?? $customer->phone_c}}">
            </label>
            <label>Password
              <input type="password" name="password" placeholder="Enter your Password" required>
            </label>
            <label>Confirm Password
              <input type="password" name="password_confirmation" placeholder="Enter Confirm Password" required>
            </label>
            <button type="submit" class="signup">Sign up</button>
            <div class="login-link">
              <p>Go here if you already have an account <a href="{{route('auth.signin')}}">Sign in</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  </body>
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
