@extends('front.template')
@section('title', trans('front.label.checkout'))
@section('css')
    @parent
    {!! HTML::style('/bower_components/jquery.rateit/scripts/rateit.css') !!}
@endsection
@section('main')
    @include('front.includes.title', ['title' => trans('front.label.checkout')])
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-sidebar">
                            <h2 class="sidebar-title">{{ trans('front.label.trending') }}</h2>
                            @foreach ($trendingProducts as $trendingProduct)
                                <div class="thubmnail-recent">
                                    <img src="{{ Storage::url($trendingProduct->image) }}" class="recent-thumb" alt="{{ $trendingProduct->name }}">
                                    <h2><a href="{{ route('front.product.show', $trendingProduct->id) }}">{{ $trendingProduct->name }}</a></h2>
                                    <div class="rateit" data-rateit-value="{{ $trendingProduct->avg_rating }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                    <div class="product-sidebar-price">
                                        <ins>{{ Format::currency($trendingProduct->price) }}</ins>
                                    </div>
                                </div>
                            @endforeach
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            @if (!Auth::check())
                                <div class="woocommerce-info">{{ trans('front.cart.login-to-order') }}</div>
                            @else
                                <div id="customer_details" class="col2-set">
                                    <div class="col-1">
                                        <div class="woocommerce-billing-fields">
                                            <h3>{{ trans('front.cart.bill-detail') }}</h3>
                                            <p class="form-row form-row-wide">
                                                <label>{{ trans('admin.user.name') }}</label>
                                                <mark>{{ Auth::user()->name }}</mark>
                                            </p>
                                            <p class="form-row form-row-wide">
                                                <label>{{ trans('admin.user.email') }}</label>
                                                <mark>{{ Auth::user()->email }}</mark>
                                            </p>
                                            <p class="form-row form-row-wide">
                                                <label>{{ trans('admin.user.gender') }}</label>
                                                <mark>
                                                    {{ Auth::user()->gender == config('setting.female') ? trans('admin.user.female')
                                                        : (Auth::user()->gender == config('setting.male') ? trans('admin.user.male') : trans('admin.user.other') ) }}
                                                </mark>
                                            </p>
                                            <p class="form-row form-row-wide">
                                                <label>{{ trans('admin.user.phone') }}</label>
                                                <mark>{{ Auth::user()->phone }}</mark>
                                            </p>
                                            <p class="form-row form-row-wide">
                                                <label>{{ trans('admin.user.address') }}</label>
                                                <mark>{{ Auth::user()->address }}</mark>
                                            </p>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="woocommerce-shipping-fields">
                                            <h3 id="ship-to-different-address">
                                                <label>{{ trans('front.cart.diff-address') }}</label>
                                                {!! Form::checkbox(null, null, null, ['class' => 'input-checkbox', 'id' => 'diff-check']) !!}
                                            </h3>
                                            {!! Form::open(['id' => 'customer-info']) !!}
                                                <div class="form-group customer-name">
                                                    {!! Form::label('name', trans('admin.user.name'), ['class' => 'control-label']) !!}
                                                    {!! Form::text('name', null, ['class' => 'input-text form-control', 'disabled']) !!}
                                                    <small class="help-block"></small>
                                                </div>
                                                <div class="form-group customer-phone">
                                                    {!! Form::label('phone', trans('admin.user.phone'), ['class' => 'control-label']) !!}
                                                    {!! Form::text('phone', null, ['class' => 'input-text form-control', 'disabled']) !!}
                                                    <small class="help-block"></small>
                                                </div>
                                                <div class="form-group customer-address">
                                                    {!! Form::label('address', trans('admin.user.address'), ['class' => 'control-label']) !!}
                                                    {!! Form::text('address', null, ['class' => 'input-text form-control', 'disabled']) !!}
                                                    <small class="help-block"></small>
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (!$cart || !$cart->items)
                                <h3 class="text-center">({{ trans('front.cart.empty') }})</h3>
                            @else
                                <h3 id="order_review_heading">{{ trans('front.cart.your-order') }}</h3>
                                <div id="order_review" style="position: relative;">
                                    <table class="shop_table">
                                        <thead>
                                            <tr>
                                                <th class="product-name">{{ trans('front.cart.product') }}</th>
                                                <th class="product-total">{{ trans('front.cart.total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart->items as $item)
                                            <tr class="cart_item">
                                                <td class="product-name">
                                                    {{ $item['item']->name }} <strong class="product-quantity">× {{ $item['quantity'] }}</strong> </td>
                                                <td class="product-total">
                                                    <span class="amount">{{ Format::currency($item['price']) }}</span> </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>{{ trans('front.cart.sub-total') }}</th>
                                                <td><span class="amount">{{ Format::currency($cart->totalPrice) }}</span>
                                                </td>
                                            </tr>
                                            <tr class="shipping">
                                                <th>{{ trans('front.cart.shipping') }}</th>
                                                <td>
                                                    {{ trans('front.service.freeship') }}
                                                </td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>{{ trans('front.cart.order-total') }}</th>
                                                <td><strong><span class="amount">{{ Format::currency($cart->totalPrice) }}</span></strong> </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div id="payment">
                                        <ul class="payment_methods methods">
                                            <li class="payment_method_bacs">
                                                {!! Form::radio('payment_method', 'basic', true, ['class' => 'input-radio']) !!}
                                                <label>{{ trans('front.cart.bank-transfer') }}</label>
                                                <div class="payment_box payment_method_bacs">
                                                    <p>{{ trans('front.cart.bank-msg') }}</p>
                                                </div>
                                            </li>
                                            <li class="payment_method_paypal">
                                                {!! Form::radio('payment_method', 'paypal', false, ['disabled', 'class' => 'input-radio']) !!}
                                                <label>
                                                    {{ trans('front.cart.paypal') }}
                                                    <img alt="{{ trans('front.cart.paypal') }}" src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_mc_vs_ms_ae_UK.png">
                                                </label>
                                            </li>
                                        </ul>
                                        @if (Auth::check())
                                        <div class="form-row place-order">
                                            {!! Form::submit(trans('front.cart.place-order'), ['class' => 'button alt', 'id' => 'place_order']) !!}
                                        </div>
                                        @endif
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @parent
    <script>
        var info = {
            checkoutUrl: '{{ action('Front\CartController@checkout') }}',
            redirectUrl: '{{ route('index')}}',
            successMsg: '{{ trans('front.cart.placed') }}',
        }
    </script>
    {!! HTML::script('/bower_components/jquery.rateit/scripts/jquery.rateit.min.js') !!}
    {{ HTML::script('front/js/checkout.js') }}
@endsection
