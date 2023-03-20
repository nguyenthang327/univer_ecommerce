{{--    method="POST"--}}
<form enctype="multipart/form-data" id="form_option_add">
    <div id="wrap_data_option">
        @if($options)
        @foreach ($options as $key => $option)
            <div class="row num_option">
                <input type="hidden" name="option_id[]" value="{{ $option->id }}">
                <div class="col-4">
                    <div class="form-group">
                        <label>{{ (isset($option->name) ? $option->name : trans('language.option_name')) }} <span class="text-red">*</span></label>
                        <input type="text" class="form-control" placeholder="{{ trans('language.enter_option_name') }}"
                            name="option_name[]" required autocomplete="off"
                            value="{{ old('option_name') ? old('option_name') : (isset($option->name) ? $option->name : '') }}">
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
                            value="{{ old('option_value') ? old('option_value') : (isset($option->optionValue) ? $option->optionValue : '') }}">
                        @if ($errors->first('option_value'))
                            <div class="invalid-alert text-danger">{{ $errors->first('option_value') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-4 align-self-end mb-3">
                    <div class="row d-flex">
                        <button class="btn btn-danger option_delete" data-url="{{route('user.product.deleteOption',[$product->id, $option->id])}}">{{ trans('language.delete') }}</button>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <button class="btn btn-primary mr-2">{{ trans('language.save') }}</button>
</form>