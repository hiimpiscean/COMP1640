<style>

  .error{
    width: 72%;
    margin-left: 120px;
  }
</style>

@if(count($errors->all()))
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-danger error">
        <ul>
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
@endif
