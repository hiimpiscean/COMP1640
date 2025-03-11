<style>


  .boy{
    margin-right: 100px;
    margin-left: 370px;
    margin-top: 10px;

    width: 85%;

  }


</style>
<div class="boy">

<dl class="row " >


  <dt class="col-sm-3">Full Name</dt>
  <dd class="col-sm-9">{{ $customer->fullname_c }}</dd>

  <dt class="col-sm-3">Dob</dt>
  <dd class="col-sm-9">{{ $customer->dob }}</dd>

  <dt class="col-sm-3">Gender</dt>
  <dd class="col-sm-9">{{ $customer->gender }}</dd>

  <dt class="col-sm-3">Phone</dt>
  <dd class="col-sm-9">{{ $customer->phone_c }}</dd>

  <dt class="col-sm-3">Email</dt>
  <dd class="col-sm-9">{{$customer->email_c }}</dd>

  <dt class="col-sm-3">Address</dt>
  <dd class="col-sm-9">{{$customer->address_c }}</dd>

  <dt class="col-sm-3">Password</dt>
  <dd class="col-sm-9">{{$customer->password_c}}</dd>

</dl>

</div>








