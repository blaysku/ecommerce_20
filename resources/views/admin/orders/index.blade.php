@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.order.dashboard'),
        'icon' => 'cart-plus',
        'fil' => trans('admin.order.order'),
    ])
    @include('admin.partials.message')
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ trans('admin.order.user') }}</th>
                    <th>{{ trans('admin.order.total-price') }}</th>
                    <th>{{ trans('admin.order.total-item') }}</th>
                    <th>{{ trans('admin.order.status') }}</th>
                    <th>{{ trans('admin.order.success') }}?</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr {!! ($order->status == config('setting.done_order')) ? 'class="success"' : ($order->status == config('setting.cancel_order') ? 'class="warning"' : '') !!}>
                        <td class="text-primary"><strong>{{ $order->user->name }}</strong></td>
                        <td>{{ Format::currency($order->total_price) }}</td>
                        <td>{{ $order->orderItems->count() }}</td>
                        <td class="status">{{ ($order->status == config('setting.done_order')) ? trans('admin.order.status-done') : (($order->status) == config('setting.cancel_order') ? trans('admin.order.status-cancel') : trans('admin.order.status-waiting'))}}</td>
                        <td>{!! Form::checkbox('status', $order->id, $order->status, [($order->status == config('setting.cancel_order') ? 'disabled' : '')]) !!}</td>
                        <td>{!! link_to_route('order.show', trans('admin.user.see'), [$order->id], ['class' => 'btn btn-success btn-block']) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pull-right link">{!! $orders->links() !!}</div>
@endsection
@section('js')
    @parent
    {{ HTML::script('/js/order.js') }}
    <script>
        var data = {
            url: '{!! route('order.status', '') !!}',
            fail: '{{ trans('admin.user.fail') }}',
            waiting: '{{ trans('admin.order.status-waiting') }}',
            done: '{{ trans('admin.order.status-done') }}',
        };
    </script>
@endsection
