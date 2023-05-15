@if ($skus->isNotEmpty())
    <form method="POST" enctype="multipart/form-data" action="{{ route('user.product.updateSku',['productId' => $product->id])}}" id="form_update_sku" class="mt-3">
        @method('PUT')
        <div id="wrap_data_sku">
            <div class="table-responsive">
                <table
                    class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
                    <thead class="text-center text-nowrap">
                        <tr>
                            <th width="15%">{{ trans('language.variation') }}</th>
                            <th width="25%">{{ trans('language.price') }}</th>
                            <th width="20%">{{ trans('language.stock') }}</th>
                            <th width="25%">{{ trans('language.sku') }}</th>
                            {{-- <th width="25%">{{ trans('language.barcode') }}</th> --}}
                            <th width="15%">{{ trans('language.action') }}</th>
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
