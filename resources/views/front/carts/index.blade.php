@extends('front.template')
@section('title', trans('front.label.shop-page'))
@section('main')
    @include('front.includes.title', ['title' => 'Shopping Cart'])
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if (!$cart || !$cart->items)
                        <h2 class="text-center">{{ trans('front.cart.empty') }}</h2>
                    @else
                        <div class="product-content-right">
                            <div class="woocommerce">
                                <div class="table-responsive">
                                    <table cellspacing="0" class="shop_table cart table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="product-remove">&nbsp;</th>
                                                <th class="product-thumbnail">&nbsp;</th>
                                                <th class="product-name">{{ trans('front.cart.product') }}</th>
                                                <th class="product-price">{{ trans('front.filter.order-price') }}</th>
                                                <th class="product-quantity">{{ trans('front.cart.quantity') }}</th>
                                                <th class="product-subtotal">{{ trans('front.cart.total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($cart)
                                                @foreach ($cart->items as $item)
                                                    <tr class="cart_item">
                                                        <td class="product-remove">
                                                            <a title="Remove this item" class="remove" product-id="{{ $item['item']->id }}">×</a>
                                                        </td>
                                                        <td class="product-thumbnail">
                                                            <img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="{{ Storage::url($item['item']->image) }}">
                                                        </td>
                                                        <td class="product-name">
                                                            <a href="{{ route('front.product.show', $item['item']->id) }}">{{ $item['item']->name }}</a>
                                                        </td>
                                                        <td class="product-price">
                                                            <span class="amount" data-price="{{ $item['item']->price }}">{{ Format::currency($item['item']->price) }}</span>
                                                        </td>
                                                        <td class="product-quantity">
                                                            {!! Form::button('<span class="glyphicon glyphicon-minus"></span>', ['class'=>'btn btn-default btn-number', 'data-type' => 'minus', 'data-field' => 'quantity']) !!}
                                                            {!! Form::text('quantity', $item['quantity'], ['size' => 2, 'class' => 'input-number input-text', 'min' => 1, 'max' => $item['item']->quantity]) !!}
                                                            {!! Form::button('<span class="glyphicon glyphicon-plus"></span>', ['class'=>'btn btn-default btn-number', 'data-type' => 'plus', 'data-field' => 'quantity']) !!}
                                                        </td>
                                                        <td class="product-subtotal">
                                                            <span class="amount">{{ Format::currency($item['price']) }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td class="actions" colspan="6">
                                                    {!! Form::submit(trans('front.cart.update'), ['class' => 'button', 'id' => 'update-cart', 'disabled']) !!}
                                                    <a href="{{ route('front.cart.checkout') }}">
                                                        {!! Form::submit(trans('front.cart.checkout'), ['class' => 'checkout-button button alt wc-forward']) !!}
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cart-collaterals">
                                    <div class="cart_totals ">
                                        <h2>{{ trans('front.cart.cart-total') }}</h2>
                                        <table cellspacing="0">
                                            <tbody>
                                                <tr class="cart-subtotal">
                                                    <th>{{ trans('front.cart.sub-total') }}l</th>
                                                    <td>
                                                        <span class="amount" id="sub-total">
                                                            {{ Format::currency(request()->session()->has('cart') ? request()->session()->get('cart')->totalPrice : 0) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="shipping">
                                                    <th>{{ trans('front.cart.shipping') }}</th>
                                                    <td>{{ trans('front.service.freeship') }}</td>
                                                </tr>
                                                <tr class="order-total">
                                                    <th>{{ trans('front.cart.order-total') }}</th>
                                                    <td>
                                                        <strong>
                                                            <span class="amount" id="total">
                                                                {{ Format::currency(request()->session()->has('cart') ? request()->session()->get('cart')->totalPrice : 0) }}
                                                            </span>
                                                        </strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @parent
    {{ HTML::script('bower_components/ckeditor/ckeditor.js') }}
    <script>
        var info = {
            destroyUrl: '{{ route('front.cart.destroy', '') }}',
            updateUrl: '{{ route('front.cart.update') }}',
            currency_unit: {{ config('setting.currency_unit') }},
            currency: '{{ config('setting.currency') }}',
            updated: '{{ trans('front.cart.updated') }}',
            yes: '{{ trans('admin.main.yes') }}',
            no: '{{ trans('admin.main.no') }}',
            remove: '{{ trans('front.cart.remove') }}',
        }
    </script>
        {{ HTML::script('front/js/bootstrap-minus-plus.js') }}
        {{ HTML::script('front/js/cart.js') }}
@endsection
