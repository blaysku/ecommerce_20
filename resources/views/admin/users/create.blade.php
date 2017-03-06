@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.user.create-user'),
        'icon' => 'user',
        'fil' => link_to_route('user.index',trans('admin.user.users')) . ' / ' . trans('admin.user.create-user'),
    ])
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::open(['class' => 'form-horizontal', 'action' => 'UserController@store', 'method' => 'POST', 'files' => true]) !!}
            {!! Form::controlBootstrap('text', 'name', $errors, trans('admin.user.name')) !!}
            {!! Form::controlBootstrap('email', 'email', $errors, trans('admin.user.email')) !!}
            {!! Form::controlBootstrap('text', 'phone', $errors, trans('admin.user.phone')) !!}
            {!! Form::controlBootstrap('password', 'password', $errors, trans('admin.user.password')) !!}
            {!! Form::controlBootstrap('text', 'address', $errors, trans('admin.user.address')) !!}
            {!! Form::controlBootstrap('file', 'avatar', $errors, trans('admin.user.avatar')) !!}
            {!! Form::selectBootstrap('gender', [config('setting.female') => trans('authentication.female'), config('setting.male') => trans('authentication.male'), config('setting.other_gender') => trans('authentication.other_gender')], trans('admin.user.gender')) !!}
            <div class="form-group">
                {!! Form::label('role', trans('admin.user.role'), ['class' => 'control-label col-lg-2']) !!}
                <div class="radio col-lg-8">
                    <label>{!! Form::radio('is_admin', config('setting.user_permission'), 1) !!}{{ trans('admin.main.user') }}</label>
                    <label>{!! Form::radio('is_admin', config('setting.admin_permission'), 0) !!}{{ trans('admin.main.admin') }}</label>
                </div>
            </div>
            {!! Form::checkboxBootstrap('status', trans('admin.user.status')) !!}
            <div class="form-group col-lg-push-2 col-lg-8">
                {!! Form::submit(trans('admin.main.submit'), ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
