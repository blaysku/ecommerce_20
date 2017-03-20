@extends('front.template')
@section('title', trans('admin.order.detail'))
@section('main')
    @include('front.includes.title', ['title' => trans('admin.order.detail')])
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            <div class="table-responsive">
                                <table cellspacing="0" class="shop_table cart table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">&nbsp;</th>
                                            <th class="product-name">{{ trans('front.cart.product') }}</th>
                                            <th class="product-price">{{ trans('front.filter.order-price') }}</th>
                                            <th class="product-quantity">{{ trans('front.cart.quantity') }}</th>
                                            <th class="product-subtotal">{{ trans('front.cart.total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $item)
                                            <tr class="cart_item">
                                                <td class="product-thumbnail">
                                                    <img width="145" height="145" alt="" class="shop_thumbnail" src="{{ Storage::url($item->product->image) }}">
                                                </td>
                                                <td class="product-name">
                                                    <a href="{{ route('front.product.show', $item->product->id) }}">{{ $item->product->name }}</a>
                                                </td>
                                                <td class="product-price">
                                                    <span class="amount">{{ Format::currency($item->product->price) }}</span>
                                                </td>
                                                <td class="product-quantity">
                                                    <span class="amount">{{ $item->quantity }}</span>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span class="amount">{{ Format::currency($item->price) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-collaterals">
                                <div class="cart_totals pull-left">
                                    <table cellspacing="0">
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <th>{{ trans('front.cart.sub-total') }}l</th>
                                                <td>
                                                    <span class="amount" id="sub-total">
                                                        {{ Format::currency($order->total_price) }}
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
                                                            {{ Format::currency($order->total_price) }}
                                                        </span>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cart_totals">
                                    <table cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <th>{{ trans('admin.order.customer-name') }}</th>
                                                <td>{{ $order->name ?: $order->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('admin.order.customer-phone') }}</th>
                                                <td>{{ $order->phone ?: $order->user->phone }}</td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('admin.order.customer-address') }}</th>
                                                <td>{{ $order->address ?: $order->user->address}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('admin.order.status') }}</th>
                                                <td>
                                                    {{ ($order->status == config('setting.done_order')) ? trans('admin.order.status-done')
                                                        : (($order->status) == config('setting.cancel_order') ? trans('admin.order.status-cancel') : trans('admin.order.status-waiting'))}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('admin.order.created_at') }}</th>
                                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
