@extends('masters.uiMaster')

@section('main')
    <style>
        .view {
            margin-bottom: 60px;

        }

        .size {
            width: 70%;
        }

        .polaroid {
            position: relative;
            height: 400px;
        }

        .test {
            position: relative;
            margin-left: 40px;
        }

        .polaroid img {
            border: 10px solid #fff;
            -webkit-box-shadow: 3px 3px 3px #777;
            -moz-box-shadow: 3px 3px 3px #777;
            box-shadow: 3px 3px 3px #777;
        }

        .polaroid p {
            position: absolute;
            text-align: center;
            width: 100%;
            bottom: 0px;
            font: 400 18px/1 'Kaushan Script', cursive;
            color: #888;
        }
    </style>

    <div class="container ">


        <div class="heading_container heading_center pa"
             style="margin-bottom: 1rem !important; margin-top: 2rem!important">
            <h1>
                Car details
            </h1>
        </div>
        <div class=" d-flex justify-content-center">
            <div class="polaroid my-3">
                <img class=" polaroid" src="{{asset('images/handicraf/'. $product->image_p)}}" alt="">
            </div>

            <div class="test"> {{--ok roi day--}}
                <h3 class="my-3">Product name</h3>
                <p>{{$product->name_p}}</p>
                <h3 class="my-3">About this product</h3>
                <p>{{$product->description_p}}</p>
                <h3 class="my-3">Size</h3>
                <ul>
                    <li>{{$product->size_p}}</li>
                </ul>
                <div><h3>Price</h3></div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>VND {{$product->price_p}}</strong>
                    </div>
                    <div class="col-md-8">
                        <a type="button" href="shoppingbasket.html" data-toggle="modal" data-target="#addToBasketModal"
                           class="btn btn-success float-right">
                            Buy now
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="view">

    </div>
    {{--  ////////////////////////////////////////////////--}}
@endsection

@section('other')



@endsection
