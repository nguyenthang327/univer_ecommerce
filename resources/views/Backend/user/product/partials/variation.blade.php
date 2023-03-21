<div class="card mt-4">
    <div class="card-header d-none d-xl-block">
        <h3 class="card-title">
            {{ trans('language.product_varition') }}
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#option"> {{ trans('language.options') }}</a></li>
                    <li class="active"><a data-toggle="tab" href="#variation" class="active">{{ trans('language.variations') }}</a></li>
                </ul>
                <div class="tab-content mt-2">
                    <div id="option" class="tab-pane fade ">
                        <div class="d-flex justify-content-between">
                            <h4>{{ trans('language.options') }}</h4>
                            <a href="#" class="btn bg-info min_w_120" id="option_add">{{ trans('language.add') }}</a>
                        </div>
                        <div id="wrap_form_option">
                            @include('backend.user.product.partials.form-option')
                        </div>
                    </div>
                    <div id="variation" class="tab-pane fade in active show">
                        <div class="d-flex justify-content-between">
                            <h4>{{ trans('language.variations') }}</h4>
                            <a href="#"
                                class="btn bg-info min_w_120 ml-3" 
                                id="variation_generate"
                                data-url = {{ route('user.product.generateVariation',$product->id) }}
                                >
                                {{ trans('language.variation_generate') }}
                            </a>
                        </div>
                        @include('backend.user.product.partials.form-variation')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
