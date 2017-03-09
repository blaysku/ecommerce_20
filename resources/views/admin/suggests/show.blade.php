@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', [
        'title' => trans('admin.suggest.detail'),
        'icon' => 'lightbulb-o',
        'fil' => link_to_route('suggest.index', trans('admin.suggest.suggest')) . ' / ' . trans('admin.suggest.detail'),
    ])
    @include('admin.partials.message')
    @if (!empty($suggest->image))
        <div class="image">
            <img src="{!! Storage::url($suggest->image) !!}" class="img-responsive" alt="{!! $suggest->name !!}">
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>{{ trans('admin.suggest.name') }}</th>
                    <td>{{ $suggest->name }}</th>
                </tr>
                <tr>
                    <th>{{ trans('admin.suggest.user') }}</th>
                    <td>{{ $suggest->user->name }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.suggest.category') }}</th>
                    <td>{{ $suggest->category->name }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.suggest.status') }}</th>
                    <td>{{ $suggest->status == config('setting.sugget_waiting') ? trans('admin.suggest.suggest-waiting') : ($suggest->status == config('setting.sugget_accept') ? trans('admin.suggest.suggest-accept') : trans('admin.suggest.suggest-reject'))}}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.suggest.content') }}</th>
                    <td>{{ $suggest->description }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.suggest.suggest-time') }}</th>
                    <td>{!! $suggest->created_at->diffForHumans() !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
