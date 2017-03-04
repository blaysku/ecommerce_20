@extends('admin.template')
@section('css')
    @parent
    {{ HTML::style('/css/bs-treeview.css') }}
@endsection
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.category.dashboard') . link_to_route('category.index', trans('admin.category.add'),
        [],
        ['class' => 'btn btn-info pull-right']),
        'icon' => 'folder-open', 'fil' => trans('admin.category.categories'),
    ])
    @include('admin.partials.message')
    <div class="row">
        <div class="col-md-4">
            <ul id="tree">
                @foreach ($categories as $category)
                    @include('admin.categories.child')
                @endforeach
            </ul>
        </div>
        @yield('main-form')
    </div>
@endsection
@section('js')
    @parent
    {{ HTML::script('/js/bs-treeview.js') }}
    {{ HTML::script('/js/category.js') }}
    <script>
        var trans = {
            title: '{{ trans('admin.category.delete-all') }}',
            yes: '{!! trans('admin.main.yes') !!}',
            no: '{!! trans('admin.main.no') !!}',
        };
    </script>
@endsection
