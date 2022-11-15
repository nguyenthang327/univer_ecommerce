
@if (isset($datepicker) && $datepicker)
    <link rel="stylesheet" href="{{asset('"be-assets/css/bootstrap-datepicker.min.css')}}">
@endif
@if (isset($icheck) && $icheck)
    <link rel="stylesheet" href="{{asset('"be-assets/css/icheck-bootstrap.min.css')}}">
@endif
@if (isset($select2) && $select2)
    <link rel="stylesheet" href="{{asset('"be-assets/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('"be-assets/css/select2-bootstrap4.min.css')}}">
@endif
@if (isset($fancybox) && $fancybox)
    <link rel="stylesheet" href="{{asset('"be-assets/css/jquery.fancybox.css')}}">
@endif
@if (isset($clockpicker) && $clockpicker)
    <link rel="stylesheet" href="{{asset('plugins/clockpicker-seconds/dist/jquery-clockpicker.css')}}">
@endif
@if (isset($summernote) && $summernote)
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
@endif
@if (isset($jsgantt) && $jsgantt)
    <link rel="stylesheet" href="{{asset('plugins/jsgantt-improved/jsgantt.css')}}">
@endif
@if (isset($fullcalendar) && $fullcalendar)
    <link rel="stylesheet" href="{{asset('plugins/fullcalendar/main.min.css')}}">
@endif
@if (isset($swal) && $swal)
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.min.css')}}">
@endif
@if (isset($dropzone) && $dropzone)
    <link rel="stylesheet" href="{{asset('plugins/dropzone/min/dropzone.min.css')}}">
@endif
@if (isset($daterangepicker) && $daterangepicker)
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-daterangepicker/daterangepicker.css')}}">
@endif
@if (isset($toastr) && $toastr)
    <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
@endif
@if (isset($chart) && $chart)
    <link rel="stylesheet" href="{{asset('plugins/chart.js/dist/Chart.min.css')}}">
@endif
@if (isset($datetimepicker) && $datetimepicker)
    <link rel="stylesheet" href="{{asset('plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}">
@endif
