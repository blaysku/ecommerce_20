<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">{{ trans('admin.main.toggle-navi') }}</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="{{ route('admin.index') }}" class="navbar-brand">{{ trans('admin.main.administration') }}</a>
    </div>
    <!-- Top menu -->
    <ul class="nav navbar-right top-nav">
        <li><a href="{{ route('index') }}">{{ trans('admin.main.home') }}</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-user"></span> {{ auth()->user()->name }}<b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('logout') }}" id="logout">
                        <span class="fa fa-fw fa-power-off"></span>
                        {{ trans('admin.main.logout') }}
                    </a>
                    {!! Form::open(['route' => 'logout', 'id' => 'logout-form']) !!}
                    {!! Form::close() !!}
                </li>
            </ul>
        </li>
    </ul>
    <!-- Side menu -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li {!! CheckPath::classActiveSegment(2, '') !!}>
                <a href="{{ route('admin.index') }}"><span class="fa fa-fw fa-dashboard"></span> {{ trans('admin.main.dashboard') }}</a>
            </li>
            <li {!! CheckPath::classActiveSegment(2, 'user') !!}>
                <a href="#" data-toggle="collapse" data-target="#usermenu"><span class="fa fa-fw fa-user"></span> {{ trans('admin.main.users') }} <span class="fa fa-fw fa-caret-down"></span></a>
                <ul id="usermenu" class="collapse">
                    <li><a href="{{ route('user.index') }}">{{ trans('admin.main.see-all') }}</a></li>
                    <li><a href="{{ route('user.create') }}">{{ trans('admin.main.add') }}</a></li>
                </ul>
            </li>
            <li {!! CheckPath::classActiveSegment(2, 'category') !!}>
                <a href="#" data-toggle="collapse" data-target="#catmenu"><span class="fa fa-fw fa-folder"></span> {{ trans('admin.main.categories') }} <span class="fa fa-fw fa-caret-down"></span></a>
                <ul id="catmenu" class="collapse">
                    <li><a href="{{ route('category.index') }}">{{ trans('admin.main.see-all') }}</a></li>
                </ul>
            </li>
            <li {!! CheckPath::classActiveSegment(2, 'product') !!}>
                <a href="#" data-toggle="collapse" data-target="#productmenu"><span class="fa fa-fw fa-shopping-cart"></span> {{ trans('admin.main.products') }} <span class="fa fa-fw fa-caret-down"></span></a>
                <ul id="productmenu" class="collapse">
                    <li><a href="{{ route('product.index') }}">{{ trans('admin.main.see-all') }}</a></li>
                    <li><a href="{{ route('product.create') }}">{{ trans('admin.main.add') }}</a></li>
                </ul>
            </li>
            <li {!! CheckPath::classActiveSegment(2, 'order') !!}>
                <a href="#" data-toggle="collapse" data-target="#ordermenu"><span class="fa fa-fw fa-cart-plus"></span> {{ trans('admin.main.orders') }} <span class="fa fa-fw fa-caret-down"></span></a>
                <ul id="ordermenu" class="collapse">
                    <li><a href="{{ route('order.index') }}">{{ trans('admin.main.see-all') }}</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('suggest.index') }}"><span class="fa fa-fw fa-lightbulb-o"></span> {{ trans('admin.main.suggests') }}</a>
            </li>
        </ul>
    </div>
</nav>
