
{{--/////////////////////////////////////////////////--}}

<style>

  .boy{
    margin-right: 100px;
    margin-left: 90px;
    margin-top: 50px;
    width: 85%;

  }

</style>

<input type="hidden" name="id_c" value="{{old('id_c')?? $customer->id_c}}">
<div class="container boy">
  <div class="p-2 pt-md-4 pb-md-3 mx-auto text-center">
  </div>
  <div class="row">

    <div class="col-md-8 offset-2">
      <div class="row">
        <div class="col-md-6 mb-3 form-group">
          <label for="firstName">Full Name</label>
          <input type="text" class="form-control" id="fullname_c" name="fullname_c" value="{{old('fullname_c')?? $customer->fullname_c}}">
        </div>
        <div class="col-md-6 mb-3 form-group">
          <label for="lastName">DOB</label>
          <input type="date" class="form-control" id="dob" name="dob" value="{{old('dob')?? $customer->dob}}">
        </div>
      </div>
      <div class="mb-3 form-group">
        <label class="content-item">Gender
          <select class="form-control" id="gender" name="gender" value="{{old('gender')?? $customer->gender}}">
            <option>Female</option>
            <option>Male</option>
            <option>Other</option>
          </select>
        </label>
      </div>
      <div class="mb-3">
        <label for="email">Email</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">@</span>
          </div>
          <input type="text" class="form-control" id="email" name="email" value="{{old('email')?? $customer->email}}">
        </div>
      </div>
      <div class="mb-3 form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address_c" name="address_c" value="{{old('address_c')?? $customer->address_c}}">
      </div>
      <div class="mb-3 form-group">
        <label for="phone_c">Phone</label>
        <input type="text" class="form-control" id="phone_c" name="phone_c" value="{{old('phone_c')?? $customer->phone_c}}">
      </div>
      <div class="mb-3 form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" id="password" name="password" value="{{old('password')?? $customer->password}}">
      </div>
      <div class="mb-3 form-group">
        <label for="password_confirmation">Confirmation Password</label>
        <input type="text" class="form-control" id="password_confirmation" name="password_confirmation">
      </div>
    </div>
  </div>
</div>




