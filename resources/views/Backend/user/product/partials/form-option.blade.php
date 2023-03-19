{{--  action="{{ $action }}"  method="POST"--}}
<form  enctype="multipart/form-data" id="form_option_add">
    <div id="wrap_data_option">
        <div class="row num_option">
            <div class="col-4">
                <div class="form-group">
                    <label>{{ trans('language.option_name') }} <span class="text-red">*</span></label>
                    <input type="text" class="form-control" placeholder="{{ trans('language.enter_option_name') }}"
                        name="option_name[]" required autocomplete="off"
                        value="{{ old('option_name') ? old('option_name') : (isset($product->name) ? $product->name : '') }}">
                    @if ($errors->first('option_name'))
                        <div class="invalid-alert text-danger">{{ $errors->first('option_name') }}</div>
                    @endif
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>{{ trans('language.option_value') }} <span class="text-red">*</span></label>
                    <input type="text" class="form-control" placeholder="{{ trans('language.enter_option_value') }}"
                        name="option_value[]" required autocomplete="off"
                        value="{{ old('option_value') ? old('option_value') : (isset($product->name) ? $product->name : '') }}">
                    @if ($errors->first('option_value'))
                        <div class="invalid-alert text-danger">{{ $errors->first('option_value') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-4 align-self-end mb-3">
                <div class="row d-flex">
                    <button class="btn btn-danger option_delete">{{ trans('language.delete') }}</button>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary mr-2">{{ trans('language.save') }}</button>
</form>