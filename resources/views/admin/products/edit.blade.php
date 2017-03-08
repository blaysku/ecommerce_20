@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.product.dashboard'),
        'icon' => 'user',
        'fil' => link_to_route('product.index', trans('admin.product.product')) . ' / ' . trans('admin.product.edit'),
    ])
    @include('admin.partials.message')
    <div class="panel panel-default">
            <div class="image">
            <img src="{!! Storage::url($product->image) !!}" class="img-responsive" alt="{!! $product->name !!}">
        </div>
        <div class="panel-body">
            {!! Form::open(['files' => true,'class' => 'form-horizontal', 'action' => ['ProductController@update', $product->id], 'method' => 'PUT', 'files' => true]) !!}
            {!! Form::controlBootstrap('text', 'name', $errors, trans('admin.user.name'), $product->name) !!}
            {!! Form::controlBootstrap('number', 'price', $errors, trans('admin.product.price'), $product->price) !!}
            <div class="form-group">
            {!! Form::label('category_id', trans('admin.product.category'), ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-8">
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <optgroup label="{{ $category->name }}">
                                @foreach ($category->childrens as $children)
                                    <option value="{{ $children->id }}" {{ ($children->id == $product->category_id) ? 'selected' : ''}} >{{ $children->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            {!! Form::controlBootstrap('number', 'quantity', $errors, trans('admin.product.quantity'), $product->quantity) !!}
            {!! Form::controlBootstrap('file', 'image', $errors, trans('admin.product.image')) !!}
            {!! Form::checkboxBootstrap('is_trending', trans('admin.product.trending') . '?', ($product->is_trending == 1) ?: 0) !!}
            {!! Form::controlBootstrap('textarea', 'description', $errors, trans('admin.product.description'), $product->description) !!}
            <div class="form-group col-lg-push-2 col-lg-8">
                {!! Form::submit(trans('admin.main.submit'), ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
