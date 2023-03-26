<div class="card mt-4">
    <div class="card-header d-none d-xl-block">
        <div class="row">
            <h4 class="">{{ trans('language.product_type') }}</h4>
            <div class="col-4">
                <select class="select2-base-no-clear"
                    style="width: 100%"
                    data-placeholder="{{trans('language.choose_type_product')}}"
                    name="product_type"
                    >
                    <option value="{{ \App\Models\Product::TYPE_REGULAR }}" selected>
                        {{ trans('language.product_not_variation') }}
                    </option>
                    <option value="{{ \App\Models\Product::TYPE_VARIANT }}">
                        {{ trans('language.product_variation') }}
                    </option>
                @php
                    $chooseCategory = old('product_type') ? old('product_type') : (isset($category->id) ? $category->id:'');
                @endphp
                @if(isset($categories))
                    @foreach($categories as $key => $val)
                        <option value="{{ $key }}" {{ $chooseCategory == $key ? 'selected' : '' }}>
                            {{ $val }}
                        </option>
                    @endforeach
                @endif
                </select>
                @if ($errors->first('product_type'))
                    <div class="invalid-alert text-danger">{{ $errors->first('product_type') }}</div>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs">
                    <li ><a data-toggle="tab" href="#option"> {{ trans('language.options') }}</a></li>
                    <li  class="active"><a data-toggle="tab" href="#variation"  class="active">{{ trans('language.variations') }}</a></li>
                </ul>
                <div id="wrap_option_and_variant">
                    @include('backend.user.product.partials.variant-content')
                </div>
            </div>
        </div>
    </div>
</div>
