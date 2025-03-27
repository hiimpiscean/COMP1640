<style>
  /* Global Reset */
  *, *::before, *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body {
    background: #4e657a;
    color: #fff;
    font-family: 'Roboto', Helvetica, Arial, sans-serif;
  }

  /* Form Container */
  .form-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background: #50697f;
    border-radius: 8px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
  }

  /* Form Groups */
  .form-group {
    margin-bottom: 1rem;
  }

  .form-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 0.5rem;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #415a70;
    border-radius: 5px;
    background: #394e64;
    color: #fff;
    margin-bottom: 1rem;
  }

  /* Image Styling */
  .img {
    max-width: 300px;
    height: auto;
    display: block;
    border-radius: 8px;
    margin-top: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .form-container {
      width: 90%;
      padding: 15px;
    }
  }
</style>

<div class="form-container">
  <input type="hidden" name="id_p" value="{{ old('id_p') ?? $product->id_p }}">

  <div class="form-group">
    <label for="name_p" class="font-weight-bold">Name</label>
    <input type="text" class="form-control" id="name_p" name="name_p"
           value="{{ old('name_p') ?? $product->name_p }}">
  </div>

  <div class="form-group">
    <label for="image_p" class="font-weight-bold">Image</label>
    @if (!empty($product->image_p))
      <img class="img" src="{{ asset('images/handicraf/' . $product->image_p) }}" alt="Product Image">
    @else
      <img class="img" src="{{ asset('images/default-placeholder.png') }}" alt="No Image Available">
    @endif
  </div>

  <div class="form-group">
    <label for="image_p" class="font-weight-bold">Change Image</label>
    <input type="file" name="image_p" id="image_p" class="form-control-file">
  </div>

  <div class="form-group">
    <label for="price_p" class="font-weight-bold">Price</label>
    <input type="number" class="form-control" id="price_p" name="price_p" min="0"
           value="{{ old('price_p') ?? $product->price_p }}">
  </div>

  <div class="form-group">
    <label for="description_p" class="font-weight-bold">Description</label>
    <textarea class="form-control" id="description_p" name="description_p" rows="3">{{ old('description_p') ?? $product->description_p }}</textarea>
  </div>

  @php
    $cId = old('category') ?? $product->categoryid ?? null;
  @endphp
  <div class="form-group">
    <label for="category" class="font-weight-bold">Category</label>
    <select name="category" class="form-control" id="category">
      <option value="0">Choose category</option>
      @foreach($category as $c)
        <option value="{{ $c->id_cate }}" {{ ($cId != null && $c->id_cate == $cId) ? 'selected' : '' }}>
          {{ $c->name_cate }}
        </option>
      @endforeach
    </select>
  </div>
</div>
