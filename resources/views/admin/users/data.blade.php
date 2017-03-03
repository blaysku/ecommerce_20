@foreach ($users as $user)
    <tr {!! !$user->status ? 'class="warning"' : '' !!}>
        <td class="text-primary"><strong>{{ $user->name }}</strong></td>
        <td>{{ $user->email }}</td>
        <td>{!! Form::checkbox('status', $user->id, $user->status) !!}</td>
        <td>{!! link_to_route('user.show', trans('admin.user.see'), [$user->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
        <td>{!! link_to_route('user.edit', trans('admin.user.edit'), [$user->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
        <td>
            {!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id]]) !!}
                {!! Form::submit(trans('admin.user.destroy'), ['data-title' => trans('admin.user.destroy-warning'), 'class' => 'btn btn-danger btn-block btn-destroy']) !!}
            {!! Form::close() !!}
        </td>
    </tr>
@endforeach
