<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ trans('front.label.title') }}</title>
</head>
<body>
    <div class="container">
        <div class="content">
            <h1 align="center">{!! trans('front.label.branch') !!}</h1>
            <p align="center">{{ trans('front.cart.mail-sub-title') }}</p>
            <h2 align="center">{{ trans('front.cart.bill-detail') }}</h2>
            <table align="center">
                <tr>
                    <th scope="row">
                        <div align="right">{{ trans('admin.order.customer-name') }}:</div>
                    </th>
                    <td>
                        <div align="left">{{ $order->name or Auth::user()->name }}</div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <div align="right">{{ trans('admin.order.customer-phone') }}:</div>
                    </th>
                    <td>{{ $order->phone or Auth::user()->phone }}</td>
                </tr>
                <tr>
                    <th scope="row">
                        <div align="right">{{ trans('admin.order.customer-address') }}:</div>
                    </th>
                    <td>
                        <div align="left">{{ $order->address or Auth::user()->address }}</div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <div align="right">{{ trans('front.cart.shipping') }}:</div>
                    </th>
                    <td>
                        <div align="left">{{ trans('front.service.freeship') }}</div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <div align="right">{{ trans('front.cart.order-total') }}:</div>
                    </th>
                    <td>
                        <div align="left">{{ Format::currency($order->total_price) }}</div>
                    </td>
                </tr>
            </table>
            <h2 align="center">{{ trans('admin.main.order_items') }}</h2>
            <table border="1" align="center">
                <tr>
                    <th scope="col">{{ trans('front.cart.product') }}</th>
                    <th scope="col">{{ trans('front.filter.order-price') }}</th>
                    <th scope="col">{{ trans('front.cart.quantity') }}</th>
                    <th scope="col">{{ trans('front.cart.total') }}</th>
                </tr>
                @foreach ($order->orderItems as $item)
                <tr>
                    <td>
                        <div align="center">{{ $item->product->name }}</div>
                    </td>
                    <td>
                        <div align="center">{{ Format::currency($item->product->price) }}</div>
                    </td>
                    <td>
                        <div align="center">{{ $item->quantity }}</div>
                    </td>
                    <td>
                        <div align="center">{{ Format::currency($item->price) }}</div>
                    </td>
                </tr>
                @endforeach
            </table>
            <p align="center"><a href="{{ route('front.order.show', $order->id) }}">{{ trans('front.cart.order-url') }}</a></p>
            <p align="center">{!! trans('front.label.copyright') !!}</p>
        </div>
    </div>
</body>
</html>
