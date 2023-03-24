<div class="card mt-4">
    <div class="card-header d-none d-xl-block">
        <h3 class="card-title">
            {{ trans('language.product_variation') }}
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs">
                    <li  class="active"><a data-toggle="tab" href="#option" class="active"> {{ trans('language.options') }}</a></li>
                    <li><a data-toggle="tab" href="#variation" >{{ trans('language.variations') }}</a></li>
                </ul>
                <div id="wrap_option_and_variant">
                    @include('backend.user.product.partials.variant-content')
                </div>
            </div>
        </div>
    </div>
</div>
