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
        $("#option_add").on('click', function(e) {
            e.preventDefault();
            $("#form_option_add .btn-primary ").css('display', 'block');
            if ($("#option .num_option").length < 2) {
                $("#option  #wrap_data_option").append(option_html);
            } else {
                toastr.error('Không được chọn quá 2 option', {
                    timeOut: 5000
                })
            }
        });

        $(document).on('click', '#form_option_add .option_delete', function(e) {
            e.preventDefault();
            // console.log($(this).closest('.num_option').find('input[name="option_name[]"]').val());
            let url =  $(this).data('url') ?? '';
            if(url.length > 0){
                swal({
                    title: 'Bạn có muốn xóa thuộc tính này không?',
                    type: "question",
                    showCancelButton: true,
                    confirmButtonText:'đồng ý',
                    cancelButtonText: 'hủy bỏ',
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
                                $('#form_option_add').load(location.href + ' #form_option_add');
                                loaderEnd();
                            },
                            error: function(xhr){
                                console.log(xhr);
                                toastr.error('', {timeOut: 5000});
                                loaderEnd();
                            }
                        });
                    }
                })
            }else{
                $(this).closest('.num_option').remove();
            }
                
        });

        $(document).on('change', '.num_option input[name="option_name[]"]', function() {
            let html = ` <span class="text-red">*</span>`;
            $(this).closest('.form-group').find('label').html($(this).val() + html);
        });
        // $(document).on('change', '.num_option input[name="option_value[]"]', function() {
        //     let convertValue = $(this).val().split("|");
        //     convertValue = convertValue.map(function(item) {
        //         return item.trim();
        //     }).filter(function(item) {
        //         return item !== null && item !== undefined && item !== '';
        //     });
        //     $(this).val(JSON.stringify(convertValue));
        // });

        $(document).on('submit', "#form_option_add", function(e) {
            e.preventDefault();
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
                    console.log(response);
                    toastr.success(response.message, {timeOut: 5000});
                    $('#form_option_add').load(location.href + ' #form_option_add');
                    loaderEnd();
                },
                error: function(xhr){
                    console.log(xhr);
                    $('#form_option_add').load(location.href + ' #form_option_add');
                    loaderEnd();
                }
            });
            // var input = $("#form_option_add :input[name='option_name']"); 
            // var input2 = $("#form_option_add :input[name='option_value']"); 
            // console.log(input, input2);
        })

        // product variants
    });
</script>
