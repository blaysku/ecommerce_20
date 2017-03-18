@extends('front.template')
@section('title', trans('front.label.shop-page'))
@section('css')
    @parent
    {!! HTML::style('/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
    {!! HTML::style('/bower_components/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css') !!}
    {!! HTML::style('/bower_components/jquery.rateit/scripts/rateit.css') !!}
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
                        <div class="col-md-2 form-group">
                            {!! Form::text('keyword', request()->get('keyword', null), ['placeholder' => 'Type keyword', 'id' => 'keyword']) !!}
                        </div>
                        <div class="col-md-2 form-group">
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
                        <div class="col-md-3 form-group">
                            <input id="price" type="text" name="price"/>
                       </div>
                        <div class="col-md-2 form-group">
                            <select name="orderby" class="form-control selectpicker" title="{{ trans('front.filter.order') }}" id="orderby">
                                <option value="name" {{ request()->orderby == 'name' ? 'selected' : ''}}>{{ trans('front.filter.order-name') }}</option>
                                <option value="price" {{ request()->orderby == 'price' ? 'selected' : ''}}>{{ trans('front.filter.order-price') }}</option>
                                <option value="created_at" {{ request()->orderby == 'created_at' ? 'selected' : ''}}>{{ trans('front.filter.order-date') }}</option>
                                <option value="avg_rating" {{ request()->orderby == 'avg_rating' ? 'selected' : ''}}>{{ trans('front.filter.order-rating') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <select name="direction" class="form-control selectpicker" title="{{ trans('front.filter.direction') }}" id="direction">
                                <option value="asc" {{ request()->direction == 'asc' ? 'selected' : ''}}>{{ trans('front.filter.sort-asc') }}</option>
                                <option value="desc" {{ request()->direction == 'desc' ? 'selected' : ''}}>{{ trans('front.filter.sort-desc') }}</option>
                            </select>
                        </div>
                        <div class="col-md-1 form-group">
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
            @if (Auth::check())
                <div class="modal fade" id="suggest-form">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">{{ trans('front.suggest.suggest') }}</h4>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['class' => 'form-horizontal', 'id' => 'suggest-data']) !!}
                                    <div class="form-group">
                                        {!! Form::label('image', trans('admin.product.image'), ['class' => 'control-label col-lg-3']) !!}
                                        <div class="col-lg-8">
                                            {!! Form::file('image', []) !!}
                                            <small class="help-block"></small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('name', trans('admin.product.name'), ['class' => 'control-label col-lg-3']) !!}
                                        <div class="col-lg-8">
                                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                            <small class="help-block"></small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('category_id', trans('admin.product.category'), ['class' => 'control-label col-lg-3']) !!}
                                        <div class="col-lg-8">
                                            <select name="category_id" class="form-control">
                                                @foreach ($categories as $category)
                                                    <optgroup label="{{ $category->name }}">
                                                        @foreach ($category->childrens as $children)
                                                            <option value="{{ $children->id }}">{{ $children->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                            <small class="help-block"></small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('description', trans('admin.product.description'), ['class' => 'control-label col-lg-3']) !!}
                                        <div class="col-lg-8">
                                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                                            <small class="help-block"></small>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="modal-footer">
                                {!! Form::button(trans('front.label.close'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                                {!! Form::button(trans('admin.main.submit'), ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('js')
    @parent
    {!! HTML::script('/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js') !!}
    {!! HTML::script('/bower_components/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js') !!}
    {{ HTML::script('bower_components/ckeditor/ckeditor.js') }}
    <script>
        var data = {
            error: '{!! trans('admin.main.error') !!}',
            value: [{{ request()->price ? request()->price[0] . ',' . request()->price[1] : '0, 10000' }}],
            addToCartRoute: '{{ route('front.product.addToCart', '') }}',
            suggestUrl: '{{ route('front.suggest') }}',
            successMsg: '{{ trans('front.suggest.thanks') }}'
        };
    </script>
    {!! HTML::script('/front/js/product-page.js') !!}
@endsection
