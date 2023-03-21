@foreach ($data as $idx => $category)
    <tr>
        <td class="text-center">
            
        </td>
        <td>
            <div class="form-group mb-1">
                <label class="input-group mb-1 ">
                    <input type="text" class="form-control" placeholder="{{ trans('language.enter_price') }}"
                        name="variant_price[]" autocomplete="off"
                        value="{{ old('variant_price') ? old('variant_price') : (isset($product->name) ? $product->name : '') }}">
                    @if ($errors->first('variant_price'))
                        <div class="invalid-alert text-danger">
                            {{ $errors->first('variant_price') }}</div>
                    @endif
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-dollar-sign"></span>
                        </div>
                    </div>
                </label>
            </div>
        </td>
        <td>
            <div class="form-group mb-1">
                <input type="text" class="form-control" placeholder="{{ trans('language.enter_stock') }}"
                    name="variant_stock[]" autocomplete="off"
                    value="{{ old('variant_stock') ? old('variant_stock') : (isset($product->name) ? $product->name : '') }}">
                @if ($errors->first('variant_stock'))
                    <div class="invalid-alert text-danger">
                        {{ $errors->first('variant_stock') }}</div>
                @endif
            </div>
        </td>
        <td >
            <div class="form-group mb-1">
                <input type="text" class="form-control" placeholder="{{ trans('language.enter_sku') }}"
                    name="variant_sku[]" autocomplete="off"
                    value="{{ old('variant_sku') ? old('variant_sku') : (isset($product->name) ? $product->name : '') }}">
                @if ($errors->first('variant_sku'))
                    <div class="invalid-alert text-danger">
                        {{ $errors->first('variant_sku') }}</div>
                @endif
            </div>
        </td>
        <td class="text-center">
            <a href="#" class="btn bg-danger delete-variation">{{ trans('language.delete')}}</a>
        </td>
    </tr>
@endforeach
