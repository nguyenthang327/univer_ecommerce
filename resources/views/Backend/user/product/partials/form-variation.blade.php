@php
    $data = [1, 2, 3, 4, 1];
@endphp
@if (isset($data))
    <form method="POST" enctype="multipart/form-data" action="{{ $action }}" id="form_variation_add">
        <div id="wrap_data_option">
            <div class="table-responsive">
                <table
                    class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
                    <thead class="text-center text-nowrap">
                        <tr>
                            <th width="10%">{{ trans('language.variants') }}</th>
                            <th width="20%">{{ trans('language.price') }}</th>
                            <th width="20%">{{ trans('language.stock') }}</th>
                            <th width="25%">{{ trans('language.sku') }}</th>
                            <th width="25%">{{ trans('language.barcode') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('backend.user.product.partials.table-variation')
                    </tbody>
                </table>
            </div>
        </div>

        <button class="btn btn-primary mr-2">{{ trans('language.save') }}</button>
    </form>
@endif
