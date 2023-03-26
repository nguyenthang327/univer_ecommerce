<script type="text/javascript">
    $(document).ready(function() {
        // product option
        if($("#form_option_add .num_option").length === 0){
            $("#form_option_add .btn-primary ").css('display', 'none');
        }
        let option_html = `
            <div class="row num_option">
                <input type="hidden" name="option_id[]" value="" >
                <div class="col-4">
                    <div class="form-group">
                        <label>{{ trans('language.option_name') }} <span class="text-red">*</span></label>
                        <input type="text" class="form-control" placeholder="{{ trans('language.enter_option_name') }}" name="option_name[]" required autocomplete="off" value="{{ old('option_name') ? old('option_name') : '' }}">
                        @if ($errors->first('option_name'))
                            <div class="invalid-alert text-danger">{{ $errors->first('option_name') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>{{ trans('language.option_value') }} <span class="text-red">*</span></label>
                        <input type="text" class="form-control" placeholder="{{ trans('language.enter_option_value') }}" name="option_value[]" required autocomplete="off" value="{{ old('option_value') ? old('option_value') : '' }}">
                        @if ($errors->first('option_value'))
                            <div class="invalid-alert text-danger">{{ $errors->first('option_value') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-2 align-self-end mb-3">
                    <div class="row">
                        <a href="#" class="btn btn-danger option_delete">{{ trans('language.delete') }}</a>
                    </div>
                </div>
            </div>
        `;
        $(document).on('click', '#option_add', function(e) {
            e.preventDefault();
            $("#form_option_add .btn-primary ").css('display', 'block');
            if ($("#option .num_option").length < 2) {
                $("#option  #wrap_data_option").append(option_html);
            } else {
                toastr.error(`{{ trans('language.max_option') }}`, {
                    timeOut: 5000
                })
            }
        });

        $(document).on('click', '#form_option_add .option_delete', function(e) {
            e.preventDefault();
            let url =  $(this).data('url') ?? '';
            if(url.length > 0){
                swal({
                    title: `{{ trans('language.QA_delete_option') }}`,
                    type: "question",
                    showCancelButton: true,
                    confirmButtonText: `{{ trans('language.agree') }}`,
                    cancelButtonText: `{{ trans('language.cancel') }}`,
                }).then((result) => {
                    if (result.value) {
                        let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
                        loaderStart();
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": token,
                            },
                            url: url,
                            type: "DELETE",
                            dataType: "JSON",
                            success: function(response) {
                                toastr.success(response.message, {timeOut: 5000});
                                // $('#wrap_form_option').load(location.href + ' #form_option_add');
                                $('#wrap_option_and_variant').html(response.html);
                                loaderEnd();
                            },
                            error: function(xhr){
                                toastr.error(xhr.responseJSON.message, {timeOut: 5000});
                                loaderEnd();
                            }
                        });
                    }
                })
            }else{
                $(this).closest('.num_option').remove();
                
            }

            if($("#form_option_add .num_option").length === 0){
                $("#form_option_add .btn-primary ").css('display', 'none');
            }
        });

        $(document).on('change', '.num_option input[name="option_name[]"]', function() {
            let html = ` <span class="text-red">*</span>`;
            $(this).closest('.form-group').find('label').html($(this).val() + html);
        });

        $(document).on('submit', "#form_option_add", function(e) {
            e.preventDefault();
            swal({
                    title: `{{ trans('language.QA_save_option') }}`,
                    html: `{{ trans('language.QA_save_option_2') }}`,
                    type: "question",
                    showCancelButton: true,
                    confirmButtonText: `{{ trans('language.agree') }}`,
                    cancelButtonText: `{{ trans('language.cancel') }}`,
                }).then((result) => {
                    if (result.value) {
                        let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
                        var formData = $(this).serialize();
                        loaderStart();
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": token,
                            },
                            url: '/user/product/option/' + {{$product->id}},
                            type: "POST",
                            data: formData,
                            dataType: "JSON",
                            success: function(response) {
                                toastr.success(response.message, {timeOut: 5000});
                                $('#wrap_option_and_variant').html(response.html);
                                loaderEnd();
                            },
                            error: function(xhr){
                                toastr.error(xhr.responseJSON.message, {timeOut: 5000});
                                loaderEnd();
                            }
                        });
                    }
                })
        });

        // product variants

        // $(document).on('click', '#variation_generate', function(e){
        //     e.preventDefault();
        //     let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
        //     // loaderStart();
        //     let url = $(this).data('url');
        //     $.ajax({
        //         headers: {
        //             "X-CSRF-TOKEN": token,
        //         },
        //         url: url,
        //         type: "POST",
        //         success: function(response) {
        //             console.log(response);
        //             // toastr.success(response.message, {timeOut: 5000});
        //             // $('#wrap_form_option').html(response.html);
        //             loaderEnd();
        //         },
        //         error: function(xhr){
        //             console.log(xhr);
        //             // $('#wrap_form_option').load(location.href + ' #form_option_add');
        //             loaderEnd();
        //         }
        //     });
        // });

        // product sku
        $(document).on('submit', '#form_update_sku', function(e){
            e.preventDefault();
            // let da = $(this).find('tr');
            // console.log(da);
            let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
            let url = $(this).attr('action');
    
            if(url && $(this).valid()){
                var formData = $(this).serialize();
                loaderStart();
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": token,
                    },
                    url: url,
                    type: "PUT",
                    data: formData,
                    dataType: "JSON",
                    success: function(response) {
                        toastr.success(response.message, {timeOut: 5000});
                        $('#wrap_data_sku').load(location.href + ' #wrap_data_sku .table-responsive');
                        loaderEnd();
                    },
                    error: function(xhr){
                        let errors = '';
                        $.each(xhr.responseJSON.errors, function(key, value){
                            $.each(value, function(index, item) {
                                errors += '<p>' + item + '</p>'
                            });
                        })
                        toastr.error(errors, {timeOut: 5000});
                        $('#wrap_data_sku').load(location.href + ' #wrap_data_sku .table-responsive');
                        loaderEnd();
                    }
                });
            }
        });
    });
</script>
