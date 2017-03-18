@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.product.preview') . ' ' . $fileName . link_to_action('ProductController@importProduct',
            trans('admin.product.import'),
            $fileName, ['class' => 'btn btn-info pull-right', 'id' => 'import']),
        'icon' => 'user',
        'fil' => trans('admin.product.product'),
    ])
    @include('admin.partials.message')
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{ trans('admin.product.image') }}</th>
                    <th>{{ trans('admin.product.name') }}</th>
                    <th>{{ trans('admin.product.category') }}</th>
                    <th>{{ trans('admin.product.description') }}</th>
                    <th>{{ trans('admin.product.price') }}</th>
                    <th>{{ trans('admin.product.rating') }}</th>
                    <th>{{ trans('admin.product.quantity') }}</th>
                    <th>{{ trans('admin.product.trending') }}</th>
                    <th>{{ trans('admin.main.created_at') }}</th>
                    <th>{{ trans('admin.main.updated_at') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                       <td class="image">
                            <img src="{!! Storage::url($product->image) !!}" class="img-responsive img-item" alt="{!! Storage::url($product->image) !!}">
                        </td>
                        <td class="text-primary"><strong>{{ $product->name }}</strong></td>
                        <td>{{ $product->category_id  }}</td>
                        <td>{{ $product->description  }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->avg_rating }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->is_trending }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>{{ $product->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    @parent
    {{ HTML::script('/js/product.js') }}
    <script>
        var data = {
            importMsg: '{!! trans('admin.product.import-confirm') !!}'
        };
    </script>
@endsection
