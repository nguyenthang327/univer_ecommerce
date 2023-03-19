<script type="text/javascript">
    $(document).ready(function() {
        // product option
        let option_html = `
            <div class="row num_option">
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
            console.log($(this).closest('.num_option').find('input[name="option_name[]"]').val());
            $(this).closest('.num_option').remove();
        });

        $(document).on('change', '.num_option input[name="option_name[]"]', function() {
            let html = ` <span class="text-red">*</span>`;
            $(this).closest('.form-group').find('label').html($(this).val() + html);
        });
        $(document).on('change', '.num_option input[name="option_value[]"]', function() {
            let convertValue = $(this).val().split("|");
            convertValue = convertValue.map(function(item) {
                return item.trim();
            }).filter(function(item) {
                return item !== null && item !== undefined && item !== '';
            });
            $(this).val(JSON.stringify(convertValue));
        });

        $(document).on('submit', "#form_option_add", function(e) {
            e.preventDefault();
            let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
            console.log(token);
            var formData = $(this).serialize();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": token,
                },
                url: '/user/product/option', // URL endpoint để xử lý yêu cầu
                type: "POST", // Phương thức yêu cầu HTTP
                data: formData, // Dữ liệu gửi đến máy chủ
                dataType: "JSON",
                success: function(response) {
                    // Xử lý phản hồi từ máy chủ
                    console.log(response);
                }
            })
            // var input = $("#form_option_add :input[name='option_name']"); 
            // var input2 = $("#form_option_add :input[name='option_value']"); 
            // console.log(input, input2);
        })

        // product variants
    });
</script>
