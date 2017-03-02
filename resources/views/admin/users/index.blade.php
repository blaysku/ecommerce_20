@extends('admin.template')
@section('main')
    @include('admin.partials.breadcrumb', ['title' => trans('admin.user.dashboard') . link_to_route('user.create', trans('admin.user.add'), [], ['class' => 'btn btn-info pull-right']), 'icon' => 'user', 'fil' => trans('admin.user.users')])
    @include('admin.partials.message')
    <div id="tri" class="btn-group btn-group-sm">
        <a href="{!! route('user.index') !!}" role="button" class="btn btn-default{{ CheckPath::classActiveOnlyPath('admin/user') }}">{{ trans('admin.user.all') }} 
            <span class="badge">{{  $counts['total'] }}</span>
        </a>
        <a href="{!! route('user.index', 'admin') !!}" role="button" class="btn btn-default {{ CheckPath::classActiveOnlyPath('admin/user/admin') }}">{{ trans('admin.main.admin') }} 
            <span class="badge">{{  $counts[config('setting.admin')] }}</span>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
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
@endsection
@section('js')
    @parent
    <script>
        $(function() {
            // change user status
            $(document).on('change', ':checkbox', function() {
                $(this).parents('tr').toggleClass('warning');
                $(this).hide().parent().append('<i class="fa fa-refresh fa-spin"></i>');
                $.ajax({
                    url: '{!! route('user.status', '') !!}' + '/' + this.value,
                    type: 'PUT',
                    data: "status=" + this.checked
                })
                .done(function() {
                    $('.fa-spin').remove();
                    $('input[type="checkbox"]:hidden').show();
                })
                .fail(function() {
                    $('.fa-spin').remove();
                    var chk = $('input[type="checkbox"]:hidden');
                    chk.show().prop('checked', chk.is(':checked') ? null : 'checked').parents('tr').toggleClass('warning');
                    swal('{{ trans('admin.user.fail') }}');
                });
            });
            //destroy user event
            $('.btn-destroy').on('click',function(e){
                e.preventDefault();
                var form = $(this).parents('form');
                swal({
                    title: $(this).attr('data-title'),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{!! trans('admin.main.yes') !!}",
                    cancelButtonText: "{!! trans('admin.main.no') !!}"
                }, function(isConfirm){
                    if (isConfirm) form.submit();
                });
            });
        });
    </script>
@endsection
