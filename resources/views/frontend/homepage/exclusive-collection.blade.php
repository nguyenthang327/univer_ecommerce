<section class="exclusive-collection pt-100 pb-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center mb-60">
                    <span class="sub-title">exclusive collection</span>
                    <h2 class="title">best selling products</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="product-menu mb-60">
                    {{-- <button class="active" data-filter="*">Best Sellers</button> --}}
                    <button class="active" data-filter=".cat-featured">{{ trans('language.product_feature') }}</button>
                    <button class="" data-filter=".cat-new">{{ trans('language.product_new') }}</button>
                    {{-- <button class="" data-filter=".cat-three">Trend</button> --}}
                </div>
            </div>
        </div>
        <div class="row exclusive-active">
            @foreach($productFeature as $product)
                @php
                    $checkVariant = $product["product_type"] == \App\Models\Product::TYPE_VARIANT && !empty($product["skus"]);
                    $data = [];
                    if($checkVariant){
                        $data = \App\Services\ProcessPriceService::variantPrice($product["skus"][0]['min_price'], $product["skus"][0]['max_price'], $product["discount"]);
                    }else{
                        $data = \App\Services\ProcessPriceService::regularPrice($product["price"], $product["discount"]);
                    };
                @endphp
            <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-featured">
                <div class="exclusive-item exclusive-item-two mb-40">
                    <div class="exclusive-item-thumb homepage">
                        <a href="{{ route('site.product.show', ['slug' => $product['slug']]) }}">
                            <img src="{{ !empty($product['gallery']) ? asset('storage/'.$product['gallery'][0]['file_path']) : '' }}" alt="" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                            {{-- <img class="overlay-product-thumb" src="img/product/s_exclusive__product01.png" alt=""> --}}
                        </a>
                        @if($product['discount'] > 0)
                            <span class="discount">{{$product['discount']}}%</span>
                        @endif
                        @if(date("Y-m-d",strtotime($product['created_at']))  > date("Y-m-d", strtotime("-1 months")))
                            <span class="sd-meta">New!</span>
                        @endif
                        <a href="cart.html" class="to-cart">add to cart <i class="fas fa-cart-plus"></i></a>
                    </div>
                    <div class="exclusive-item-content">
                        <div class="exclusive--content--top">
                            <div class="line-clamp-2">
                                {{ $product['name'] }}
                            </div>
                            {{-- <div class="tag">
                                <a href="#">ladies bag</a>
                            </div>
                            <del class="old-price">$69.00</del> --}}
                        </div>
                        <div class="exclusive--content--bottom">
                            <span>{{ $data['new'] }}</span>
                            <span>Hand Gloves</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @foreach($productNew as $product)
                @php
                    $checkVariant = $product["product_type"] == \App\Models\Product::TYPE_VARIANT && !empty($product["skus"]);
                    $data = [];
                    if($checkVariant){
                        $data = \App\Services\ProcessPriceService::variantPrice($product["skus"][0]['min_price'], $product["skus"][0]['min_price'], $product["discount"]);
                    }else{
                        $data = \App\Services\ProcessPriceService::regularPrice($product["price"], $product["discount"]);
                    };
                @endphp
            <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-new" style="display:none">
                <div class="exclusive-item exclusive-item-two mb-40 exclusive-item-list" >
                    <div class="exclusive-item-thumb">
                        <a href="{{ route('site.product.show', ['slug' => $product['slug']]) }}">
                            <img src="{{ !empty($product['gallery']) ? asset('storage/'.$product['gallery'][0]['file_path']) : '' }}" alt="" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                            {{-- <img class="overlay-product-thumb" src="img/product/s_exclusive__product01.png" alt=""> --}}
                        </a>
                        @if($product['discount'] > 0)
                            <span class="discount">{{$product['discount']}}%</span>
                        @endif
                        {{-- @dd(\Carbon\Carbon::now()->submonth()->format('d-m-y')) --}}
                        {{-- @dd(date("Y-m-d",strtotime($product['created_at']))  > date("Y-m-d", strtotime("-1 months"))) --}}
                        @if(date("Y-m-d",strtotime($product['created_at']))  > date("Y-m-d", strtotime("-1 months")))
                            <span class="sd-meta">New!</span>
                        @endif
                        <a href="cart.html" class="to-cart">add to cart <i class="fas fa-cart-plus"></i></a>
                    </div>
                    <div class="exclusive-item-content">
                        <div class="exclusive--content--top" style="heigh:30px;">
                            <div class="line-clamp-2" >
                                {{ $product['name'] }}
                            </div>
                            {{-- <del class="old-price">$69.00</del> --}}
                        </div>
                        <div class="exclusive--content--bottom">
                            <span>{{ $data['new'] }}</span>
                            <span>Hand Gloves</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>