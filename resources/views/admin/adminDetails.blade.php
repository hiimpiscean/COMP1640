<style>


  .boy{
    margin-right: 100px;
    margin-left: 370px;
    margin-top: 10px;

    width: 85%;

  }


</style>

<div class="boy">
<dl class="row">

  <dt class="col-sm-3">Username</dt>
  <dd class="col-sm-9">{{ $admin->username }}</dd>

  <dt class="col-sm-3">FullName</dt>
  <dd class="col-sm-9">{{ $admin->fullname_a }}</dd>



  <dt class="col-sm-3">Phone</dt>
  <dd class="col-sm-9">{{ $admin->phone_a }}</dd>

  <dt class="col-sm-3">Email</dt>
  <dd class="col-sm-9">{{ $admin->email_a }}</dd>

</dl>
</div>
