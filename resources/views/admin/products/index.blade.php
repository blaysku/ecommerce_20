@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.product.dashboard') . link_to_route(
            'product.create',
            trans('admin.product.add'),
            [],
            ['class' => 'btn btn-info pull-right']),
        'icon' => 'user',
        'fil' => trans('admin.product.product'),
    ])
    @include('admin.partials.message')
    <div class="col-lg-12 well filter">
        <div class="col-lg-8">
        {!! Form::open(['method' => 'GET']) !!}
            <div class="form-group col-md-6">
                {!! Form::text('keyword',
                    request()->get('keyword', null),
                    ['class' => 'form-control', 'placeholder' => 'keyword...'])
                !!}
            </div>
            <div class="col-md-3 form-group">
                <select name="category" class="form-control">
                    <option value="">--category--</option>
                    @foreach ($categories as $category)
                    <optgroup label="{{ $category->name }}">
                        @foreach ($category->childrens as $children)
                            <option value="{{ $children->id }}"
                                {{ $children->id == request()->get('category')
                                    ? 'selected' : '' }}>
                                {{ $children->name }}
                            </option>
                        @endforeach
                    </optgroup>

                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('status', [
                    null => trans('admin.filter.status'),
                    1 => trans('admin.filter.trending'),
                    0 => trans('admin.filter.not-trending')
                ],
                request()->get('status', null),
                ['class' => 'form-control'])!!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('quantity', [
                    null => trans('admin.product.quantity'),
                    0 => trans('admin.filter.sold-out'),
                    10 => trans('admin.filter.less-than') . ' 10',
                    50 => trans('admin.filter.less-than') . ' 50'
                ],
                request()->get('quantity', null),
                ['class' => 'form-control'])!!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('orderby', [
                    null => trans('admin.filter.orderby'),
                    'id' => 'id',
                    'name' => trans('admin.filter.name'),
                    'avg_rating' => trans('admin.product.rating'),
                    'price' => trans('admin.product.price')
                ],
                request()->get('orderby', null),
                ['class' => 'form-control'])!!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('direction',[
                    null => trans('admin.filter.direction'),
                    'asc' => trans('admin.filter.asc'),
                    'desc' => trans('admin.filter.desc')
                ],
                request()->get('direction', null),
                ['class' => 'form-control'])!!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('take', [
                    null => '--take--',
                    10 => '10 ' . trans('admin.filter.records'),
                    20 => '20 ' . trans('admin.filter.records'),
                    50 => '50 ' . trans('admin.filter.records')
                ],
                request()->get('take', null),
                ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-2 pull-right">
                {!! Form::submit(trans('admin.filter.filter'), ['class' => 'btn btn-primary pull-right']) !!}
            </div>
            <div class="form-group col-md-5 pull-right">
                <div class="help-block pull-right" style="margin-top: 15px;">
                    {{ trans('admin.filter.show') }}
                    <strong>{{ $products->total() }}</strong>
                    {{ trans('admin.filter.records') . ' ' . trans('admin.filter.in')
                        . ' ' . $products->lastPage() . ' ' . trans('admin.filter.pages') }}
                </div>
            </div>
        {!! Form::close() !!}
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('admin.product.preview-import') }}</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['files' => true,'action' => 'ProductController@uploadDataFile']) !!}
                        <div class="form-group">
                            {!! Form::file('data', []) !!}
                        </div>
                        {!! Form::submit(trans('admin.product.preview'), ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @if (isset($products))
        <div class="table-responsive col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>{!! Form::checkbox('checkall', 1, 0, ['id' => 'selectall']) !!}</th>
                        <th>Id</th>
                        <th>{{ trans('admin.product.image') }}</th>
                        <th>{{ trans('admin.product.name') }}</th>
                        <th>{{ trans('admin.product.category') }}</th>
                        <th>{{ trans('admin.product.rating') }}</th>
                        <th>{{ trans('admin.product.price') }}</th>
                        <th>{{ trans('admin.product.quantity') }}</th>
                        <th>{{ trans('admin.product.trending') }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr {!! $product->is_trending ? 'class="warning"' : '' !!}>
                            <td>
                                {!! Form::checkbox('select', $product->id, null, ['class' => 'select']) !!}
                            </td>
                            <td>{{ $product->id }}</td>
                           <td class="image">
                                <img style="max-width: 100px" src="{!! Storage::url($product->image) !!}" class="img-responsive" alt="{!! $product->name !!}">
                            </td>
                            <td class="text-primary"><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->category->name  }}</td>
                            <td>{{ $product->avg_rating }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{!! Form::checkbox('is_trending', $product->id, $product->is_trending, ['class' => 'product-status']) !!}</td>
                            <td>{!! link_to_route('front.product.show', trans('admin.user.see'), [$product->id], ['class' => 'btn btn-success btn-block']) !!}</td>
                            <td>{!! link_to_route('product.edit', trans('admin.user.edit'), [$product->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
                            <td>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['product.destroy', $product->id]]) !!}
                                    {!! Form::submit(trans('admin.user.destroy'), ['data-title' => trans('admin.product.destroy-warning'), 'class' => 'btn btn-danger btn-block btn-destroy']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">
                            {!! Form::submit('Destroy selected', ['id' => 'destroy-all', 'class' => 'btn btn-danger selected', 'disabled']) !!}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pull-right link">{!! $products->links() !!}</div>
    @else
        <h2 class="text-center">Nothing found!</h2>
    @endif
@endsection
@section('js')
    @parent
    <script>
        var data = {
            url: '{!! route('product.trending', '') !!}',
            fail: '{{ trans('admin.user.fail') }}',
            yes: '{!! trans('admin.main.yes') !!}',
            no: '{!! trans('admin.main.no') !!}',
            destroy_all: '{{ route('product.destroy.multi') }}',
            deleteAll: '{{ trans('admin.product.delete-all') }}',
            successMsg: '{{ trans('admin.main.success') }}',
        };
    </script>
    {{ HTML::script('/js/product.js') }}
    {{ HTML::script('/js/select-checkbox.js') }}
@endsection
