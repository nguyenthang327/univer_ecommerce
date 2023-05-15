<form action="">
    <div class="row">
        <div class="col-sm-8 col-md-5 col-xl-4 mb-3">
            <input type="text" class="form-control" placeholder="{{ trans('language.code') }}" name="keyword"
                   @if($request->has('keyword')) value="{{ $request->keyword}}" @endif>
        </div>
        <div class="col-sm-8 col-md-5 col-xl-4 mb-3">
            <input type="text" class="form-control" placeholder="{{ trans('language.quantity') }}" name="discount"
                   @if($request->has('discount')) value="{{ $request->discount}}" @endif>
        </div>
        {{-- <div class="col-sm-6 col-md-5 col-xl-3 mb-3">
            <label class="input-group mb-0">
                <input type="text" class="form-control" placeholder="{{ trans('language.by_phone') }}" name="phone"
                       @if($request->has('phone')) value="{{ $request->phone}}" @endif>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="far fa-phone"></span>
                    </div>
                </div>
            </label>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 mb-3 icheck-bee">
            <div class="checkbox icheck-danger">
                {{-- <input type="checkbox" name="deleted" id="deleted" @if($request->has('deleted')) checked @endif/>
                <label for="deleted">{{trans('language.filter_by_retired_user')}}</label> --}}
            </div>
        </div>
        <div class="col-sm-6 col-md-6 mb-3 text-right">
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> {{ trans('language.filter') }}</button>
        </div>
    </div>
</form>
