@extends('front.template')
@section('title', $user->name . '&#039;s ' . trans('front.account.wishlist'))
@section('css')
    @parent
    {!! HTML::style('/bower_components/jquery.rateit/scripts/rateit.css') !!}
@endsection
@section('main')
    @include('front.includes.title', ['title' => $user->name . '&#039;s ' . trans('front.account.wishlist')])
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
                                    <h2 class="product-name">{{ $user->name . '&#039;s ' . trans('front.account.wishlist')}}</h2>
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
                                        <a class="btn btn-primary" href="{{ route('front.user.show', $user->id) }}">
                                            <i class="fa fa-user"></i> {{ trans('front.user.profile') }}
                                        </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('admin.suggest.image') }}</th>
                                            <th>{{ trans('admin.suggest.name') }}</th>
                                            <th>{{ trans('admin.suggest.category') }}</th>
                                            <th>{{ trans('admin.product.description') }}</th>
                                            <th>{{ trans('admin.suggest.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suggests as $suggest)
                                            <tr {!! $suggest->status == config('setting.sugget_accept') ? 'class="success"'
                                                : ($suggest->status == config('setting.sugget_reject') ? 'class="danger"' : '') !!}>
                                               <td class="image">
                                                    <img src="{!! (empty($suggest->image)) ? Storage::url(config('setting.default_suggest_image'))
                                                        : Storage::url($suggest->image) !!}" class="img-responsive img-item" alt="{!! $suggest->name !!}">
                                                </td>
                                                <td class="text-primary"><strong>{{ $suggest->name }}</strong></td>
                                                <td>{{ $suggest->category->name }}</td>
                                                <td>{!! $suggest->description !!}</td>
                                                <td>{{ $suggest->status == config('setting.sugget_waiting') ? trans('admin.suggest.suggest-waiting')
                                                    : ($suggest->status == config('setting.sugget_accept') ? trans('admin.suggest.suggest-accept')
                                                        : trans('admin.suggest.suggest-reject'))}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pull-right link">{!! $suggests->links() !!}</div>
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
            userUpdateUrl: '{{ route('front.user.update') }}',
            orderUpdateUrl: '{{ route('front.order.update', '') }}',
            cancelMsg: '{{ trans('front.cart.cancel') }}',
            successMsg: '{{ trans('front.user.updated') }}',
            cancel: '{{ trans('admin.order.status-cancel') }}',
            yes: '{{ trans('admin.main.yes') }}',
            no: '{{ trans('admin.main.no') }}',
        }
    </script>
<<<<<<< HEAD
=======
    {!! HTML::script('/bower_components/jquery.rateit/scripts/jquery.rateit.min.js') !!}
>>>>>>> user suggest list
    {{ HTML::script('front/js/user-show.js') }}
@endsection
