<div class="tab-content mt-2">
    <div id="option" class="tab-pane fade in active show ">
        <div class="d-flex justify-content-between">
            <h4>{{ trans('language.options') }}</h4>
            <a href="#" class="btn bg-info min_w_120" id="option_add">{{ trans('language.add') }}</a>
        </div>
        <div id="wrap_form_option">
            @include('backend.user.product.partials.form-option')
        </div>
    </div>
    <div id="variation" class="tab-pane fade ">
        <div class="d-flex justify-content-between">
            <h4>{{ trans('language.variations') }}</h4>
            {{-- <a href="#"
                class="btn bg-info min_w_120 ml-3" 
                id="variation_generate"
                data-url = {{ route('user.product.generateVariation',$product->id) }}
                >
                {{ trans('language.variation_generate') }}
            </a> --}}
        </div>
        @include('backend.user.product.partials.form-variation')
    </div>
</div>