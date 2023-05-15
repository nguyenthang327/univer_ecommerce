@if (isset($datepicker) && $datepicker)
    <link rel="stylesheet" href="{{asset("be-assets/css/bootstrap-datepicker.min.css")}}">
@endif
@if (isset($icheck) && $icheck)
    <link rel="stylesheet" href="{{asset("be-assets/css/icheck-bootstrap.min.css")}}">
@endif
@if (isset($select2) && $select2)
    <link rel="stylesheet" href="{{asset("be-assets/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{asset("be-assets/css/select2-bootstrap4.min.css")}}">
@endif
@if (isset($fancybox) && $fancybox)
    <link rel="stylesheet" href="{{asset("be-assets/css/jquery.fancybox.css")}}">
@endif
@if (isset($summernote) && $summernote)
    <link rel="stylesheet" href="{{asset("be-assets/css/summernote-bs4.min.css")}}">
@endif
@if (isset($swal) && $swal)
    <link rel="stylesheet" href="{{asset("be-assets/css/sweetalert2.min.css")}}">
@endif
@if (isset($dropzone) && $dropzone)
    <link rel="stylesheet" href="{{asset("be-assets/css/dropzone.min.css")}}">
@endif
@if (isset($daterangepicker) && $daterangepicker)
    <link rel="stylesheet" href="{{asset("be-assets/css/daterangepicker.css")}}">
@endif
@if (isset($toastr) && $toastr)
    <link rel="stylesheet" href="{{asset("be-assets/css/toastr.min.css")}}">
@endif
@if (isset($chart) && $chart)
    <link rel="stylesheet" href="{{asset("be-assets/css/Chart.min.css")}}">
@endif
