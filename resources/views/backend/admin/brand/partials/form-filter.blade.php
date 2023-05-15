<form action="">
    <div class="row">
        <div class="col-sm-8 col-md-5 col-xl-4 mb-3">
            <input type="text" class="form-control" placeholder="{{ trans('language.by_brand_name') }}" name="keyword"
                   @if($request->has('keyword')) value="{{ $request->keyword}}" @endif>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 mb-3">
        </div>
        <div class="col-sm-6 col-md-6 mb-3 text-right">
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> {{ trans('language.filter') }}</button>
        </div>
    </div>
</form>
