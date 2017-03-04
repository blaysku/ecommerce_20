@extends('admin.categories.template')
@section('main-form')
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans('admin.category.add') }}</h3>
            </div>
            <div class="panel-body">
            <ol>
                <li>{!! trans('admin.category.note-1') !!}</li>
                <li>{!! trans('admin.category.note-2') !!}</li>
                <li>{!! trans('admin.category.note-3') !!}</li>
            </ol>
            {!! Form::open(['route' => 'category.store', 'method' => 'POST', 'class' => 'form-horizontal create-form']) !!}
                {!! Form::controlBootstrap('text', 'name', $errors, trans('admin.category.name')) !!}
                <div class="form-group">
                    {!! Form::label('parent_id', trans('admin.category.parent'), ['class' => 'col-lg-2']) !!}
                    <div class="col-lg-8">
                        <select name="parent_id" class="form-control">
                            <option value="{{ config('setting.rootcategory') }}">{{ trans('admin.main.none') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-lg-push-2 col-lg-8">
                    {!! Form::submit(trans('admin.main.submit'), ['class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
