<style>

  .boy{
    margin-right: 100px;
    margin-left: 105px;
    margin-top: 35px;

    width: 75%;

  }
</style>
<div class="boy">
<input type="hidden" name="id_cate" value="{{old('id_cate')?? $category->id_cate}}">
<div class="form-group">
  <label for="name_cate" class="font-weight-bold">Name</label>
  <input type="text" class="form-control" id="name_cate" name="name_cate"
         value="{{old('name_cate')?? $category->name_cate}}">

</div>

<div class="form-group">
  <label for="image_p" class="font-weight-bold">Image</label>
  <input type="file" name="image_cate" id="image_cate" value="{{old('image_cate')?? $category->image_cate}}">

</div>
</div>
