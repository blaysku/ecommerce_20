<div class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="user-menu">
                    <ul>
                        <li><a href="#"><i class="fa fa-user"></i> {{ trans('front.account.my-account') }}</a></li>
                        <li><a href="#"><i class="fa fa-heart"></i> {{ trans('front.account.wishlist') }}</a></li>
                        <li><a href="#"><i class="fa fa-user"></i> {{ trans('front.cart.my-cart') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="header-right">
                    <ul class="list-unstyled list-inline">
                        <li class="dropdown dropdown-small">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><span class="key">{{ trans('front.language.language') }} :</span><span class="value"> {{ trans('front.language.english') }} </span><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">{{ trans('front.language.english') }}</a></li>
                                <li><a href="#">{{ trans('front.language.vietnamese') }}</a></li>
                            </ul>
                            @if (auth()->user())
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-user"></span> {{ auth()->user()->name }}<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('logout') }}" id="logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                <span class="fa fa-fw fa-power-off"></span>
                                                {{ trans('admin.main.logout') }}
                                            </a>
                                            {!! Form::open(['route' => 'logout', 'id' => 'logout-form', 'method' => 'POST']) !!}
                                            {!! Form::close() !!}
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li><a href="{{ route('login') }}"><i class="fa fa-user"></i> {{ trans('front.account.login') }}</a></li>
                            @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End header area -->
<div class="site-branding-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="logo">
                    <h1><a href="#">{!! trans('front.label.branch') !!}</a></h1>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="shopping-item">
                    <a href="{{ route('front.cart.index') }}">{{ trans('front.cart.cart') }} :
                    <span class="cart-amunt">{{ Format::currency(request()->session()->has('cart') ? request()->session()->get('cart')->totalPrice : 0) }}</span>
                        <i class="fa fa-shopping-cart"></i>
                        <span class="product-count">{{ request()->session()->has('cart') ? count(request()->session()->get('cart')->items) : 0 }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End site branding area -->
<div class="mainmenu-area">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">{{ trans('front.label.toggle') }}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">{{ trans('front.label.home') }}</a></li>
                    <li><a href="#">{{ trans('front.label.shop-page') }}</a></li>
                    @foreach ($categories as $category)
                        <li><a href="#">{{ $category->name }}</a></li>
                    @endforeach
                    <li><a href="#">{{ trans('front.cart.my-cart') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div> <!-- End mainmenu area -->
