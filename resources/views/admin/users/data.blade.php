@foreach ($users as $user)
    <tr {!! !$user->status ? 'class="warning"' : '' !!}>
        <td>
            {!! Form::checkbox('select', $user->id, null, ['class' => 'select']) !!}
        </td>
        <td>{{$user->id}}</td>
        <td class="text-primary"><strong>{{ $user->name }}</strong></td>
        <td>{{ $user->email }}</td>
        <td>{!! Form::checkbox('status', $user->id, $user->status, ['class' => 'user-status']) !!}</td>
        <td>{!! link_to_route('user.show', trans('admin.user.see'), [$user->id], ['class' => 'btn btn-success btn']) !!}</td>
        <td>{!! link_to_route('user.edit', trans('admin.user.edit'), [$user->id], ['class' => 'btn btn-warning']) !!}</td>
        <td>
            {!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id]]) !!}
                {!! Form::submit(trans('admin.user.destroy'), ['data-title' => trans('admin.user.destroy-warning'), 'class' => 'btn btn-danger  btn-destroy']) !!}
            {!! Form::close() !!}
        </td>
    </tr>
@endforeach
<tr>
    <td colspan="8">
        <div class="dropup">
            <button class="selected btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" disabled="">with selected
            <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="#" id="avtive-all">Active all</a></li>
                <li><a href="#" id="deactive-all">Deactive all</a></li>
                <li><a href="#" id="destroy-all">Destroy all</a></li>
            </ul>
        </div>
    </td>
</tr>
