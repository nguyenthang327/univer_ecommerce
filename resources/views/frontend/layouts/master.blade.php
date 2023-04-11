<!doctype html>
<html class="no-js" lang="vi">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>

         <!-- Google Font: Roboto Pro -->
        <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700,800,900&subset=vietnamese">

		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
        <!-- Place favicon.ico in the root directory -->

		<!-- CSS here -->
        <link rel="stylesheet" href="{{ asset('fe-assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/animate.min.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/magnific-popup.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/fontawesome-all.min.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/jquery-ui.min.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/flaticon.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/odometer.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/aos.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/slick.css')}}">
        <link rel="stylesheet" href="{{ asset("be-assets/css/toastr.min.css") }}">

        <link rel="stylesheet" href="{{ asset('fe-assets/css/default.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/style.css')}}">
        <link rel="stylesheet" href="{{ asset('fe-assets/css/responsive.css')}}">

        <!-- import CSS Library -->
        @yield('css_library')

        <!-- Page style -->
        @yield('css_page')
    </head>
    <body data-locales="{{app()->getLocale()}}">

        <!-- preloader  -->
        {{-- @include('frontend.layouts.preloader') --}}
        <!-- preloader end -->

        <!-- Scroll-top -->
        <button class="scroll-top scroll-to-target" data-target="html">
            <i class="fas fa-angle-up"></i>
        </button>
        <!-- Scroll-top-end-->

        <!-- header-area -->
        @include('frontend.layouts.header')
        <!-- header-area-end -->
        {{-- @dd($globalProductCategories) --}}

        <!-- main-area -->
        <main>
           @yield('content')
        </main>
        <!-- main-area-end -->

        <!-- footer-area -->
        @include('frontend.layouts.footer')
        <!-- footer-area-end -->

		<!-- JS here -->
        <script src="{{ asset('fe-assets/js/vendor/jquery-3.5.0.min.js')}}"></script>
        <script src="{{ asset('fe-assets/js/popper.min.js')}}"></script>
        <script src="{{ asset('fe-assets/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('fe-assets/js/isotope.pkgd.min.js')}}"></script>
        <script src="{{ asset('fe-assets/js/imagesloaded.pkgd.min.js')}}"></script>
        <script src="{{ asset('fe-assets/js/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{ asset('fe-assets/js/owl.carousel.min.js')}}"></script>
        <script src="{{ asset('fe-assets/js/jquery.odometer.min.js')}}"></script>
        <script src="{{ asset('fe-assets/js/jquery.countdown.min.js')}}"></script>
        <script src="{{ asset('fe-assets/js/jquery.appear.js')}}"></script>
        <script src="{{ asset('fe-assets/js/slick.min.js')}}"></script>
        {{-- <script src="{{ asset('fe-assets/js/ajax-form.js')}}"></script> --}}
        <script src="{{ asset('fe-assets/js/wow.min.js')}}"></script>
        <script src="{{ asset('fe-assets/js/aos.js')}}"></script>
        <script src="{{asset("be-assets/js/jquery.validate.min.js")}}"></script>
        <script src="{{asset("be-assets/js/toastr.min.js")}}"></script>
        <script src="{{ asset('fe-assets/js/plugins.js')}}"></script>
        <script src="{{ asset('fe-assets/js/main.js')}}"></script>

        @yield('js_library')
        <!-- Page script -->
        @yield('js_page')

        <script type="module">
            // Show alert
            @if(session('status_successed'))
            toastr.success('{{session('status_successed')}}', {timeOut: 5000})
            @elseif(session('status_failed'))
            toastr.error('{{session('status_failed')}}', {timeOut: 5000})
            @endif
        </script>
    </body>
</html>
