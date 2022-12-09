<form action="">
    <div class="row">
        <div class="col-sm-4 col-md-2 col-xl-2 mb-3">
            <input type="text" class="form-control" placeholder="{{ trans('language.by_id') }}" name="id"
                   @if($request->has('id')) value="{{ $request->id}}" @endif>
        </div>
        <div class="col-sm-8 col-md-5 col-xl-4 mb-3">
            <input type="text" class="form-control" placeholder="{{ trans('language.by_fullname') }}" name="keyword"
                   @if($request->has('keyword')) value="{{ $request->keyword}}" @endif>
        </div>
        <div class="col-sm-6 col-md-5 col-xl-3 mb-3">
            <label class="input-group mb-0">
                <input type="text" class="form-control" placeholder="{{ trans('language.by_email') }}" name="email"
                       @if($request->has('email')) value="{{ $request->email}}" @endif>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="far fa-envelope"></span>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-sm-6 col-md-5 col-xl-3 mb-3">
            <label class="input-group mb-0">
                <input type="text" class="form-control" placeholder="{{ trans('language.by_phone') }}" name="phone"
                       @if($request->has('phone')) value="{{ $request->phone}}" @endif>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="far fa-phone"></span>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-sm-4 col-md-3 col-xl-2 mb-3">
            @php
                $genders = trans('language.genders');
            @endphp
            <select class="select2-base" data-placeholder="{{ trans('language.by_gender') }}" name="gender[]" multiple="multiple">
                <option value=""></option>
                @for($i=0;$i<count($genders);$i++)
                    <option value="{{ $i }}"
                        @if($request->has('gender') && in_array($i,$request->gender) && $request->gender!=null)
                            selected
                        @endif>{{ $genders[$i] }}</option>
                @endfor
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 mb-3 icheck-bee">
            <div class="checkbox icheck-danger">
                <input type="checkbox" name="deleted" id="deleted" @if($request->has('deleted')) checked @endif/>
                <label for="deleted">{{trans('language.filter_by_retired_user')}}</label>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 mb-3 text-right">
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> {{ trans('language.filter') }}</button>
        </div>
    </div>
</form>
