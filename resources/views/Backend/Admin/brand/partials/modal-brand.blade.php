<div class="modal-brand modal fade" id="modalBrand" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" action="{{ $action }}" method="POST" enctype="multipart/form-data" id="subFormBrand">
                @if(isset($method))
                    @method($method)
                @endif
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('language.add_brand')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">{{trans('language.logo')}}</label>
                                <div class="text-center">
                                    <div class="form-image">
                                        <img
                                            src="{{ isset($brand->logo) ? asset('storage/'. $brand->logo) : asset('images/no-image.png')  }}"
                                            class="form-image__view form-logo__view"
                                            id="brand_logo_view"
                                            alt="preview image"
                                        >
                                        <input type="file"
                                            class="form-image__file"
                                            id="brand_logo"
                                            accept=".png, .jpg, .jpeg, .gif"
                                            data-origin="{{isset($brand->logo)? asset('storage/'. $brand->logo) : asset('images/no-image.png')}}"
                                            name="brand_logo">
                                        <label for="brand_logo" class="form-image__label"><i class="fas fa-pen"></i></label>
                                    </div>
                                    @if ($errors->first('brand_logo'))
                                        <div class="invalid-alert text-danger">{{ $errors->first('brand_logo') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ trans('language.brand_name') }} <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="{{ trans('language.enter_brand_name') }}" name="brand_name" required autocomplete="off" value="{{ old('brand_name') ? old('brand_name') : (isset($brand->name) ? $brand->name : '')}}">
                                @if ($errors->first('brand_name'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('brand_name') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="select-member">{{ trans('language.agree') }}</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ trans('language.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>