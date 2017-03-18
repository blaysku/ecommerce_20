@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.suggest.dashboard'),
        'icon' => 'lightbulb-o',
        'fil' => trans('admin.suggest.suggest'),
    ])
    @include('admin.partials.message')
    <div class="col-lg-12 well filter">
        {!! Form::open(['method' => 'GET']) !!}
            <div class="form-group col-md-6">
                {!! Form::text('keyword', request()->get('keyword', null), ['class' => 'form-control', 'placeholder' => 'keyword...']) !!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('status', [null => '--status--', 0 => 'waiting', 1 => 'accepted', 2 => 'rejected'], request()->get('status', null), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::select('orderby', [null => '--order by--', 'user_id' => 'Sender', 'category_id' => 'category'], request()->get('orderby', null), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::select('direction', [null => '--direction--', 'asc' => 'ascending', 'desc' => 'descending'], request()->get('direction', null), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::select('take', [null => '--take--', 10 => '10 records', 20 => '20 record', 50 => '50 records'], request()->get('take', null), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-2 pull-right">
                {!! Form::submit('Filter', ['class' => 'btn btn-primary pull-right']) !!}
            </div>
            <div class="form-group col-md-4 pull-right">
            <div class="help-block pull-right" style="margin-top: 15px;">show <strong>{{ $suggests->total() }}</strong> records in {{ $suggests->lastPage() }} pages</div>
            </div>
        {!! Form::close() !!}
    </div>
    @if (count($suggests))
    <div class="table-responsive col-lg-12">
        <table class="table">
            <thead>
                <tr>
                    <th>{!! Form::checkbox('checkall', 1, 0, ['id' => 'selectall']) !!}</th>
                    <th>{{ trans('admin.suggest.image') }}</th>
                    <th>{{ trans('admin.suggest.name') }}</th>
                    <th>{{ trans('admin.suggest.user') }}</th>
                    <th>{{ trans('admin.suggest.category') }}</th>
                    <th>{{ trans('admin.suggest.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suggests as $suggest)
                    <tr {!! $suggest->status == config('setting.sugget_accept') ? 'class="success"' : ($suggest->status == config('setting.sugget_reject') ? 'class="danger"' : null) !!}>
                    <td>
                        {!! Form::checkbox('select', $suggest->id, null, ['class' => 'select', $suggest->status == 1 || $suggest->status == 2 ? 'disabled' : null]) !!}
                    </td>
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
                                {!! Form::submit(trans('admin.suggest.suggest-accept'), ['class' => 'btn btn-success btn-block', $suggest->status != config('setting.suggest_waiting') ? 'disabled' : null]) !!}
                            {!! Form::close() !!}
                        </td>
                        <td>
                            {!! Form::open(['route' => ['suggest.reject', $suggest->id]]) !!}
                                {!! Form::submit(trans('admin.suggest.suggest-reject'), ['data-title' => trans('admin.suggest.reject-warning'), 'class' => 'btn btn-danger btn-block btn-destroy', $suggest->status != config('setting.suggest_waiting') ? 'disabled' : null]) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="8">
                            {!! Form::submit('Reject selected', ['id' => 'destroy-all', 'class' => 'btn btn-danger selected', 'disabled']) !!}
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
    <div class="pull-right link">{!! $suggests->links() !!}</div>
    @else
        <h2 class="text-center">Nothing found!</h2>
    @endif
@endsection
@section('js')
    @parent
    <script>
        var data = {
            rejectAllUrl: '{{ route('suggest.reject.multi') }}',
            yes: '{!! trans('admin.main.yes') !!}',
            no: '{!! trans('admin.main.no') !!}',
        };
    </script>
    {{ HTML::script('/js/suggest.js') }}
@endsection
