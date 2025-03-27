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
        <h1 class="display-4 text-center han">Update An Existing Customer</h1>


        @include('partials.errors')

        <form action="{{route('customer.update', ['id_c' => old('id_c')?? $customer->id_c])}}" method="post">
            @csrf
            @include('customer.customerFields')

            <button type="submit" class="btn btn-dark but">Submit</button>
            <a href="{{route('customer.index')}}" class="btn btn-info cancel">Cancel</a>
        </form>
    </div>
@endsection
