<style>
  .boy{
    margin-right: 100px;
    margin-left: 150px;
    margin-top: 10px;
    width: 85%;

  }
  img{
    max-width: 400px;
    max-height: 400px;
  }
</style>


<div class="boy">
<dl class="row">
  <dt class="col-sm-3">Name</dt>
  <dd class="col-sm-9">{{ $product->name_p }}</dd>

  <dt class="col-sm-3">Image</dt>
<dd class="col-sm-9" >  <img src="{{asset('images/handicraf/'. $product->image_p)}}"  alt="" >
</dd>
  <dt class="col-sm-3">Price</dt>
  <dd class="col-sm-9">VND {{$product->price_p }}</dd>

  <dt class="col-sm-3">Description</dt>
  <dd class="col-sm-9">{{$product->description_p }}</dd>

  <dt class="col-sm-3">Category</dt>
  <dd class="col-sm-9">{{$category->name_cate }}</dd>

</dl>
</div>
