@extends('frontend.layouts.master')
@section('title',trans('language.wishlist'))

@section('css_page')
<style>
     .imageInCart{
            width: 103px;
            height: 129px;
            object-fit: contain;
        }
    </style>
@stop

@section('content')
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    @include('frontend.layouts.breadcrumb', [
            'title' => trans('language.product_wishlist'),
            'breadcrumbItem' => trans('language.product_wishlist'),
        ])
    <!-- breadcrumb-area-end -->

    <!-- wishlist-area -->
    <section class="wishlist-area pt-100 pb-100">
        <div class="container">
            @if(count($products) > 0)
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive-xl">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    {{-- <th class="product-thumbnail"></th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">QUANTITY</th>
                                    <th class="product-subtotal">SUBTOTAL</th>
                                    <th class="product-stock-status">Stock Status</th>
                                    <th class="product-add-to-cart"></th> --}}
                                    <tr>
                                        <th class="product-thumbnail"></th>
                                        <th class="product-name">{{trans('language.product')}}</th>
                                        <th class="product-price">{{trans('language.price')}}</th>
                                        <th class="product-quantity">{{trans('language.quantity')}}</th>
                                        <th class="product-quantity">{{trans('language.status')}}</th>

                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td class="product-thumbnail"><a href="#" class="wishlist-remove"><i class="flaticon-cancel-1"></i></a><a href="shop-details.html"><img src="img/product/wishlist_thumb01.jpg" alt=""></a>
                                    </td>
                                    <td class="product-name">
                                        <h4><a href="shop-details.html">Woman Lathers Jacket</a></h4>
                                        <p>Cramond Leopard & Pythong Anorak</p>
                                        <span>65% poly, 35% rayon</span>
                                    </td>
                                    <td class="product-price">$ 29.00</td>
                                    <td class="product-quantity">
                                        <div class="cart-plus">
                                            <form action="#">
                                                <div class="cart-plus-minus">
                                                    <input type="text" value="2">
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="product-subtotal"><span>$ 68.00</span></td>
                                    <td class="product-stock-status"><span>In Stock</span></td>
                                    <td class="product-add-to-cart"><span>Added on March 10. 2020</span><a href="cart.html" class="btn">Add to Cart</a></td>
                                </tr>
                                <tr>
                                    <td class="product-thumbnail"><a href="#" class="wishlist-remove"><i class="flaticon-cancel-1"></i></a><a href="shop-details.html"><img src="img/product/wishlist_thumb02.jpg" alt=""></a>
                                    </td>
                                    <td class="product-name">
                                        <h4><a href="shop-details.html">Woman Lathers Jacket</a></h4>
                                        <p>Cramond Leopard & Pythong Anorak</p>
                                        <span>65% poly, 35% rayon</span>
                                    </td>
                                    <td class="product-price">$ 29.00</td>
                                    <td class="product-quantity">
                                        <div class="cart-plus">
                                            <form action="#">
                                                <div class="cart-plus-minus">
                                                    <input type="text" value="2">
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="product-subtotal"><span>$ 68.00</span></td>
                                    <td class="product-stock-status"><span>In Stock</span></td>
                                    <td class="product-add-to-cart"><span>Added on March 10. 2020</span><a href="cart.html" class="btn">Add to Cart</a></td>
                                </tr>
                                <tr>
                                    <td class="product-thumbnail"><a href="#" class="wishlist-remove"><i class="flaticon-cancel-1"></i></a><a href="shop-details.html"><img src="img/product/wishlist_thumb03.jpg" alt=""></a>
                                    </td>
                                    <td class="product-name">
                                        <h4><a href="shop-details.html">Woman Lathers Jacket</a></h4>
                                        <p>Cramond Leopard & Pythong Anorak</p>
                                        <span>65% poly, 35% rayon</span>
                                    </td>
                                    <td class="product-price">$ 29.00</td>
                                    <td class="product-quantity">
                                        <div class="cart-plus">
                                            <form action="#">
                                                <div class="cart-plus-minus">
                                                    <input type="text" value="2">
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="product-subtotal"><span>$ 68.00</span></td>
                                    <td class="product-stock-status"><span>In Stock</span></td>
                                    <td class="product-add-to-cart"><span>Added on March 10. 2020</span><a href="cart.html" class="btn">Add to Cart</a></td>
                                </tr> --}}
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
                                    <td class="product-thumbnail" >
                                        <a 
                                            href="#"
                                            id="add-wishlist"
                                            data-url="{{ route('customer.product.favoriteStore') }}"
                                            data-product_id={{$product->id}}
                                            class="wishlist-remove"
                                        >
                                            <i class="flaticon-cancel-1"></i>
                                        </a>
                                        <a href="{{ $product->status == \App\Models\Product::SELL ? route('site.product.show', ['slug' => $product->slug]) : 'javascript:void(0)' }}" >
                                            <img
                                                class="imageInCart"
                                                src="{{ !empty($product->gallery) ? asset('storage/'.$product->gallery[0]["file_path"]) : '' }}"
                                                alt="{{ $product->name }}"
                                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                                            >
                                        </a>
                                    </td>
                                    <td class="product-name" style="max-width:340px;">
                                        <h4><a href="{{ $product->status == \App\Models\Product::SELL ? route('site.product.show', ['slug' => $product->slug]) : 'javascript:void(0)' }}" class="line-clamp-2">{{ $product->name }}</a></h4>
                                    </td>
                                    <td class="product-price" style="color:#ff6000;">{{ $price['new'] }}</td>
                                    <td class="product-stock-status">{{$stock}}</td>
                                    <td class="product-stock-status">
                                        <span>
                                            {{ $product->status == \App\Models\Product::SELL ? ($stock > 0 ? trans('language.in_stock') : trans('language.out_stock') ) : trans('language.status_s')[\App\Models\Product::NOT_SELL]}}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
            Không có sản phẩm yêu thích
        @endif
    </section>
    <!-- wishlist-area-end -->

</main>

<!-- main-area-end -->
@stop

@section('js_page')
<script src="{{asset('fe-assets/js/page/product/product-detail.js')}}"></script>
@stop