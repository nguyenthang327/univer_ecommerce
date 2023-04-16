<form method="POST" enctype="multipart/form-data" action="{{ $action }}">
    @if(isset($method))
        @method($method)
    @endif
    @csrf
    <div class="row">
        <div class="col-xl-9 theia-content">
            <div class="card mb-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{trans('language.code')}} <span class="text-red">*</span></label>
                                <input type="text" class="form-control {{$errors->first('code') ? 'is-invalid' : ''}}" name="code" placeholder="{{trans('language.enter_code')}}" required
                                       value="{{old('code') ? old('code') : (isset($coupon->code) ? $coupon->code : '') }}" >
                                @if ($errors->first('code'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('code') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{trans('language.discount')}} <span class="text-red">*</span></label>
                                <input type="number" class="form-control {{$errors->first('discount') ? 'is-invalid' : ''}}" name="discount" placeholder="{{trans('language.enter_discount')}}" required step="0.01" min="0" max="100"
                                       value="{{old('discount') ? old('discount') : (isset($coupon->discount_percentage) ? $coupon->discount_percentage : '') }}" >
                                @if ($errors->first('discount'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('discount') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{trans('language.quantity')}} <span class="text-red">*</span></label>
                                <input type="number" class="form-control {{$errors->first('quantity') ? 'is-invalid' : ''}}" name="quantity" placeholder="{{trans('language.enter_quantity')}}" required min="0"
                                       value="{{old('quantity') ? old('quantity') : (isset($coupon->quantity) ? $coupon->quantity : '') }}" >
                                @if ($errors->first('quantity'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('quantity') }}</div>
                                @endif
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="">{{trans('language.started_at')}} <span class="text-red">*</span></label>
                                <label class="input-group mb-0 ">
                                    <input type="text" class="form-control {{$errors->first('started_at') ? 'is-invalid' : ''}}" data-picker="date" autocomplete="off" name="started_at" placeholder="{{trans('language.started_at')}}" required
                                           value="{{old('started_at') ? old('started_at') : (isset($coupon->started_at) ? (new App\Services\DateFormatService())->dateFormatLanguage($coupon->started_at,'d/m/Y') : '') }}"
                                            >
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </label>
                                @if ($errors->first('started_at'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('started_at') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="">{{trans('language.ended_at')}} <span class="text-red">*</span></label>
                                <label class="input-group mb-0 ">
                                    <input type="text" class="form-control {{$errors->first('ended_at') ? 'is-invalid' : ''}}" data-picker="date" autocomplete="off" name="ended_at" placeholder="{{trans('language.ended_at')}}" required
                                           value="{{old('ended_at') ? old('ended_at') : (isset($coupon->ended_at) ? (new App\Services\DateFormatService())->dateFormatLanguage($coupon->ended_at,'d/m/Y') : '') }}"
                                            >
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </label>
                                @if ($errors->first('ended_at'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('ended_at') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 theia-sidebar">
            <div class="card">
                <div class="card-body align-items-start flex-wrap">
                    <button type="submit" class="btn btn-primary mr-2 my-1"><i class="far fa-save"></i> {{trans('language.save')}}</button>
                    <button type="reset" class="btn btn-outline-secondary"><i class="far fa-undo"></i> {{trans('language.reset')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>