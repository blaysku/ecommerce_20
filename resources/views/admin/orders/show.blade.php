@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.order.detail'),
        'icon' => 'cart-plus',
        'fil' => link_to_route('order.index', trans('admin.order.order')) . ' / ' . trans('admin.order.detail'),
    ])
    @include('admin.partials.message')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>{{ trans('admin.order.user-name') }}</th>
                            <td>{{ $order->user->name }}</th>
                        </tr>
                        <tr>
                            <th>{{ trans('admin.order.customer-name') }}</th>
                            <td>{{ $order->name or $order->user->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('admin.order.customer-phone') }}</th>
                            <td>{{ $order->phone or $order->user->phone}}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('admin.order.customer-address') }}</th>
                            <td>{{ $order->address or $order->user->address }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('admin.order.status') }}</th>
                            <td>{{ ($order->status == config('setting.done_order')) ? trans('admin.order.status-done') : (($order->status) == config('setting.cancel_order') ? trans('admin.order.status-cancel') : trans('admin.order.status-waiting'))}}</td>
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
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ trans('admin.product.image') }}</th>
                            <th>{{ trans('admin.product.name') }}</th>
                            <th>{{ trans('admin.product.category') }}</th>
                            <th>{{ trans('admin.product.price') }}</th>
                            <th>{{ trans('admin.product.quantity') }}</th>
                            <th>{{ trans('admin.order.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                               <td class="image">
                                    <img src="{!! Storage::url($item->product->image) !!}" class="img-responsive img-item" alt="{!! $item->product->name !!}">
                                </td>
                                <td class="text-primary"><strong>{{ $item->product->name }}</strong></td>
                                <td>{{ $item->product->category->name  }}</td>
                                <td>{{ Format::currency($item->price) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ Format::currency($item->price * $item->quantity) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"></td>
                            <th>{{ trans('admin.order.total') }}</th>
                            <td>{{ Format::currency($order->total_price) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @parent
    {{ HTML::script('/js/product.js') }}
    <script>
        var data = {
            url: '{!! route('product.trending', '') !!}',
            fail: '{{ trans('admin.user.fail') }}',
            yes: '{!! trans('admin.main.yes') !!}',
            no: '{!! trans('admin.main.no') !!}',
        };
    </script>
@endsection
