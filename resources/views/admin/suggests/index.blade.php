@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.suggest.dashboard'),
        'icon' => 'lightbulb-o',
        'fil' => trans('admin.suggest.suggest'),
    ])
    @include('admin.partials.message')
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ trans('admin.suggest.image') }}</th>
                    <th>{{ trans('admin.suggest.name') }}</th>
                    <th>{{ trans('admin.suggest.user') }}</th>
                    <th>{{ trans('admin.suggest.category') }}</th>
                    <th>{{ trans('admin.suggest.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suggests as $suggest)
                    <tr {!! $suggest->status == config('setting.sugget_accept') ? 'class="success"' : ($suggest->status == config('setting.sugget_reject') ? 'class="danger"' : '') !!}>
                       <td class="image">
                            <img src="{!! (empty($suggest->image)) ? Storage::url(config('setting.default_suggest_image')) : Storage::url($suggest->image) !!}" class="img-responsive img-item" alt="{!! $suggest->name !!}">
                        </td>
                        <td class="text-primary"><strong>{{ $suggest->name }}</strong></td>
                        <td>{{ $suggest->user->name  }}</td>
                        <td>{{ $suggest->category->name }}</td>
                        <td>{{ $suggest->status == config('setting.sugget_waiting') ? trans('admin.suggest.suggest-waiting') : ($suggest->status == config('setting.sugget_accept') ? trans('admin.suggest.suggest-accept') : trans('admin.suggest.suggest-reject'))}}</td>
                        <td>{!! link_to_route('suggest.show', trans('admin.user.see'), [$suggest->id], ['class' => 'btn btn-info btn-block']) !!}</td>
                        <td>
                            {!! Form::open(['route' => ['suggest.accept', $suggest->id]]) !!}
                                {!! Form::submit(trans('admin.suggest.suggest-accept'), ['class' => 'btn btn-success btn-block', $suggest->status != config('setting.suggest_waiting') ? 'disabled' : '']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td>
                            {!! Form::open(['route' => ['suggest.reject', $suggest->id]]) !!}
                                {!! Form::submit(trans('admin.suggest.suggest-reject'), ['data-title' => trans('admin.suggest.reject-warning'), 'class' => 'btn btn-danger btn-block btn-destroy', $suggest->status != config('setting.suggest_waiting') ? 'disabled' : '']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pull-right link">{!! $suggests->links() !!}</div>
@endsection
@section('js')
    @parent
    {{ HTML::script('/js/product.js') }}
    <script>
        var data = {
            yes: '{!! trans('admin.main.yes') !!}',
            no: '{!! trans('admin.main.no') !!}',
        };
    </script>
@endsection
