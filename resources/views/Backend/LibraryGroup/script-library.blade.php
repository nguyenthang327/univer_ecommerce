@if (isset($datepicker) && $datepicker)
    <script src="{{asset("be-assets/js/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("be-assets/js/bootstrap-datepicker.vi.min.js")}}"></script>
@endif
@if (isset($select2) && $select2)
    <script src="{{asset("be-assets/js/select2.full.min.js")}}"></script>
    <script src="{{asset("be-assets/js/select-2 i18n/vi.js")}}"></script>
@endif
@if (isset($fancybox) && $fancybox)
    <script src="{{asset("be-assets/js/jquery.fancybox.js")}}"></script>
@endif
@if (isset($summernote) && $summernote)
    <script src="{{asset("be-assets/js/summernote-bs4.min.js")}}"></script>
    <script src="{{asset("be-assets/js/summernote-vi-VN.min.js")}}"></script>
@endif
@if (isset($swal) && $swal)
    <script src="{{asset("be-assets/js/sweetalert2.min.js")}}"></script>
@endif
@if (isset($dropzone) && $dropzone)
    <script src="{{asset("be-assets/js/dropzone.min.js")}}"></script>
@endif
@if (isset($daterangepicker) && $daterangepicker)
    <script src="{{asset("be-assets/js/moment.min.js")}}"></script>
    <script src="{{asset("be-assets/js/daterangepicker.js")}}"></script>
@endif
@if (isset($toastr) && $toastr)
    <script src="{{asset("be-assets/js/toastr.min.js")}}"></script>
@endif
@if (isset($chart) && $chart)
    <script src="{{asset("be-assets/js/Chart.min.js")}}"></script>
@endif
