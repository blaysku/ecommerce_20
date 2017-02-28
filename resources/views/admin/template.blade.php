<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ trans('admin.main.site-title') }}</title>
        <meta name="description" content="">	
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @section('css')
            {!! HTML::style('/bower_components/bootstrap/dist/css/bootstrap.css') !!}
            {!! HTML::style('/bower_components/font-awesome/css/font-awesome.css') !!}
            {!! HTML::style('/bower_components/sweetalert/dist/sweetalert.css') !!}
            {!! HTML::style('/css/sb-admin.css') !!}
        @show
    </head>
    <body>
        <div id="wrapper">
        @include('admin.partials.header')
            <div id="page-wrapper">
                <div class="container-fluid">
                    @yield('main')
                </div>
            </div>
        </div>
        <footer class="footer">
            <p class="text-muted text-center">{{ trans('admin.main.footer-text') }}</p>
        </footer>
        @section('js')
            {!! HTML::script('/bower_components/jquery/dist/jquery.js') !!}
            {!! HTML::script('/bower_components/bootstrap/dist/js/bootstrap.js') !!}
            {!! HTML::script('/bower_components/sweetalert/dist/sweetalert.min.js') !!}
            {!! HTML::script('/js/sb-admin.js') !!}
        @show
    </body>
</html>
