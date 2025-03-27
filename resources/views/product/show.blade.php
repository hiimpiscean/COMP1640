@extends('masters.dashboardMaster')

@section('main')

    <style>

        .han {
            margin-top: 50px;
        }

        .cancel {
            margin-left: 800px;
        }
    </style>
    <div class="container">
        <h1 class="display-4 text-center han">Product Details</h1>
        @include('product.productDetails')

        <a type="button" href="{{route('product.index')}}" class="btn btn-info cancel">&lt;&lt;&nbsp;Back</a>
    </div>
@endsection
