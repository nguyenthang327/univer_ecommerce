@if (isset($order->orderDetail) && count($order->orderDetail) > 0)
<label class="mt-2 mb-3">{{ trans('language.order.item_list')}}</label>
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
        <thead class="text-center text-nowrap">
        <tr>
            <th width="5%">{{ trans('language.ordinal_number') }}</th>
            <th width="8%">{{trans('language.image')}}</th>
            <th width="15%">{{trans('language.product_name')}}</th>
            <th width="8%">{{trans('language.attribute')}}</th>
            <th width="5%">{{trans('language.price')}}</th>
            <th width="5%">{{trans('language.quantity')}}</th>
            <th width="5%">{{trans('language.subtotal')}}</th>
        </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach($order->orderDetail as $idx => $product)
                <tr>
                    <td class="text-center">{{ ++$idx }}</td>
                    <td class="text-center d-flex">
                        {{-- <a href="{{ isset($product->avatar) ? asset('storage/'. $product->) : asset('images/img-default.png')  }}" class="fancybox2" data-fancybox-group="avatar-list-user" title="ID: {{$user->id}} - {{ $user->full_name }}"> --}}
                            @php
                                $product->gallery = isset($product->gallery) ? json_decode($product->gallery) : null;
                            @endphp
                            <img src="{{ isset($product->gallery) ? asset('storage/'. $product->gallery[0]->file_path) : asset('images/no-image.png')  }}"
                                 alt="{{ $product->name }} "
                                 class="default-img product-image-table">
                        {{-- </a> --}}
                    </td>
                    <td class="text-center">{{ $product->product_name }}</td>
                    <td class="text-center">{{ $product->attribute }}</td>
                    @php
                        $price = \App\Services\ProcessPriceService::regularPrice($product->price, 0);
                        $total += $product->subtotal;
                        $subtotal = \App\Services\ProcessPriceService::regularPrice($product->subtotal, 0);
                    @endphp
                    <td class="text-center">{{$price['new']}}</td>
                    <td class="text-center">{{ $product->quantity }}</td>
                    <td class="text-center">{{$subtotal['new']}}</td>
                </tr>
            @endforeach
            <tr>
                <td class="text-center">{{ trans('language.subtotal') }}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                @php
                    $subtotal = \App\Services\ProcessPriceService::regularPrice($total, 0);
                @endphp
                <td class="text-center">{{$subtotal['new']}}</td>
            </tr>
            <tr>
                <td class="text-center">{{ trans('language.coupon') }}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">{{$order->discount_percentage ? $order->discount_percentage . '%' : '_'}}</td>
            </tr>
            <tr>
                <td class="text-center">{{ trans('language.total') }}</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                @php
                    $total = \App\Services\ProcessPriceService::regularPrice($total, $order->discount_percentage);
                @endphp
                <td class="text-center">{{$total['new']}}</td>
            </tr>
        </tbody>
    </table>
</div>
@else
    @include('Partials.no-data-found')
@endif
