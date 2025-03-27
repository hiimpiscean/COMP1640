<style>


  .boy{
    margin-right: 100px;
    margin-left: 150px;
    margin-top: 10px;

    width: 85%;

  }


</style>


  <div class="boy">

<dl class="row">

  <dt class="col-sm-3">Name</dt>
  <dd class="col-sm-9">{{ $category->name_cate }}</dd>



  <dt class="col-sm-3">Image</dt>

<dd class="col-sm-9">  <img class="col-sm-9 " src="{{asset('images/category/'. $category->image_cate)}}" width="80" height="340" alt="" >
</dd>

</dl>
  </div>
