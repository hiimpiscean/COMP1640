@extends('masters.dashboardMaster')

@section('main')

  <style>

    .but {
      margin: 30px 20px 40px 280px;
    }

    .cancel {
      margin-left: 400px;
    }

    .han {
      margin-top: 50px;
    }
  </style>
  <div class="container">
    <h1 class="display-4  text-center han ">Update Product</h1>
    @include('partials.errors')
    <form action="{{route('product.update', ['id_p' => old('id_p')?? $product->id_p])}}" method="post">
      @csrf
      @include('product.productFields')
      <div class="but">
        <button type="submit" class="btn btn-dark">Submit</button>
        <a href="{{route('product.index')}}" class="btn btn-info cancel">Cancel</a>
      </div>
    </form>
  </div>
@endsection
