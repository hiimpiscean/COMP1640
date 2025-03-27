@extends('masters.dashboardMaster')

@section('main')

    <style>

        .but {
            margin: 30px 20px 40px 280px;

        }

        .cancel {
            margin-left: 400px;
            margin-bottom: 20px;
        }

        .han {
            margin-top: 50px;
        }
    </style>

    <div class="container ">
        <h1 class="display-4 text-center han ">New Category</h1>

        @include('partials.errors')

        <form action="{{route('category.store')}}" method="post">
            @csrf
            @include('category.categoryFieldsNew')
            <button type="submit" class="btn btn-dark but">Submit</button>
            <a href="{{route('category.index')}}" class="btn btn-info cancel">Cancel</a>
        </form>
    </div>
@endsection
