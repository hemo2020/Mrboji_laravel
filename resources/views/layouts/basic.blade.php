<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <meta name="robots" content="noindex">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
{{--    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">--}}
    <!-- icheck bootstrap -->
{{--    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">--}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css')}}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
    <body class="hold-transition">
        @yield('content')
    </body>
</html>

