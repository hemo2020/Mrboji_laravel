<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title', config('app.name'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <link rel="icon" type="image/x-icon" href="{{asset('assets/images/logo-icon.png')}}">

{{--    <link rel="stylesheet" href="{{ mix('plugin/fontawesome/css/all.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin_custom.css') }}">
{{--    <script src="{{ asset('js/app.js') }}"></script>--}}

    @yield('styles')

</head>
    <body class="hold-transition theme">
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="{{asset('assets/images/logo-icon.png')}}" alt="AdminLTELogo" style="height: 100px; width: auto;">
            </div>

            @include('components.top-header')

            @include('components.sidebar')

            <!-- Content Wrapper. Contains page content -->
            @yield('content')
            <!-- /.content-wrapper -->

            <footer class="main-footer no-print">
                <strong>Copyright &copy; 2014-2019 <a href="https://cmwebsolution.com" target="_blanks">CM Websolution</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Crafted with <i class="fa fa-heart text-red"></i></b> By CM Websolution
                </div>
            </footer>

            <div class="modal fade loadModal" tabindex="-1" role="dialog" id="loadModal" data-keyboard="true" aria-labelledby="loadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="loadModalLabel"></h4>
                            <input type="hidden" id="modal_type">
                            <button type="button" class="close" id="close_modal" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('js/adminlte.min.js') }}"></script>
        <script src="{{ asset('js/select2.full.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
        <script src="{{ asset('js/bootbox.all.min.js') }}"></script>
        <script>
            var loadNotificationUrl = '{{route('admin.load-notifications')}}';
        </script>
        <script src="{{ asset('js/common.js') }}"></script>
        @yield('scripts')
        @stack('page-scripts')
    </body>
</html>

