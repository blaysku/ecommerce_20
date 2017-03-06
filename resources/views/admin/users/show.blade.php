@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.user.user-detail'),
        'icon' => 'user',
        'fil' => link_to_route('user.index', trans('admin.user.users')) . ' / ' . trans('admin.user.user-detail'),
    ])
    @include('admin.partials.message')
    <div class="image">
        <img src="{!! Storage::url($user->avatar) !!}" class="img-responsive img-circle" alt="{!! $user->name !!}">
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>{{ trans('admin.user.name') }}</th>
                    <td>{{ $user->name }}</th>
                </tr>
                <tr>
                    <th>{{ trans('admin.user.email') }}</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.user.gender') }}</th>
                    <td>{{ ($user->gender == config('setting.male')) ? trans('admin.user.male') : ($user->gender == config('setting.female')) ? trans('admin.user.female') : trans('admin.user.other_gender') }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.user.phone') }}</th>
                    <td>{{ $user->phone }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.user.address') }}</th>
                    <td>{{ $user->address }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.user.status') }}</th>
                    <td>{{ ($user->status == config('setting.activated_user_status')) ? trans('admin.user.active') : trans('admin.user.not-active') }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.user.role') }}</th>
                    <td>{{ ($user->is_admin == config('setting.admin_permission')) ? trans('admin.main.admin') : trans('admin.main.user') }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.user.introduce') }}</th>
                    <td>{!! $user->introduce !!}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.user.register-from') }}</th>
                    <td>{!! $user->created_at->diffForHumans() !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
