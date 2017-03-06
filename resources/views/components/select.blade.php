<div class="form-group">
    @if ($label)
        {!! Form::label($name, $label, ['class' => 'control-label col-lg-2']) !!}
    @endif
        <div class="col-lg-{{ $columns or 8}}">
            {!! Form::select($name, $list, $selected, ['class' => 'form-control']) !!}
        </div>
</div>
