@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.user.edit-user'),
        'icon' => 'user',
        'fil' => link_to_route('user.index', trans('admin.user.users')) . ' / ' . $user->name,
    ])
<div class="panel panel-default">
    <div class="panel-body">
        {!! Form::open(['class' => 'form-horizontal', 'action' => ['UserController@update', $user->id], 'method' => 'PUT', 'files' => true]) !!}
            <div class="image">
                <img src="{!! Storage::url($user->avatar) !!}" class="img-responsive img-circle" alt="{!! $user->name !!}">
            </div>
            {!! Form::controlBootstrap('file',  'avatar', $errors, trans('admin.user.avatar')) !!}
            {!! Form::controlBootstrap('text', 'name', $errors, trans('admin.user.name'), $user->name) !!}
            {!! Form::controlBootstrap('email', 'email', $errors, trans('admin.user.email'), $user->email) !!}
            {!! Form::controlBootstrap('text', 'phone', $errors, trans('admin.user.phone'), $user->phone) !!}
            {!! Form::controlBootstrap('text', 'address', $errors, trans('admin.user.address'), $user->address) !!}
            {!! Form::selectBootstrap('gender', [config('setting.female') => trans('authentication.female'), config('setting.male') => trans('authentication.male'), config('setting.other_gender') => trans('authentication.other_gender')], trans('admin.user.gender'), $user->gender) !!}
            <div class="form-group">
                {!! Form::label('role', trans('admin.user.role'), ['class' => 'control-label col-lg-2']) !!}
                <div class="radio col-lg-8">
                    <label>{!! Form::radio('is_admin', config('setting.user_permission'), $user->is_admin == config('setting.user_permission') ? 1 : 0) !!}{{ trans('admin.main.user') }}</label>
                    <label>{!! Form::radio('is_admin', config('setting.admin_permission'), $user->is_admin == config('setting.admin_permission') ? 1 : 0) !!}{{ trans('admin.main.admin') }}</label>
                </div>
            </div>
            {!! Form::checkboxBootstrap('status', trans('admin.user.status'), $user->status) !!}
            {!! Form::controlBootstrap('password', 'password', $errors, trans('admin.user.password'), null, trans('admin.user.keep-password')) !!}
            <div class="form-group col-lg-push-2 col-lg-8">
                {!! Form::submit(trans('admin.main.submit'), ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
