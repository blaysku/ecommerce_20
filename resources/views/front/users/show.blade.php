@extends('front.template')
@section('title', $user->name . '&#039;s ' . trans('front.user.profile'))
@section('css')
    @parent
    {!! HTML::style('/bower_components/jquery.rateit/scripts/rateit.css') !!}
@endsection
@section('main')
    @include('front.includes.title', ['title' => $user->name . '&#039;s ' . trans('front.user.profile')])
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
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="product-inner">
                                    <h2 class="product-name">{{ $user->name }}</h2>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th>{{ trans('admin.user.name') }}</th>
                                                    <td>{{ $user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('admin.user.email') }}</th>
                                                    <td>{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('admin.user.gender') }}</th>
                                                    <td>
                                                    {{ ($user->gender == config('setting.male')) ? trans('admin.user.male')
                                                        : (($user->gender == config('setting.female')) ? trans('admin.user.female') : trans('admin.user.other_gender')) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('admin.user.phone') }}</th>
                                                    <td>{{ $user->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('admin.user.address') }}</th>
                                                    <td>{{ $user->address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('admin.user.register-from') }}</th>
                                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($user->introduce)
                                        <blockquote>
                                          {{ $user->introduce }}
                                        </blockquote>
                                    @endif
                                    @if (Auth::check() && Auth::user()->id == $user->id)
                                        <a class="btn btn-primary" data-toggle="modal" href='#modal-id'>
                                            <i class="fa fa-fw fa-pencil"></i> {{ trans('front.user.update-profile') }}
                                        </a>
                                        <a class="btn btn-primary see-order" href='#'>
                                            <i class="fa fa-fw fa-eye"></i> {{ trans('front.user.order-history') }}
                                        </a>
<<<<<<< HEAD
                                        <a class="btn btn-primary" href="{{ route('front.user.suggest', $user->id) }}">
=======
                                        <a class="btn btn-primary" href='{{ route('front.user.suggest', $user->id) }}'>
>>>>>>> user suggest list
                                            <i class="fa fa-fw fa-lightbulb-o"></i>{{ trans('front.account.wishlist') }}
                                        </a>
                                        <div class="modal fade" id="modal-id">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">{{ trans('front.user.update-profile') }}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! Form::open(['class' => 'form-horizontal', 'id' => 'update-user']) !!}
                                                            <div class="form-group">
                                                                {!! Form::label('avatar', trans('admin.user.avatar'), ['class' => 'control-label col-lg-2']) !!}
                                                                <div class="col-lg-8">
                                                                    {!! Form::file('avatar', []) !!}
                                                                    <small class="help-block"></small>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                {!! Form::label('name', trans('admin.user.name'), ['class' => 'control-label col-lg-2']) !!}
                                                                <div class="col-lg-8">
                                                                    {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                                                                    <small class="help-block"></small>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                {!! Form::label('email', trans('admin.user.email'), ['class' => 'control-label col-lg-2']) !!}
                                                                <div class="col-lg-8">
                                                                    {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                                                                    <small class="help-block"></small>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                {!! Form::label('phone', trans('admin.user.phone'), ['class' => 'control-label col-lg-2']) !!}
                                                                <div class="col-lg-8">
                                                                    {!! Form::text('phone', $user->phone, ['class' => 'form-control']) !!}
                                                                    <small class="help-block"></small>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                {!! Form::label('address', trans('admin.user.address'), ['class' => 'control-label col-lg-2']) !!}
                                                                <div class="col-lg-8">
                                                                    {!! Form::text('address', $user->address, ['class' => 'form-control']) !!}
                                                                    <small class="help-block"></small>
                                                                </div>
                                                            </div>
                                                            {!! Form::selectBootstrap('gender', [
                                                                config('setting.female') => trans('authentication.female'),
                                                                config('setting.male') => trans('authentication.male'),
                                                                config('setting.other_gender') => trans('authentication.other_gender')
                                                            ], trans('admin.user.gender'), $user->gender) !!}
                                                            <div class="form-group">
                                                                {!! Form::label('password', trans('admin.user.password'), ['class' => 'control-label col-lg-2']) !!}
                                                                <div class="col-lg-8">
                                                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('admin.user.keep-password')]) !!}
                                                                    <small class="help-block"></small>
                                                                </div>
                                                            </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        {!! Form::button(trans('front.label.close'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                                                        {!! Form::button(trans('admin.main.submit'), ['class' => 'btn btn-primary', 'id' => 'submit-update']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Auth::check() && Auth::user()->id == $user->id && count($user->orders))
                        <div class="table-responsive order-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('front.label.id') }}</th>
                                        <th>{{ trans('admin.order.total-price') }}</th>
                                        <th>{{ trans('admin.order.total-item') }}</th>
                                        <th>{{ trans('admin.order.status') }}</th>
                                        <th>{{ trans('admin.order.created_at') }}</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->orders as $key => $order)
                                        <tr {!! ($order->status == config('setting.done_order')) ? 'class="success"'
                                            : ($order->status == config('setting.cancel_order') ? 'class="warning"' : '') !!}>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ Format::currency($order->total_price) }}</td>
                                            <td>{{ $order->orderItems->count() }}</td>
                                            <td class="order-status">
                                                {{ ($order->status == config('setting.done_order')) ? trans('admin.order.status-done')
                                                    : (($order->status) == config('setting.cancel_order') ? trans('admin.order.status-cancel') : trans('admin.order.status-waiting'))}}
                                            </td>
                                            <td>{{ $order->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a class="btn-show btn btn-default" href="{{ route('front.order.show', $order->id) }}" target="_blank"><i class="fa fa-eye"></i></a>
                                            </td>
                                            <td><a href="#" class="cancel-order btn btn-danger" data-order-id="{{ $order->id }}"><i class="fa fa-remove"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @parent
    <script>
        var info = {
            userUpdateUrl: '{{ route('front.user.update') }}',
            orderUpdateUrl: '{{ route('front.order.update', '') }}',
            cancelMsg: '{{ trans('front.cart.cancel') }}',
            successMsg: '{{ trans('front.user.updated') }}',
            cancel: '{{ trans('admin.order.status-cancel') }}',
            yes: '{{ trans('admin.main.yes') }}',
            no: '{{ trans('admin.main.no') }}',
        }
    </script>
    {!! HTML::script('/bower_components/jquery.rateit/scripts/jquery.rateit.min.js') !!}
    {{ HTML::script('front/js/user-show.js') }}
@endsection
