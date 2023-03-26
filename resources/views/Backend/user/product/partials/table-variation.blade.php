@foreach ($skus as $sku)
    <tr>
        <input type="hidden" name="sku_id[]" value="{{$sku->id}}" >
        <td class="text-center">
            @foreach($sku->variants as $key => $variant)
                {{ $variant->optionValue }}
            @endforeach
        </td>
        <td>
            <div class="form-group mb-1">
                <label class="input-group mb-1 ">
                    <input type="number" class="form-control" placeholder="{{ trans('language.enter_price') }}"
                        name="sku_price[]" autocomplete="off"
                        value="{{ old('sku_price') ? old('sku_price') : (isset($sku->price) ? $sku->price : '') }}"
                        min="0">
                    @if ($errors->first('sku_price'))
                        <div class="invalid-alert text-danger">
                            {{ $errors->first('sku_price') }}</div>
                    @endif
                    <div class="input-group-append">
                        <div class="input-group-text">
                            {{-- <span class="fas fa-dollar-sign"></span> --}}<span>VND</span>
                        </div>
                    </div>
                </label>
            </div>
        </td>
        <td>
            <div class="form-group mb-1">
                <input type="number" class="form-control" placeholder="{{ trans('language.enter_stock') }}"
                    name="sku_stock[]" autocomplete="off"
                    value="{{ old('sku_stock') ? old('sku_stock') : (isset($sku->stock) ? $sku->stock : '') }}"
                    min="0">
                @if ($errors->first('sku_stock'))
                    <div class="invalid-alert text-danger">
                        {{ $errors->first('sku_stock') }}</div>
                @endif
            </div>
        </td>
        <td >
            <div class="form-group mb-1">
                <input type="text" class="form-control slug_sku" placeholder="{{ trans('language.enter_sku') }}"
                    name="sku_name[]" autocomplete="off"
                    value="{{ old('sku_name') ? old('sku_name') : (isset($sku->name) ? $sku->name : '') }}">
                @if ($errors->first('sku_name'))
                    <div class="invalid-alert text-danger">
                        {{ $errors->first('sku_name') }}</div>
                @endif
            </div>
        </td>
        <td class="text-center">
            <a href="#" class="btn bg-danger delete-sku">{{ trans('language.delete')}}</a>
        </td>
    </tr>
@endforeach
