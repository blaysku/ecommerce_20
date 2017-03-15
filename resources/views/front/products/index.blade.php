@extends('front.template')
@section('title', trans('front.label.shop-page'))
@section('css')
    @parent
    {!! HTML::style('/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
    {!! HTML::style('/bower_components/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css') !!}
    {!! HTML::style('/bower_components/sweetalert/dist/sweetalert.css') !!}
@endsection
@section('main')
@include('front.includes.title', ['title' => trans('front.label.shop-page')])
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <!-- filter bar -->
                <div class="col-md-12 well filter">
                    {!! Form::open(['route' => 'front.product.index', 'id' => 'filter']) !!}
                        <div class="col-md-3">
                            <select id ="category" name="category[]" class="form-control selectpicker" multiple title="{{ trans('front.filter.select-category') }}" data-actions-box="true">
                                @foreach ($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach ($category->childrens as $children)
                                            <option value="{{ $children->id }}" {{ request()->category && in_array($children->id, request()->category) ? 'selected' : '' }}>{{ $children->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input id="price" type="text" name="price"/>
                       </div>
                        <div class="col-md-2">
                            <select name="orderby" class="form-control selectpicker" title="{{ trans('front.filter.order') }}" id="orderby">
                                <option value="name" {{ request()->orderby == 'name' ? 'selected' : ''}}>{{ trans('front.filter.order-name') }}</option>
                                <option value="price" {{ request()->orderby == 'price' ? 'selected' : ''}}>{{ trans('front.filter.order-price') }}</option>
                                <option value="created_at" {{ request()->orderby == 'created_at' ? 'selected' : ''}}>{{ trans('front.filter.order-date') }}</option>
                                <option value="avg_rating" {{ request()->orderby == 'avg_rating' ? 'selected' : ''}}>{{ trans('front.filter.order-rating') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="direction" class="form-control selectpicker" title="{{ trans('front.filter.direction') }}" id="direction">
                                <option value="asc" {{ request()->direction == 'asc' ? 'selected' : ''}}>{{ trans('front.filter.sort-asc') }}</option>
                                <option value="desc" {{ request()->direction == 'desc' ? 'selected' : ''}}>{{ trans('front.filter.sort-desc') }}</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            {!! Form::submit(trans('front.filter.filter'), ['class' => 'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
                <!-- end filter bar -->
                <div id="data">
                    @include('front.products.data')
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="product-pagination text-center link">
                        {{ $links }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @parent
    {!! HTML::script('/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js') !!}
    {!! HTML::script('/bower_components/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js') !!}
    {!! HTML::script('/front/js/product-page.js') !!}
    <script>
        var data = {
            error: '{!! trans('admin.main.error') !!}',
            value: [{{ request()->price ? request()->price[0] . ',' . request()->price[1] : '0, 10000' }}],
            addToCartRoute: "{{ route('front.product.addToCart', '') }}",
        };
    </script>
@endsection
