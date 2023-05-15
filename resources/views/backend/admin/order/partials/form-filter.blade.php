<form action="">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-xl-6 mb-3">
            @php
                $orderStatus = trans('language.order.status');
            @endphp
            <select class="select2-base" data-placeholder="{{ trans('language.status') }}" name="order_status[]" multiple="multiple">
                {{-- <option value=""></option> --}}
                @for($i=0;$i<count($orderStatus);$i++)
                    <option value="{{ $i }}"
                        @if($request->has('order_status') && in_array($i,$request->order_status) && $request->order_status!=null)
                            selected
                        @endif>{{ $orderStatus[$i] }}</option>
                @endfor
            </select>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label class="input-group mb-0 ">
                    <input type="text" class="form-control" data-picker="date" autocomplete="off" name="date" placeholder="{{trans('language.date')}}"
                           value="{{ $request->has('date') && $request->date  ? (new App\Services\DateFormatService())->dateFormatLanguage($request->date,'d/m/Y') : '' }}"
                            >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="far fa-calendar-alt"></span>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 mb-3 icheck-bee">
            <div class="checkbox icheck-danger">
            </div>
        </div>
        <div class="col-sm-6 col-md-6 mb-3 text-right">
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> {{ trans('language.filter') }}</button>
        </div>
    </div>
</form>
