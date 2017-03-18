@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.order.dashboard'),
        'icon' => 'cart-plus',
        'fil' => trans('admin.order.order'),
    ])
    @include('admin.partials.message')
    <div class="col-lg-12 well filter">
        {!! Form::open(['method' => 'GET']) !!}
            <div class="form-group col-md-3">
                {!! Form::text('keyword', request()->get('keyword', null), [
                    'class' => 'form-control',
                    'placeholder' => trans('admin.filter.keyword')
                ]) !!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('status', [
                    null => '--status--',
                    0 => 'waiting',
                    1 => 'done' ,
                    2 => 'cancel'
                ],
                request()->get('status', null), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('orderby', [
                    null => '--order by--',
                    'total_price' => 'total price',
                    'user_id' => 'customer name'
                ], request()->get('orderby', null), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('direction', [
                    null => '--direction--',
                    'asc' => 'ascending',
                    'desc' => 'descending'
                ], request()->get('direction', null), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('take', [
                    null => '--take--',
                    10 => '10 records',
                    20 => '20 record',
                    50 => '50 records'
                ], request()->get('take', null), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-2 pull-right">
                {!! Form::submit('Filter', ['class' => 'btn btn-primary pull-right']) !!}
            </div>
            <div class="form-group col-md-5 pull-right">
                <div class="help-block pull-right" style="margin-top: 15px;">
                    {{ trans('admin.filter.show') }}
                    <strong>{{ $orders->total() }}</strong>
                    {{ trans('admin.filter.records') . ' ' . trans('admin.filter.in')
                        . ' ' . $orders->lastPage() . ' ' . trans('admin.filter.pages') }}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    @if (count($orders))
        <div class="table-responsive col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>{!! Form::checkbox('checkall', 1, 0, ['id' => 'selectall']) !!}</th>
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
                            <td>
                                {!! Form::checkbox('select', $order->id, null, ['class' => 'select']) !!}
                            </td>
                            <td class="text-primary"><strong>{{ $order->user->name }}</strong></td>
                            <td>{{ Format::currency($order->total_price) }}</td>
                            <td>{{ $order->orderItems->count() }}</td>
                            <td class="status">{{ ($order->status == config('setting.done_order')) ? trans('admin.order.status-done') : (($order->status) == config('setting.cancel_order') ? trans('admin.order.status-cancel') : trans('admin.order.status-waiting'))}}</td>
                            <td>{!! Form::checkbox('status', $order->id, $order->status, [($order->status == config('setting.cancel_order') ? 'disabled' : null), 'class' => 'order_status']) !!}</td>
                            <td>{!! link_to_route('order.show', trans('admin.user.see'), [$order->id], ['class' => 'btn btn-success btn-block']) !!}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">
                            <div class="dropup">
                                <button class="selected btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" disabled="">with selected
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" id="all-done">These orders have been paid?</a></li>
                                    <li><a href="#" id="all-waiting">These orders have not been paid?</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pull-right link">{!! $orders->links() !!}</div>
    @else
        <h2 class="text-center">Nothing found!</h2>
    @endif
@endsection
@section('js')
    @parent
    <script>
        var data = {
            url: '{!! route('order.status', '') !!}',
            fail: '{{ trans('admin.user.fail') }}',
            waiting: '{{ trans('admin.order.status-waiting') }}',
            done: '{{ trans('admin.order.status-done') }}',
            updateMultiUrl: '{{ route('order.update.multi') }}',
            paid: '{{ trans('admin.order.paid') }}',
            notPaid: '{{ trans('admin.order.not-paid') }}',
        };
    </script>
    {{ HTML::script('/js/order.js') }}
    {{ HTML::script('/js/select-checkbox.js') }}
@endsection
