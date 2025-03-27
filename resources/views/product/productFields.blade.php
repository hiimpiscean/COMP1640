
  <style>

  .boy{
    margin-right: 100px;
    margin-left: 105px;
    margin-top: 10px;

    width: 75%;

  }
  .img{
    max-width: 350px;
    max-height: 350px;
  }
</style>


<div class="boy">
<input type="hidden" name="id_p" value="{{old('id_p')?? $product->id_p}}">
<div class="form-group ">
  <label for="name_p" class="font-weight-bold">Name</label>
  <input type="text" class="form-control" id="name_p" name="name_p"
         value="{{old('name_p')?? $product->name_p}}">
</div>
<div class="form-group">
  <label for="image_p" class="font-weight-bold">Image</label>
  <img class="col-sm-9 img" src="{{asset('images/handicraf/'. $product->image_p)}}"   alt="" >
</div>
<div class="form-group">
  <label for="image_p" class="font-weight-bold"> Change Image</label>
  <input type="file" name="image_p" id="image_p" value="{{old('image_p')?? $product->image_p}}">
</div>
<div class="form-group">
  <label for="price_p" class="font-weight-bold">Price</label>
  <input type="number" class="form-control" id="price_p" name="price_p" min="0" value="{{old('price_p')?? $product->price_p}}">
</div>
<div class="form-group">
  <label for="size_p" class="font-weight-bold">Size</label>
  <input type="text" class="form-control" id="size_p" name="size_p" min="0" value="{{old('size_p')?? $product->size_p}}">
</div>
<div class="form-group">
  <label for="description_p" class="font-weight-bold">Description</label>
  <input type="text" class="form-control" id="description_p" name="description_p" min="0" value="{{old('description_p')?? $product->description_p}}">
</div>
@php
  $cId = old('category') ?? $product->categoryid?? null;

@endphp
<div class="form-group">
  <label for="category" class="font-weight-bold">Category</label>
  <select name="category" class="form-control" id="category" >
    <option value="0">Choose category</option>
    @foreach($category as $c)
      <option value="{{ $c->id_cate }}"
        {{ ($cId != null && $c->id_cate == $cId) ? 'selected' : '' }}
      >{{ $c->name_cate }}</option>
    @endforeach
  </select>
</div>
</div>
