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
                    <li class="active"><a data-toggle="tab" href="#option"> {{ trans('language.options') }}</a></li>
                    <li><a data-toggle="tab" href="#variation">{{ trans('language.variations') }}</a></li>
                </ul>
                <div class="tab-content mt-2">
                    <div id="option" class="tab-pane fade in active show">
                        <h4>{{ trans('language.options') }} <a href="#" id="option_add">{{ trans('language.add') }}</a>
                        </h4>
                        @include('backend.user.product.partials.form-option')
                    </div>
                    <div id="variation" class="tab-pane fade">
                        <h4>{{ trans('language.variations') }}</h4>
                        @include('backend.user.product.partials.form-variation')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
