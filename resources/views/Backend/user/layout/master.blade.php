<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Google Font: Roboto Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700,800,900&subset=vietnamese">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("be-assets/css/all.min.css") }}">

    <!-- import CSS Library -->
    @yield('css_library')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("be-assets/css/adminlte.min.css") }}">
    <link rel="stylesheet" href="{{ asset("be-assets/css/OverlayScrollbars.min.css") }}">
    <link rel="stylesheet" href="{{ asset("be-assets/css/sweetalert2.min.css") }}">
    <link rel="stylesheet" href="{{ asset("be-assets/css/toastr.min.css") }}">

    <!-- Page style -->
    @yield('css_page')
    <!-- common js -->
    <link rel="stylesheet" href="{{ asset("common/css/common.css") }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed" data-locales="{{app()->getLocale()}}">
@include('backend.user.layout.loader')
<div class="wrapper">
    @include('backend.user.layout.header')
    @include('backend.user.layout.sidebar')
    <div class="content-wrapper">
        @yield('content')
    </div>
@include('backend.user.layout.footer')
<!-- <div id="sidebar-overlay"></div> -->
@include('frontend.modal.modal-change-password', ['typeAccount' => \App\Enums\TypeAccountEnum::ADMIN->value])
</div>


<!-- jQuery -->
<script src="{{ asset("be-assets/js/jquery.min.js") }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset("be-assets/js/bootstrap.bundle.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("be-assets/js/adminlte.js") }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset("be-assets/js/jquery.overlayScrollbars.min.js") }}"></script>
<!-- import JS Library -->
<script src="{{asset("be-assets/js/jquery.validate.min.js")}}"></script>
<!--sweetalert2-->
<script src="{{asset("be-assets/js/sweetalert2.min.js")}}"></script>
<!-- toastr -->
<script src="{{asset("be-assets/js/toastr.min.js")}}"></script>

@yield('js_library')
<!-- Page script -->
@yield('js_page')

<!-- common js -->
<script src="{{ asset("common/js/common.js") }}"></script>

<script type="module">
    // Show alert
    @if(session('status_successed'))
    toastr.success('{{session('status_successed')}}', {timeOut: 5000})
    @elseif(session('status_failed'))
    toastr.error('{{session('status_failed')}}', {timeOut: 5000})
    @endif
</script>

@if($errors->first('new_password') || $errors->first('confirm_password'))
    <script>
        $('#modalChangePassword').modal('show');
    </script>
@endif
</body>
</html>
