<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') - {{ trans('front.label.title') }}</title>
        @section('css')
            {!! HTML::style('http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600') !!}
            {!! HTML::style('http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300') !!}
            {!! HTML::style('http://fonts.googleapis.com/css?family=Raleway:400,100') !!}
            {!! HTML::style('/bower_components/bootstrap-legacy/dist/css/bootstrap.min.css') !!}
            {!! HTML::style('/bower_components/font-awesome/css/font-awesome.css') !!}
            {!! HTML::style('/bower_components/jquery.rateit/scripts/rateit.css') !!}
            {{ HTML::style('front/css/owl.carousel.css') }}
            {{ HTML::style('front/css/responsive.css') }}
            {{ HTML::style('front/css/style.css') }}
        @show
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        @include('front.includes.header')
        @yield('main')
        @include('front.includes.footer')
        @section('js')
            {!! HTML::script('/bower_components/jquery-legacy/dist/jquery.min.js') !!}
            {!! HTML::script('/bower_components/bootstrap-legacy/dist/js/bootstrap.min.js') !!}
            {!! HTML::script('/bower_components/jquery.rateit/scripts/jquery.rateit.min.js') !!}
            {!! HTML::script('/bower_components/jquery.easing/js/jquery.easing.min.js') !!}
            {!! HTML::script('/bower_components/jquery-sticky/jquery.sticky.js') !!}
            {{ HTML::script('front/js/owl.carousel.min.js') }}
            {{ HTML::script('front/js/main.js') }}
        @show
    </body>
</html>
