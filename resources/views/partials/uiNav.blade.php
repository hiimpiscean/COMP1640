
<style>
  .bacColor{
    background-color: #fad6ba;
  }
  .font{
    font-family: Script;
  }

</style>

{{--//////////////////////////////////////////////////////--}}

<div class="container bacColor">
  <nav class="navbar navbar-expand-lg custom_nav-container ">
    <a class="navbar-brand" href="{{route('ui.index')}}" style="color: white " >
      <img src="{{asset('images/handicraf/logo1.png')}}" width=35" height="40" class="d-inline-block align-top" alt="">

      <span>ATN Shop
          </span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class=""> </span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav  mx-auto ">
        <li class="nav-item font">
          <a class="nav-link " href="{{route('ui.index')}}">Home
            <span class="sr-only"></span></a>
        </li>
        <li class="nav-item font">
          <a class="nav-link" href  ="{{route('ui.home')}}">Products</a>
        </li>
        <li class="nav-item font">
        </li>
        <li class="nav-item font">
          <a class="nav-link" href="{{route('ui.category')}}">Category</a>
        </li>
      </ul>
      <div class="user_option">
        <form class="form-inline" action="{{route('ui.search')}}" method="get">
          @csrf
          <div class="md-form my-0">
            <input class="form-control-sm" id="query" name="query" type="text" placeholder="Search" aria-label="Search">
          </div>
          <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
            <i class="fa fa-search" aria-hidden="true"></i>
          </button>
        </form>
        <a href="{{route('ui.create')}}" class="order_online">
          Sign Up
        </a>
      </div>
    </div>
  </nav>
</div>

{{--//////////////////////////////////////////////////////////--}}
