<div class="card mt-4">
    <div class="card-header d-none d-xl-block">
        <h3 class="card-title">
            {{ trans('language.product_varition') }}
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#option"> {{ trans('language.options') }}</a></li>
                    <li><a data-toggle="tab" href="#variation">{{ trans('language.variations') }}</a></li>
                </ul>
                <div class="tab-content mt-2">
                    <div id="option" class="tab-pane fade in active show">
                        <h4>{{ trans('language.options') }} <a href="#" id="option_add">{{ trans('language.add') }}</a>
                        </h4>
                        {{-- <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>{{ trans('language.option_name') }} <span class="text-red">*</span></label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ trans('language.option_name') }}" name="option_name[]"
                                        id="option_name" required autocomplete="off"
                                        value="{{ old('option_name') ? old('option_name') : (isset($product->name) ? $product->name : '') }}">
                                    @if ($errors->first('option_name'))
                                        <div class="invalid-alert text-danger">{{ $errors->first('option_name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>{{ trans('language.option_value') }} <span class="text-red">*</span></label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ trans('language.option_value') }}" name="option_value[]"
                                        id="option_value" required autocomplete="off"
                                        value="{{ old('option_value') ? old('option_value') : (isset($product->name) ? $product->name : '') }}">
                                    @if ($errors->first('option_value'))
                                        <div class="invalid-alert text-danger">{{ $errors->first('option_value') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-2 align-self-end mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-primary">{{ trans('language.save') }}</button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-danger">{{ trans('language.delete') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div id="variation" class="tab-pane fade">
                        <h4>{{ trans('language.variations') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
