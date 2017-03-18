@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.product.dashboard') . link_to_route('product.create', trans('admin.product.add'), [], ['class' => 'btn btn-info pull-right']),
        'icon' => 'user',
        'fil' => trans('admin.product.product'),
    ])
    @include('admin.partials.message')
    <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default pull-right">
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
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
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
                       <td class="image">
                            <img style="max-width: 100px" src="{!! Storage::url($product->image) !!}" class="img-responsive" alt="{!! $product->name !!}">
                        </td>
                        <td class="text-primary"><strong>{{ $product->name }}</strong></td>
                        <td>{{ $product->category->name  }}</td>
                        <td>{{ $product->avg_rating }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{!! Form::checkbox('is_trending', $product->id, $product->is_trending) !!}</td>
                        <td>{!! link_to_route('product.index', trans('admin.user.see'), [$product->id], ['class' => 'btn btn-success btn-block']) !!}</td>
                        <td>{!! link_to_route('product.edit', trans('admin.user.edit'), [$product->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['product.destroy', $product->id]]) !!}
                                {!! Form::submit(trans('admin.user.destroy'), ['data-title' => trans('admin.product.destroy-warning'), 'class' => 'btn btn-danger btn-block btn-destroy']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pull-right link">{!! $products->links() !!}</div>
@endsection
@section('js')
    @parent
    {{ HTML::script('/js/product.js') }}
    <script>
        var data = {
            url: '{!! route('product.trending', '') !!}',
            fail: '{{ trans('admin.user.fail') }}',
            yes: '{!! trans('admin.main.yes') !!}',
            no: '{!! trans('admin.main.no') !!}',
        };
    </script>
@endsection
