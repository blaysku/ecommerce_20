@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.product.dashboard'),
        'icon' => 'user',
        'fil' => link_to_route('product.index', trans('admin.product.product')) . ' / ' . trans('admin.product.add'),
    ])
    @include('admin.partials.message')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::open(['files' => true,'class' => 'form-horizontal', 'action' => 'ProductController@store', 'method' => 'POST', 'files' => true]) !!}
            {!! Form::controlBootstrap('text', 'name', $errors, trans('admin.user.name'), session('suggest') ? session('suggest')->name : null) !!}
            {!! Form::controlBootstrap('number', 'price', $errors, trans('admin.product.price')) !!}
            <div class="form-group">
            {!! Form::label('category_id', trans('admin.product.category'), ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-8">
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <optgroup label="{{ $category->name }}">
                                @foreach ($category->childrens as $children)
                                    <option value="{{ $children->id }}" {{ ( session('suggest') && session('suggest')->category_id == $children->id) ? 'selected' : ''}}>{{ $children->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            {!! Form::controlBootstrap('number', 'quantity', $errors, trans('admin.product.quantity')) !!}
            {!! Form::controlBootstrap('file', 'image', $errors, trans('admin.product.image')) !!}
            {!! Form::checkboxBootstrap('is_trending', trans('admin.product.trending') . '?', 0) !!}
            {!! Form::controlBootstrap('textarea', 'description', $errors, trans('admin.product.description'), session('suggest') ? session('suggest')->description : null) !!}
            @if (session('suggest'))
                {!! Form::hidden('suggest', session('suggest')->id, []) !!}
            @endif
            <div class="form-group col-lg-push-2 col-lg-8">
                {!! Form::submit(trans('admin.main.submit'), ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('js')
    @parent
    {{ HTML::script('bower_components/ckeditor/ckeditor.js') }}
    {{ HTML::script('js/ckeditor.js') }}
@endsection
