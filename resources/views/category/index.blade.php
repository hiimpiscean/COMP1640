@extends('masters.dashboardMaster')
@section('main')
<style>
  html {
    font-size: 16px;
    overflow-x: hidden;
  }
  body {
    font-family: Roboto, Helvetica, Arial, sans-serif;
    background-color: #4e657a;
    overflow-x: hidden;
  }
  a {
    transition: all 0.3s ease;
  }
  a:focus,
  a:hover {
    text-decoration: none;
  }
  button:focus {
    outline: 0;
  }


  .navbar .container {
    position: relative;
  }

  .tm-block-col {
    margin-bottom: 30px;
  }
  .tm-block {
    padding: 40px;
    -webkit-box-shadow: 1px 1px 5px 0 #455c71;
    -moz-box-shadow: 1px 1px 5px 0 #455c71;
    box-shadow: 1px 1px 5px 0 #455c71;
    min-height: 350px;
    height: 100%;
    max-height: 450px;
  }


  .nav-link > i {
    margin-bottom: 10px;
    margin-right: 0;
    font-size: 1.5rem;
  }

  .navbar-nav .active > .nav-link,
  .navbar-nav .nav-link.active {
    background-color: #f5a623;
    color: #fff;
  }
  .navbar-nav .nav-link.active i {
    color: #fff;
  }

  .navbar-nav a:hover,
  .navbar-nav a:hover i {
    color: #f5a623;
  }

  .tm-content-row {
    justify-content: space-between;
    margin-left: -20px;
    margin-right: -20px;
  }


  .table {
    background-color: #50697f;
    color: #fff;
    font-size: 85%;
    margin-bottom: 0;
  }
  thead {
    background-color: #486177;
    color: #fff;
  }
  .table thead th {
    border-bottom: 0;
  }



  .tm-avatar-container:hover .tm-avatar-delete-link {
    display: block;
  }

  .form-group label {
    color: #fff;
    margin-bottom: 10px;
  }

  .tm-list-group > li {
    list-style-type: none;
    position: relative;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 8px;
  }
  .tm-list-group > li:hover {
    color: #0266c4;
  }
  .tm-list-group > li:before {
    counter-increment: myOrderedListItemsCounter;
    content: counter(myOrderedListItemsCounter) ".";
    margin-right: 0.5em;
  }

  .tm-list > li {
    margin-bottom: 20px;
  }



  .table td,
  .table th {
    border-top: 1px solid #415a70;
    padding: 15px 25px;
    vertical-align: middle;
  }
  .tm-table-small td,
  .tm-table-small th {
    padding-left: 12px;
    padding-right: 12px;
  }
  .table-hover tbody tr {
    transition: all 0.2s ease;
  }
  .table-hover tbody tr:hover {
    color: #a0c0de;
  }
  .tm-bg-primary-dark {
    background-color: #435c70;
  }

  .page-item:first-child .page-link {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
  .page-item:last-child .page-link {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .page-item.active .page-link {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #000;
  }
  input[type="checkbox"] {
    cursor: pointer;
    -webkit-appearance: none;
    appearance: none;
    background-color: #394e64;
    background-position: center;
    border-radius: 50%;
    box-sizing: border-box;
    position: relative;
    box-sizing: content-box;
    width: 24px;
    height: 24px;
    transition: all 0.1s linear;
  }

  input[type="checkbox"]:focus {
    outline: 0 none;
    box-shadow: none;
  }
  .tm-block-products {
    min-height: 500px;
    margin-top: 60px;
    width: 1200px;


  }

  .tm-product-table-container {
    max-height: 465px;
    margin-bottom: 15px;
    overflow-y: scroll;
  }
  .tm-product-table tr {
    font-weight: 600;
  }

  .tm-product-delete-link {
    padding: 10px;
    border-radius: 50%;
    background-color: #394e64;
    display: inline-block;
    width: 40px;
    height: 40px;
    text-align: center;
  }
  .tm-product-delete-link:hover .tm-product-delete-icon {
    color: #6d8ca6;
  }



  .tm-product-img-edit i {
    display: none;
    position: absolute;
  }
  .tm-product-img-edit:hover i {
    display: block;
  }



  .navbar-toggler:hover .tm-nav-icon {
    color: #f5a623;
  }
  ::-webkit-scrollbar {
    width: 8px;
    height: 8px;
  }
  ::-webkit-scrollbar-track {
    background: #394f62;
  }
  ::-webkit-scrollbar-thumb {
    background: #6d8da6;
  }
  ::-webkit-scrollbar-thumb:hover {
    background: #8ab5d6;
  }

  .tm-footer-link {
    color: white;
  }

  .tm-footer-link:hover,
  .tm-footer-link:focus {
    color: #aacbea;
  }

  @media (min-width: 1200px) {
    .navbar-expand-xl .navbar-nav .nav-link {
      padding-left: 20px;
      padding-right: 20px;
    }
    .navbar-collapse {
      height: 100%;
    }
  }
  @media (min-width: 992px) {
    .navbar-expand-lg .navbar-nav .nav-link {
      padding: 15px 20px;
    }
  }
  @media (max-width: 1275px) and (min-width: 1200px) {
    .nav-item {
      margin-right: 15px;
    }
  }
  @media (max-width: 1350px) {
    .nav-item {
      margin-right: 1px;
    }
  }
  @media (max-width: 1199px) {
    .tm-col-big,
    .tm-col-small {
      width: 49.65%;
    }
    .navbar-collapse {
      padding: 0;
      box-shadow: rgba(255, 255, 255, 0.1) 0 1px 1px 1px;
      position: absolute;
      top: 72px;
      right: 20px;
      width: 200px;
      z-index: 1000;
    }
    .dropdown-menu {
      text-align: center;
    }
    .nav-link {
      color: #fff;
      background-color: #567086;
      padding: 15px;
      flex-direction: row;
    }
    .nav-link > i {
      font-size: 1rem;
      margin-right: 10px;
      margin-bottom: 0;
    }
    .nav-item {
      margin-right: 0;
    }
    .tm-block-taller {
      max-height: 520px;
    }
  }
  @media (max-width: 1199.98px) {
    .navbar-expand-xl > .container,
    .navbar-expand-xl > .container-fluid {
      padding-left: 15px;
      padding-right: 15px;
    }
    .navbar-collapse {
      right: 15px;
    }
  }
  @media (max-width: 991px) {
    .tm-col-big,
    .tm-col-small {
      width: 100%;
      min-height: 383px;
      height: auto;
    }
    .tm-block {
      padding: 30px;
    }
  }
  @media (max-width: 767px) {
    .tm-col-account-settings,
    .tm-col-avatar {
      width: 100%;
      max-width: 100%;
    }
    .tm-block-avatar {
      display: flex;
      flex-direction: column;
    }
    .tm-avatar {
      align-self: center;
    }
    .tm-hide-sm {
      display: none;
    }
  }
  @media (max-width: 633px) {
    .page-item {
      margin-top: 10px;
    }
    .custom-select {
      background-position: 96%;
    }
  }
  @media (max-width: 574px) {
    .navbar-collapse {
      top: 47px;
    }
    .navbar {
      height: 50px;
    }
    .tm-site-title {
      font-size: 1.4rem;
      margin-left: 7px;
    }
    .tm-site-icon {
      font-size: 2em;
    }
  }
  @media (max-width: 480px) {
    .tm-mt-big {
      margin-top: 45px;
    }
    .tm-mb-big {
      margin-bottom: 45px;
    }
    #barChart,
    #lineChart {
      max-height: 350px;
    }
  }


  .header__navbar-item--has-qr .header__qr{
    position: absolute;
  }
  .header__navbar-item--has-qr:hover .header__qr{
    display: block;
  }



</style>


<div class="container mt-5">
  <div class="row tm-content-row">
    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 tm-block-col">
      <div class="tm-bg-primary-dark tm-block tm-block-products">
        @include('category.sessionmessage')
        <div class="tm-product-table-container">
          <table class="table table-hover tm-table-small tm-product-table">
            <thead>
            <tr>

              <th scope="col" class="" >Name</th>
              <th scope="col" class="">Image</th>

            </tr>
            </thead>
            <tbody>

            {{--       ///////////////////////////////////////////////////////////////////////--}}
            @foreach($category as $c)
              <tr>

                <td class=" "  >{{$c->name_cate}}</td>

                <td>
                  <a href="{{route('category.show', ['id_cate' =>$c->id_cate])}}">
                    <img src="{{asset('images/category/'. $c->image_cate)}}" alt="" style="width: 30%">
                  </a>
                </td>
                <td class="but"><a type="button" class="tm-product-delete-link "
                                   href="{{route('category.show', ['id_cate' => $c->id_cate])}}"
                  ><i class="bi bi-eye"></i></a>
                </td>
                <td  class="but" ><a type="button" class="tm-product-delete-link "
                                     href="{{route('category.edit', ['id_cate' => $c->id_cate])}}"
                  ><i class="bi bi-plus-square"></i></a>
                </td>
                <td class="but">

                  <a type="button" class="tm-product-delete-link"
                     href="{{route('category.confirm', ['id_cate' => $c->id_cate])}}"
                  ><i class="bi bi-trash3-fill"></i></a></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>
</div>
</div>



{{--  /////////////////////////////////////////--}}
@endsection

@section('script')
@endsection
