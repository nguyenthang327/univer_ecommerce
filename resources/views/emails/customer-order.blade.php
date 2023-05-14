<table 
    align="center" 
    border="0"
    cellpadding="0"
    cellspacing="0"
    width="100%"
>
    {{-- <tr>
        <td align="center" bgcolor="#70bbd9" style="padding: 10px 0 30px 0;">
            <img src="https://i.imgur.com/dZW6ydi.png" alt="Creating Email Magic" width="300" height="auto" style="display: block;" />
        </td>
    </tr> --}}
    <tr>
        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <h2> {{ trans('language.mail.customer_order.title', ['fullName' => $customer->first_name . ' ' . $customer->last_name ])}}
                    </td>
                </tr>
                    <td style="padding: 20px 0 30px 0;">
                        {{ trans('language.mail.customer_order.content.content_1', ['date' => $order->created_at ?  (new App\Services\DateFormatService())->dateFormatLanguage($order->created_at,'H:i d/m/Y') : '']) }}
                    </td>
                </tr>
                {{-- <tr>
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <tr>
                                    <th class="product-name">{{trans('language.product')}}</th>
                                    <th class="product-price">{{trans('language.price')}}</th>
                                    <th class="product-quantity">{{trans('language.quantity')}}</th>
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                @php
                                    $checkVariant = $product->product_type == \App\Models\Product::TYPE_VARIANT && $product->skus->isNotEmpty();
                                    $price = [];
                                    $stock = '';
                                    if($checkVariant){
                                        $stock = $product->skus->sum('stock');
                                        $price = \App\Services\ProcessPriceService::variantPrice($product->skus->min('price'), $product->skus->max('price'), $product->discount);
                                    }else{
                                        $price = \App\Services\ProcessPriceService::regularPrice($product->price, $product->discount);
                                        $stock = $product->stock;
                                    };
                                @endphp
                            <tr>
                                <td class="product-name" style="max-width:340px;">
                                    <h4><a href="{{ $product->status == \App\Models\Product::SELL ? route('site.product.show', ['slug' => $product->slug]) : 'javascript:void(0)' }}" class="line-clamp-2">{{ $product->name }}</a></h4>
                                </td>
                                <td class="product-price" style="color:#ff6000;">{{ $price['new'] }}</td>
                                <td class="product-stock-status">{{$stock}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </tr> --}}
            </table>
        </td>
    </tr>
                
    <tr>
        <td bgcolor="#323422" style="padding: 30px 30px 30px 30px; width:100%">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="45%">
                    </td>
                       <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                        &reg; 2023 Nguyễn Đức Thắng<br/>
                        {{ trans('language.author') }} 
                        <a href="" style="color: #ffffff;">
                            <font color="#ffffff"> {{ trans('language.website') }} </font>
                        </a>
                       </td>
                </tr>
               </table>
           </td>
    </tr>
</table>