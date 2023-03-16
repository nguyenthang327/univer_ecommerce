<script type="text/javascript">
    $(document).ready(function() {
        let option_html = `
            <div class="row num_option">
                <div class="col-4">
                    <div class="form-group">
                        <label>{{ trans('language.option_name') }} <span class="text-red">*</span></label>
                        <input type="text" class="form-control" placeholder="{{ trans('language.option_name') }}" name="option_name[]" id="option_name" required autocomplete="off" value="{{ old('option_name') ? old('option_name') : '' }}">
                        @if ($errors->first('option_name'))
                            <div class="invalid-alert text-danger">{{ $errors->first('option_name') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>{{ trans('language.option_value') }} <span class="text-red">*</span></label>
                        <input type="text" class="form-control" placeholder="{{ trans('language.option_value') }}" name="option_value[]" id="option_value" required autocomplete="off" value="{{ old('option_value') ? old('option_value') : '' }}">
                        @if ($errors->first('option_value'))
                            <div class="invalid-alert text-danger">{{ $errors->first('option_value') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-2 align-self-end mb-3">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" class="btn btn-primary option_save">{{ trans('language.save') }}</a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-danger option_delete">{{ trans('language.delete') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $("#option_add").on('click', function(e) {
            e.preventDefault();
            if($("#option .num_option").length < 2){
                $("#option").append(option_html);
                $('#option').find("input[name='option_name[]']").val($("#option .num_option").length);
            }else{
                toastr.error('Không được chọn quá 2 option', {timeOut: 5000})
            }
        });

        $(document).on('click', '#option .option_delete', function(e){
            e.preventDefault();
            console.log($(this).closest('.num_option').find('input[name="option_name[]"]').val());
            // $(this).closest('.num_option').remove();
        });
    });
</script>
