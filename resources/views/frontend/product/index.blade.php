@extends('frontend.layouts.master')
@section('title',trans('language.product'))

@section('css_page')
@stop

@section('content')
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg" data-background="img/bg/breadcrumb_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2>Smart Shop</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Shop Left Sidebar</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- shop-area -->
    <div class="shop-area gray-bg pt-100 pb-100">
        <div class="custom-container-two">
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 order-2 order-lg-0">
                    <aside class="shop-sidebar">
                        <div class="widget shop-widget mb-30">
                            <div class="shop-widget-title">
                                <h6 class="title">Product Categories</h6>
                            </div>
                            <div class="shop-cat-list">
                                <ul>
                                    {{-- xem xét lại --}}
                                @if(!Request::has('categorySlug'))
                                    <li><a href="{{ route('site.product.index')}}" class="mini-cate-special">All</a>
                                        {{-- <span>27</span> --}}
                                    </li>
                                    @foreach($globalProductCategories as $key => $productCategory)
                                        <li>
                                            <a href="{{ route('site.product.index', ['categorySlug' => $productCategory['slug'] ] )}}">
                                                {{ $productCategory['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                        @dd($globalProductCategories)
                                    @foreach($globalProductCategories as $key => $productCategory)
                                        @if($productCategory['slug'] == Request::get('categorySlug'))
                                            <li>
                                                <a href="{{ route('site.product.index', ['categorySlug' => $productCategory['slug'] ] )}}" 
                                                    class="mini-cate-special">
                                                    {{ $productCategory['name'] }}
                                                </a>
                                            </li>
                                            @foreach ($productCategory['_2_level_cate'] as $item)
                                            <li>
                                                <a href="{{ route('site.product.index', ['categorySlug' => $item['slug'] ] )}}">{{$item['name']}}</a>
                                            </li>
                                            @endforeach
                                        @break
                                        @endif
                                @endforeach
                                @endif
                                </ul>
                            </div>
                        </div>
                        <div class="widget shop-widget mb-30">
                            <div class="shop-widget-title">
                                <h6 class="title">Filter By Price</h6>
                            </div>
                            <div class="price_filter">
                                <div id="slider-range"></div>
                                <div class="price_slider_amount">
                                    <span>Price :</span>
                                    <input type="text" id="amount" name="price" placeholder="Add Your Price" />
                                </div>
                            </div>
                        </div>
                        <div class="widget shop-widget mb-30">
                            <div class="shop-widget-title">
                                <h6 class="title">NEW PRODUCT</h6>
                                <div class="slider-nav"></div>
                            </div>
                            <div class="sidebar-product-active">
                                <div class="sidebar-product-list">
                                    <ul>
                                        <li>
                                            <div class="sidebar-product-thumb">
                                                <a href="shop-details.html"><img src="img/product/sidebar_product01.jpg" alt=""></a>
                                            </div>
                                            <div class="sidebar-product-content">
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <h5><a href="shop-details.html">Slim Fit Cotton</a></h5>
                                                <span>$ 39.00</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sidebar-product-thumb">
                                                <a href="shop-details.html"><img src="img/product/sidebar_product02.jpg" alt=""></a>
                                            </div>
                                            <div class="sidebar-product-content">
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <h5><a href="shop-details.html">Slim Fit Cotton</a></h5>
                                                <span>$ 39.00</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sidebar-product-thumb">
                                                <a href="shop-details.html"><img src="img/product/sidebar_product03.jpg" alt=""></a>
                                            </div>
                                            <div class="sidebar-product-content">
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <h5><a href="shop-details.html">Slim Fit Cotton</a></h5>
                                                <span>$ 39.00</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="sidebar-product-list">
                                    <ul>
                                        <li>
                                            <div class="sidebar-product-thumb">
                                                <a href="shop-details.html"><img src="img/product/sidebar_product01.jpg" alt=""></a>
                                            </div>
                                            <div class="sidebar-product-content">
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <h5><a href="shop-details.html">Slim Fit Cotton</a></h5>
                                                <span>$ 39.00</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sidebar-product-thumb">
                                                <a href="shop-details.html"><img src="img/product/sidebar_product02.jpg" alt=""></a>
                                            </div>
                                            <div class="sidebar-product-content">
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <h5><a href="shop-details.html">Slim Fit Cotton</a></h5>
                                                <span>$ 39.00</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sidebar-product-thumb">
                                                <a href="shop-details.html"><img src="img/product/sidebar_product03.jpg" alt=""></a>
                                            </div>
                                            <div class="sidebar-product-content">
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <h5><a href="shop-details.html">Slim Fit Cotton</a></h5>
                                                <span>$ 39.00</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="widget shop-widget mb-30">
                            <div class="shop-widget-title">
                                <h6 class="title">Product Brand</h6>
                            </div>
                            <div class="sidebar-brand-list">
                                <ul>
                                    <li><a href="#">New Arrivals</a></li>
                                    <li><a href="#">Clothing & Accessories</a></li>
                                    <li><a href="#">Vanam Jacket</a></li>
                                    <li><a href="#">Home Electronics</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="widget">
                            <div class="shop-widget-banner special-offer-banner">
                                <a href="shop-left-sidebar.html"><img src="img/product/sidebar_banner_ad.jpg" alt=""></a>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="shop-top-meta mb-40">
                        <p class="show-result">Showing Products 1-12 Of 10 Result</p>
                        <div class="shop-meta-right">
                            <ul>
                                <li class="active"><a href="#"><i class="flaticon-grid"></i></a></li>
                                <li><a href="#"><i class="flaticon-list"></i></a></li>
                            </ul>
                            <form action="#">
                                <select class="custom-select">
                                    <option selected="">Default Sorting</option>
                                    <option>Free Shipping</option>
                                    <option>Best Match</option>
                                    <option>Newest Item</option>
                                    <option>Size A - Z</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        @if($products)
                            @foreach($products as $product)
                            @php
                                $checkVariant = $product->product_type == \App\Models\Product::TYPE_VARIANT && $product->skus->isNotEmpty();
                                $data = [];
                                if($checkVariant){
                                    $data = \App\Services\ProcessPriceService::variantPrice($product->skus[0]['min_price'], $product->skus[0]['max_price'], $product->discount);
                                }else{
                                    $data = \App\Services\ProcessPriceService::regularPrice($product->price, $product->discount);
                                }
                            @endphp
                                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6">
                                    <div class="exclusive-item exclusive-item-three text-center mb-50 exclusive-item-list">
                                        <div class="exclusive-item-thumb product-list-page">
                                            <a href="{{ route('site.product.show', ['slug' => $product->slug]) }}">
                                                <img src="{{ !empty($product->gallery) ? asset('storage/'.$product->gallery[0]['file_path']) : '' }}" alt="" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                                {{-- <img class="overlay-product-thumb" src="img/product/td_product_img01.jpg" alt=""> --}}
                                            </a>
                                            <ul class="action">
                                                <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                                <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                                <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                            </ul>
                                            @if($product->discount > 0)
                                                <span class="discount">{{$product['discount']}}%</span>
                                            @endif
                                        </div>
                                        <div class="exclusive-item-content mb-2">
                                            <h5><a href="{{ $product->slug }}" class="line-clamp-2 product-item-name">{{ $product->name }}</a></h5>
                                            <div class="exclusive--item--price">
                                                @if($data['old'] )
                                                <del class="old-price">{{ $data['old'] }}</del>
                                                @endif
                                                <span class="new-price">{{ $data['new'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                    <div class="pagination-wrap">
                        <ul>
                            <li class="prev"><a href="#"><i class="fas fa-long-arrow-alt-left"></i> Prev</a></li>
                            <li><a href="#">1</a></li>
                            <li class="active"><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">10</a></li>
                            <li class="next"><a href="#">Next <i class="fas fa-long-arrow-alt-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shop-area-end -->


</main>
<!-- main-area-end -->
@stop

@section('js_page')
@stop