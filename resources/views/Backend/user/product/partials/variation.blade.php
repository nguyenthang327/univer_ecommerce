<div class="card mt-4 card_product_type">
    <div class="card-header d-none d-xl-block">
        <div class="row">
            <h4 class="">{{ trans('language.product_type') }}</h4>
            <div class="col-4">
                <select class="select2-base-no-clear" style="width: 100%"
                    data-placeholder="{{ trans('language.choose_type_product') }}" name="product_type" id="choose_type"
                    data-url="{{ route('user.product.updateTypeProduct', ['id' => $product->id]) }}">
                    <option value="{{ \App\Models\Product::TYPE_REGULAR }}" selected>
                        {{ trans('language.product_not_variation') }}
                    </option>
                    <option value="{{ \App\Models\Product::TYPE_VARIANT }}"
                        {{ $product->product_type == \App\Models\Product::TYPE_VARIANT ? 'selected' : '' }}>
                        {{ trans('language.product_variation') }}
                    </option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-body card-wrap-data {{ $product->product_type == \App\Models\Product::TYPE_VARIANT ? 'd-block' : 'd-none' }}">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#option" class="active"> {{ trans('language.options') }}</a></li>
                    <li><a data-toggle="tab" href="#variation">{{ trans('language.variations') }}</a></li>
                </ul>
                <div id="wrap_option_and_variant">
                    @include('backend.user.product.partials.variant-content')
                </div>
            </div>
        </div>
    </div>
</div>
