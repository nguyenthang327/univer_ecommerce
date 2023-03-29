<form action="">
    <div class="row">
        <div class="col-sm-8 col-md-5 col-xl-4 mb-3">
            <input type="text" class="form-control" placeholder="{{ trans('language.product_keyword') }}" name="keyword"
                   @if($request->has('keyword')) value="{{ $request->keyword}}" @endif>
        </div>
        <div class="col-sm-4 col-md-3 col-xl-2 mb-3">
            <select class="select2-base" data-placeholder="{{ trans('language.by_category') }}" name="categories_id[]" multiple="multiple">
                @foreach($categories as $category)
                    <option value="{{ $category["id"] }}"
                        @if($request->has('categories_id') && in_array($category["id"], $request->categories_id))
                            selected
                        @endif>{{ $category["name"] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 mb-3 icheck-bee">
            {{-- <div class="checkbox icheck-danger">
                <input type="checkbox" name="deleted" id="deleted" @if($request->has('deleted')) checked @endif/>
                <label for="deleted">{{trans('language.filter_by_retired_user')}}</label>
            </div> --}}
        </div>
        <div class="col-sm-6 col-md-6 mb-3 text-right">
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> {{ trans('language.filter') }}</button>
        </div>
    </div>
</form>
