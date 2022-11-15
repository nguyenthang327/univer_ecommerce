@if (isset($stickysidebar) && $stickysidebar)
    <script src="{{asset('plugins/theia-sticky-sidebar/theia-sticky-sidebar.js')}}"></script>
@endif
@if (isset($datepicker) && $datepicker)
    <script src="{{asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js')}}"></script>
@endif
@if (isset($select2) && $select2)
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/i18n/vi.js')}}"></script>
@endif
@if (isset($fancybox) && $fancybox)
    <script src="{{asset('plugins/fancybox-2.1.5/jquery.fancybox.js')}}"></script>
@endif
@if (isset($clockpicker) && $clockpicker)
    <script src="{{asset('plugins/clockpicker-seconds/src/clockpicker.js')}}"></script>
    <script src="{{asset(('plugins/moment/moment.min.js'))}}"></script>
@endif
@if (isset($summernote) && $summernote)
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('plugins/summernote/lang/summernote-vi-VN.min.js')}}"></script>
@endif
@if (isset($jsgantt) && $jsgantt)
    <script src="{{asset('plugins/jsgantt-improved/jsgantt.js')}}"></script>
@endif
@if (isset($fullcalendar) && $fullcalendar)
    <script src="{{asset('plugins/fullcalendar/main.min.js')}}"></script>
    <script src="{{asset('plugins/fullcalendar/locales/vi.js')}}"></script>
@endif
@if (isset($swal) && $swal)
    <script src="{{asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
@endif
@if (isset($dropzone) && $dropzone)
    <script src="{{asset('plugins/dropzone/min/dropzone.min.js')}}"></script>
@endif
@if (isset($daterangepicker) && $daterangepicker)
    <script src="{{asset('plugins/bootstrap-daterangepicker/moment.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
@endif
@if (isset($toastr) && $toastr)
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
@endif
@if (isset($chart) && $chart)
    <script src="{{asset('plugins/chart.js/dist/Chart.min.js')}}"></script>
@endif
@if (isset($datetimepicker) && $datetimepicker)
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/moment/locales.js')}}"></script>
    <script src="{{asset('plugins/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js')}}"></script>
@endif
