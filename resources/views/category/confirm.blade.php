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
        <h1 class="display-4 text-center han">Are you sure you want to delete?</h1>
        @include('category.categoryDetails')

        <form action="{{route('category.destroy', ['id_cate' =>$category->id_cate])}}" method="post">
            @csrf
            <input type="hidden" name="id_cate" value="{{$category->id_cate}}">
            <button type="submit" class="btn btn-danger but">Delete</button>
            <a href="{{route('category.index')}}" class="btn btn-info cancel">Cancel</a>
        </form>
    </div>
@endsection
