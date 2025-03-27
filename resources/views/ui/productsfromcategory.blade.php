@extends('masters.uiMaster')

@section('main')

    <style>
        .pa {
            margin-top: 50px;
        }

        .view {
            margin-bottom: 30px;

        }

        .margin {
            margin-right: 5px;
        }

        .flexitem {
            justify-content: flex-start;
            flex-direction: row;
        }

    </style>
    {{--/////////////////////////////////////////////////////////////////////--}}
    <body class="sub_page">
    <section class="food_section ">
        <div class="container">
          <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active" data-interval="10000">
                <div class="container">
                  <div class="carousel-caption">
                    <h1>Welcome to ATN Shop</h1>
                    <p></p>
                    <p></p>
                  </div>
                </div>

                <img src="{{asset('images/images/tomica.jpg')}}"  class="d-block w-100" alt="...">

              </div>
            </div>
          </div>

            {{--      ///////////////////////////////--}}

            <?php $cat_lower = strtolower($category->name_cate); ?>
            <div class="heading_container heading_center pa">
                <h1>
                    Products from <?php echo $cat_lower; ?>
                </h1>
            </div>


            <div class="filters-content flexitem">
                <div class="row grid">

                    @include('partials.productLoop')

                </div>
            </div>
            <div class="btn-box view">
            </div>
        </div>
    </section>
    </body>








    {{--  /////////////////////////////////////////////////////////////////////--}}





@endsection

@section('script')
@endsection
