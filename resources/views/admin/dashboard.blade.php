@extends('admin.template')
@section('css')
    @parent
    {!! HTML::style('/bower_components/morris.js//morris.css') !!}
@endsection
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.main.dashboard'),
        'icon' => 'dashboard',
        'fil' => trans('admin.main.dashboard')
    ])
    @include('admin.partials.message')
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $counts['users'] }}</div>
                            <div>{{ trans('admin.dashboard.user-today')}}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('user.index') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans('admin.dashboard.view-detail') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $counts['products'] }}</div>
                            <div>{{ trans('admin.dashboard.total-product') }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('product.index') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans('admin.dashboard.view-detail') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $counts['orders'] }}</div>
                            <div>{{ trans('admin.dashboard.order-today') }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('order.index') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans('admin.dashboard.view-detail') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $counts['categories'] }}</div>
                            <div>{{ trans('admin.dashboard.sub-categories') }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('category.index') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans('admin.dashboard.view-detail') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>{{ trans('admin.dashboard.stats') }}</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills ranges">
                      <li class="active"><a href="#" data-range='7'>7 {{ trans('admin.dashboard.days') }}</a></li>
                      <li><a href="#" data-range='30'>30 {{ trans('admin.dashboard.days') }}</a></li>
                      <li><a href="#" data-range='60'>60 {{ trans('admin.dashboard.days') }}</a></li>
                      <li><a href="#" data-range='90'>90 {{ trans('admin.dashboard.days') }}</a></li>
                    </ul>
                    <div id="stats-container" ></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>  {{ trans('admin.dashboard.new-suggests') }}</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        @foreach ($suggests as $suggest)
                            <a href="{{route('suggest.show', $suggest->id) }}" class="list-group-item">
                                <span class="badge">{{ $suggest->category->name }}</span>
                                <i class="fa fa-fw fa-lightbulb-o"></i>
                                {{ $suggest->name }}
                            </a>
                        @endforeach
                    </div>
                    <div class="text-right">
                        <a href="{{ route('suggest.index') }}">
                            {{ trans('admin.dashboard.view-detail') }}
                            <i class="fa fa-fw fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i>
                        {{ trans('admin.dashboard.transactions') }}
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.dashboard.order') }} #</th>
                                    <th>{{ trans('admin.dashboard.order-date') }}</th>
                                    <th>{{ trans('admin.dashboard.order-time') }}</th>
                                    <th>{{ trans('admin.dashboard.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->toDateString() }}</td>
                                    <td>{{ $order->created_at->toTimeString() }}</td>
                                    <td>{{  Format::currency($order->total_price) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('order.index') }}">
                            {{ trans('admin.dashboard.view-detail') }}
                            <i class="fa fa-fw fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection
@section('js')
    @parent
    {{ HTML::script('bower_components/ckeditor/ckeditor.js') }}
    {{ HTML::script('bower_components/raphael/raphael.min.js') }}
    {{ HTML::script('bower_components/morris.js/morris.min.js') }}
    {{ HTML::script('js/dashboard.js') }}
    <script>
        var info = {
            statsUrl: '{{ route('admin.stats') }}',
            error: '{{ trans('admin.main.error') }}',
        }
    </script>
@endsection
