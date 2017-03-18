@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', ['title' => trans('admin.user.dashboard') . link_to_route('user.create', trans('admin.user.add'), [], ['class' => 'btn btn-info pull-right']), 'icon' => 'user', 'fil' => trans('admin.user.users')])
    @include('admin.partials.message')
    <div class="col-lg-12 well filter">
        {!! Form::open(['method' => 'GET']) !!}
            <div class="form-group col-md-6">
                {!! Form::text('keyword', request()->get('keyword', null), [
                    'class' => 'form-control',
                    'placeholder' => trans('admin.filter.keyword'),
                ]) !!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('role', [
                    null => trans('admin.filter.role'),
                    1 => trans('admin.main.admin'), 0 => trans('admin.main.user')
                ], request()->get('role', null), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3 form-group">
                {!! Form::select('status', [
                    null => trans('admin.filter.status'),
                    1 => trans('admin.user.active'),
                    0 => trans('admin.user.not-active'),
                ], request()->get('status', null), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::select('orderby', [
                    null => trans('admin.filter.orderby'),
                    'id' => 'id',
                    'name' => trans('admin.filter.name'),
                ], request()->get('orderby', null), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::select('direction', [
                    null => trans('admin.filter.direction'),
                    'asc' => trans('admin.filter.asc'),
                    'desc' => trans('admin.filter.desc'),
                ], request()->get('direction', null), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-2 form-group">
                {!! Form::select('take', [
                    null => trans('admin.filter.take'),
                    10 => '10 ' . trans('admin.filter.records'),
                    20 => '20 ' . trans('admin.filter.records'),
                    50 => '50 ' . trans('admin.filter.records'),
                ], request()->get('take', null), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-2 pull-right">
                {!! Form::submit(trans('admin.filter.filter'), ['class' => 'btn btn-primary pull-right']) !!}
            </div>
            <div class="form-group col-md-4 pull-right">
                <div class="help-block pull-right" style="margin-top: 15px;">
                    {{ trans('admin.filter.show') }}
                    <strong>{{ $users->total() }}</strong>
                    {{ trans('admin.filter.records') . ' ' . trans('admin.filter.in')
                        . ' ' . $users->lastPage() . ' ' . trans('admin.filter.pages') }}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    @if (count($users))
        <div class="table-responsive col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>{!! Form::checkbox('selectall', null, false, ['id' => 'selectall']) !!}</th>
                        <th>ID</th>
                        <th>{{ trans('admin.user.name') }}</th>
                        <th>{{ trans('admin.user.email') }}</th>
                        <th>{{ trans('admin.user.active') }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @include('admin.users.data')
                </tbody>
            </table>
        </div>
        <div class="pull-right link">{!! $users->links() !!}</div>
    @else
        <h2 class="text-center">{{ trans('admin.filter.nothing') }}</h2>
    @endif
@endsection
@section('js')
    @parent
    <script>
        var info = {
            routeUserStatus: '{!! route('user.status', '') !!}',
            userFailMsg: '{{ trans('admin.user.fail') }}',
            activeAllUser: '{{ trans('admin.user.active-all') }}',
            deactiveAllUser: '{{ trans('admin.user.deactive-all') }}',
            destroyAllUser: '{{ trans('admin.user.destroy-all') }}',
            userDestroyMulti: '{{ route('user.destroy.multi') }}',
            changeStatusMulti: '{{ route('user.status.multi') }}',
            successMsg: '{{ trans('admin.main.success') }}',
        };
    </script>
    {{ HTML::script('/js/user.js') }}
    {{ HTML::script('/js/select-checkbox.js') }}
@endsection
