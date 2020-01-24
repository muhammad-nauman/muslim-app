<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Muslim App | @yield('title')</title>

    <link href="{{ url('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    @yield('css')
    <link href="{{ url('/css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('/css/style.css') }}" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
        @include('nav')
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                @include('nav-head')
            </div>
            <div class="wrapper wrapper-content">
                @yield('content')
            </div>
        </div>
    </div>
</body>

@yield('script_files')
@yield('script_code')

</html>