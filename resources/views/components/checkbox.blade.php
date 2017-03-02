<div class="form-group">
    {!! Form::label($name, $label, ['class' => 'col-lg-2 control-label']) !!}
    <div class="checkbox col-lg-{{ $columns or 8 }}">
        <label>
            {!! Form::checkbox($name, null, $checked) !!}
            {{ $label }}
        </label>
    </div>
</div>
