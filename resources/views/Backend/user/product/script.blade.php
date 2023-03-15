<script type="text/javascript">
    $(document).ready(function() {
        let option_html = `
            <div class="row">
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
                    <button>{{ trans('language.save') }}</button>
                </div>
            </div>
        `;
        $("#option_add").on('click', function(e) {
            e.preventDefault()
            $("#option").append(option_html);
        });

        $("#option_add").on('click', function(e) {
            e.preventDefault()
            $("#option").append(option_html);
        });
    });
</script>
