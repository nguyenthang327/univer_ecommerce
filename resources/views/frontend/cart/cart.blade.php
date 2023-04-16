@extends('frontend.layouts.master')
@section('title', trans('language.customer_login.title'))

@section('css_page')
    <style>
        .imageInCart{
            width: 103px;
            height: 129px;
            object-fit: contain;
        }

        .saw{
            background-color: #f5f4f1;
            background-image:
            /* Top jagged */
            linear-gradient(135deg, #fff 50%, transparent 50%),
            linear-gradient(225deg, #fff 50%, transparent 50%),
            /* Bottom jagged */
            linear-gradient(45deg, #fff 50%, transparent 50%),
            linear-gradient(-45deg, #fff 50%, transparent 50%);
            background-position:
                /* Top jagged */
                top left, top left,
                /* Bottom jagged */
                bottom left, bottom left;
            background-size: 25px 26px;
            background-repeat: repeat-x;
        }
    </style>
@stop

@section('content')
<main>
    <!-- breadcrumb-area -->
    @include('frontend.layouts.breadcrumb', [
        'title' => trans('language.shopping_cart'),
        'breadcrumbItem' => trans('language.shopping_cart')
    ])
    <!-- breadcrumb-area-end -->

    <!-- shop-cart-area -->
    <section class="shop-cart-area wishlist-area pt-100 pb-100">
        @if(isset($globalProductsInCart) && count($globalProductsInCart) > 0)
            @php
                $subTotal = 0;
            @endphp
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="table-responsive-xl">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail"></th>
                                        <th class="product-name">{{trans('language.product')}}</th>
                                        <th class="product-price">{{trans('language.price')}}</th>
                                        <th class="product-quantity">{{trans('language.quantity')}}</th>
                                        <th class="product-subtotal">{{trans('language.subtotal')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($globalProductsInCart as $product)
                                        @php
                                            $price = \App\Services\ProcessPriceService::regularPrice($product->price, null);
                                            $aSubTotal = \App\Services\ProcessPriceService::regularPrice($product->price * $product->quantity, null);
                                            $subTotal += $product->price * $product->quantity;
                                        @endphp
                                        <tr class="cart-item" data-cart_detail_id="{{$product->cart_detail_id}}" >
                                            <td class="product-thumbnail" >
                                                <a 
                                                    href="#"
                                                    data-url="{{ route('customer.cart.destroy', ['id' => $product->cart_detail_id])}}"
                                                    class="wishlist-remove removeItemInCart"
                                                >
                                                    <i class="flaticon-cancel-1"></i>
                                                </a>
                                                <a href="{{ route('site.product.show', ['slug' =>$product->product_slug]) }}">
                                                    <img
                                                        class="imageInCart"
                                                        src="{{ !empty($product->product_gallery) ? asset('storage/'.json_decode($product->product_gallery)[0]->file_path) : '' }}"
                                                        alt="{{ $product->product_name }}"
                                                        onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                                                    >
                                                </a>
                                            </td>
                                            <td class="product-name" style="max-width:340px;">
                                                <h4><a href="{{ route('site.product.show', ['slug' =>$product->product_slug]) }}" class="line-clamp-2">{{ $product->product_name }}</a></h4>
                                                {{-- <p>Cramond Leopard & Pythong Anorak</p>
                                                <span>65% poly, 35% rayon</span> --}}
                                            </td>
                                            <td class="product-price">{{ $price['new'] }}</td>
                                            <td class="product-quantity">
                                                <div class="cart-plus">
                                                    <div class="cart-plus-minus"
                                                        data-url="{{route('customer.cart.update', ['id' => $product->cart_detail_id])}}"
                                                    >
                                                        <input
                                                            type="text" 
                                                            value="{{ $product->quantity }}"
                                                            name="quantity"
                                                            data-max="{{$product->stock}}"
                                                            data-old="{{$product->quantity}}"
                                                        >
                                                        <div class="dec qtybutton">-</div>
                                                        <div class="inc qtybutton">+</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal"><span>{{ $aSubTotal['new'] }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="shop-cart-bottom mt-20">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="cart-coupon">
                                        <form action="#">
                                            <input type="text" placeholder="Enter Coupon Code...">
                                            <button class="btn">Apply Coupon</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="continue-shopping">
                                        <a href="{{route('site.product.index')}}" class="btn">Continue Shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-8">
                        <aside class="shop-cart-sidebar">
                            <div class="shop-cart-widget saw" >
                                <h6 class="title">Cart Totals</h6>
                                {{-- <form action="#"> --}}
                                    <ul>
                                        @php
                                            $subTotal = \App\Services\ProcessPriceService::regularPrice($subTotal, null);
                                        @endphp
                                        <li><span>SUBTOTAL</span>{{ $subTotal['new'] }}</li>
                                        <li>
                                            <span>SHIPPING</span>
                                            <div class="shop-check-wrap">
                                                {{-- <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">FLAT RATE: $15</label>
                                                </div> --}}
                                                <div class="custom-checkbox">
                                                    {{-- <input type="checkbox" class="custom-control-input" id=""> --}}
                                                    <span class="font-weight-bold" for="customCheck2">FREE SHIPPING</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="cart-total-amount"><span>TOTAL</span> <span class="amount">$ 151.00</span></li>
                                    </ul>
                                    <a class="btn" href="{{route('customer.order.checkoutView')}}">PROCEED TO CHECKOUT</a>
                                {{-- </form> --}}
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        @else
            <div class="container">
                Giỏ hàng trống
            </div>
        @endif
    </section>
    <!-- shop-cart-area-end -->

    <!-- core-features -->
    <section class="core-features-area core-features-style-two">
        <div class="container">
            <div class="core-features-border">
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="core-features-item mb-50">
                            <div class="core-features-icon">
                                <img src="img/icon/core_features01.png" alt="">
                            </div>
                            <div class="core-features-content">
                                <h6>Free Shipping On Over </h6>
                                <span>Agricultural mean crops livestock</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="core-features-item mb-50">
                            <div class="core-features-icon">
                                <img src="img/icon/core_features02.png" alt="">
                            </div>
                            <div class="core-features-content">
                                <h6>Membership Discount</h6>
                                <span>Only MemberAgricultural livestock</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="core-features-item mb-50">
                            <div class="core-features-icon">
                                <img src="img/icon/core_features03.png" alt="">
                            </div>
                            <div class="core-features-content">
                                <h6>Money Return</h6>
                                <span>30 days money back guarantee</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="core-features-item mb-50">
                            <div class="core-features-icon">
                                <img src="img/icon/core_features04.png" alt="">
                            </div>
                            <div class="core-features-content">
                                <h6>Online Support</h6>
                                <span>30 days money back guarantee</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- core-features-end -->
</main>
@stop

@section('js_page')
    @include('frontend.cart.script')
@stop