@if (isset($products) && count($products) > 0)
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
        <thead class="text-center text-nowrap">
        <tr>
            <th width="5%">@sortablelink('id', trans('language.ordinal_number'))</th>
            <th width="8%">{{trans('language.sku')}}</th>
            <th width="10%">{{trans('language.image')}}</th>
            <th width="20%" style="max-width:400px;">@sortablelink('name', trans('language.product_name'))</th>
            <th width="6%">@sortablelink('product_type', trans('language.variation'))</th>
            <th width="10%">{{trans('language.price')}}</th>
            <th width="8%">@sortablelink('stock', trans('language.stock'))</th>
            <th width="8%">{{trans('language.product_category')}}</th>
            <th width="8%">@sortablelink('brand_id', trans('language.brand'))</th>
            <th width="8%">{{trans('language.status')}}</th>
            <th width="5%">{{trans('language.operation')}}</th>
        </tr>
        </thead>
        <tbody>
            @foreach($products as $idx => $product)
                @php
                    $checkVariant = $product->product_type == \App\Models\Product::TYPE_VARIANT && $product->skus->isNotEmpty();
                    $data = [];
                    if($checkVariant){
                        $data = \App\Services\ProcessPriceService::regularPrice($product->skus[0]['min_price'], $product->skus[0]['max_price'], $product->discount);
                    }else{
                        $data = \App\Services\ProcessPriceService::regularPrice($product->price, $product->discount);
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ ($products->currentPage() - 1) * $products->perPage() + $idx + 1 }}</td>
                    <td class="text-center">{{ $product->sku }}</td>
                    <td class="text-center d-flex">
                        {{-- <a href="{{ isset($product->avatar) ? asset('storage/'. $product->) : asset('images/img-default.png')  }}" class="fancybox2" data-fancybox-group="avatar-list-user" title="ID: {{$user->id}} - {{ $user->full_name }}"> --}}
                            <img src="{{ isset($product->gallery) ? asset('storage/'. $product->gallery[0]['file_path']) : asset('images/no-image.png')  }}"
                                 alt="{{ $product->name }} "
                                 class="default-img product-image-table">
                        {{-- </a> --}}
                    </td>
                    <td class=""><span class="line-clamp-2">{{ $product->name }}</span></td>
                    <td class="text-center">{{ $checkVariant ? trans('language.have') :  trans('language.does_not_have')}}</td>
                    <td class="text-center"> 
                        @if($data['old'] )
                        <del class="old-price">{{ $data['old'] }}</del>
                        @endif
                        <span class="new-price" style="color:#ff6000">{{ $data['new'] }}</span>
                    </td>
                    <td class="text-center">{{ $checkVariant ? $product->skus[0]['total_stock'] : $product->stock }}</td>
                    <td class="text-center">{{ $product->cateogry }}</td>
                    <td class="text-center">{{ $product->brand_name }}</td>
                    <td class="text-center">{{ trans('language.status_s')[$product->status]}}</td>
                    <td class="text-center text-nowrap">
                        <a href="{{ route('user.product.edit',['slug'=> $product->slug]) }}" data-toggle='tooltip' title="{{trans('language.edit')}}" class="text-md text-primary mr-2"><i class="far fa-pen-alt"></i></a>
                        <a href="{{ route('user.product.destroy', ['id'=>$product->id]) }}"
                            data-toggle='tooltip'
                            title="{{trans('language.delete')}}"
                            class="text-md text-danger delete-row-table"
                            data-id="{{ $product->id }}"
                            data-title="{{trans('language.delete_product')}}"
                            data-text="<span class='text-bee'>ID: {{$product->id}}</span> - <strong>{{ $product->name }}</strong>"
                            data-url="{{ route('user.product.destroy', ['id'=>$product->id]) }}"
                            data-method="DELETE"
                            data-icon="question"><i class="far fa-trash-alt"></i>
                        </a>
                        {{-- @if($product->deleted_at == null)
                            <a href="{{ route('admin.user.edit',['id'=>$user->id]) }}" data-toggle='tooltip' title="{{trans('language.edit')}}" class="text-md text-primary mr-2"><i class="far fa-pen-alt"></i></a>
                            <a href="{{ route('admin.user.destroy', ['id'=>$user->id]) }}"
                               data-toggle='tooltip'
                               title="{{trans('language.delete')}}"
                               class="text-md text-danger delete-row-table"
                               data-id="{{ $user->id }}"
                               data-title="{{trans('language.delete_user')}}"
                               data-text="<span class='text-bee'>ID: {{$user->id}}</span> - <strong>{{ $user->full_name }}</strong>"
                               data-url="{{ route('admin.user.destroy', ['id'=>$user->id]) }}"
                               data-method="DELETE"
                               data-icon="question"><i class="far fa-trash-alt"></i></a>
                        @else
                            <a href="{{ route('admin.user.restore', ['id'=>$user->id]) }}"
                                data-toggle='tooltip'
                                title="{{trans('language.restore')}}"
                                class="text-md text-warning delete-row-table"
                                data-id="{{ $user->id }}"
                                data-title="{{ trans('language.restore_user') }}"
                                data-text="<span class='text-bee'>ID: {{$user->id}}</span> - <strong>{{ $user->full_name }}</strong>"
                                data-method="POST"
                                data-url="{{ route('admin.user.restore', ['id'=>$user->id]) }}"
                                data-icon="question"><i class="far fa-redo"></i></a>
                        @endif --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pb-4">
    {{ $products->appends($request->query())->links('Partials.pagination') }}
</div>
@else
    @include('Partials.no-data-found')
@endif
