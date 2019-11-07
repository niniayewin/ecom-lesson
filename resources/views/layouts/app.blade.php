<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Project @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('bts/js/jquery.js') }}"></script>
    <script src="{{asset('bts/js/popper.min.js')}}"></script>
    <script src="{{ asset('bts/js/bootstrap.js') }}"></script>
    <script>
        $(function () {
            setTimeout(function () {
                $(".my-alert").fadeOut()
            },3000)
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

    <!-- Fonts -->
    <!-- Styles -->
    <link href="{{ asset('bts/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('fa/css/all.css') }}" rel="stylesheet">
    <style>
        .my-alert{
            position: absolute;
            right: 20px;
            top: 70px;
        }
    </style>

</head>
<body>
    <div id="app">
        @include('partical.navbar')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
