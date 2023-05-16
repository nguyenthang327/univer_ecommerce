@extends('frontend.layouts.master')
@section('title',trans('language.home'))

@section('css_page')
@stop

@section('content')
 <!-- slider-area -->
 {{-- @dd(session('coupon_code')) --}}
 <section class="second-slider-area" data-background="">
    <div class="custom-container-two">
        <div class="row justify-content-end">
            <div class="col-xl-10">
                <div class="slider-active">
                    <div class="single-slider slider-bg" data-background="https://themebeyond.com/html/venam/img/slider/s_slider_bg02.jpg">
                        <div class="slider-content">
                            <h5 data-animation="fadeInUp" data-delay=".3s">top deal !</h5>
                            <h2 data-animation="fadeInUp" data-delay=".6s">Smart cream</h2>
                            <p data-animation="fadeInUp" data-delay=".9s">Get up to <span>50%</span> off Today Only</p>
                            <a href="shop-left-sidebar.html" class="btn yellow-btn" data-animation="fadeInUp" data-delay="1s">Shop Now</a>
                        </div>
                    </div>
                    {{-- <div class="single-slider slider-bg" data-background="img/slider/s_slider_bg02.jpg">
                        <div class="slider-content">
                            <h5 data-animation="fadeInUp" data-delay=".3s">top deal !</h5>
                            <h2 data-animation="fadeInUp" data-delay=".6s">Top headphone</h2>
                            <p data-animation="fadeInUp" data-delay=".9s">Get up to <span>50%</span> off Today Only</p>
                            <a href="shop-left-sidebar.html" class="btn yellow-btn" data-animation="fadeInUp" data-delay="1s">Shop Now</a>
                        </div>
                    </div>
                    <div class="single-slider slider-bg" data-background="img/slider/s_slider_bg03.jpg">
                        <div class="slider-content">
                            <h5 data-animation="fadeInUp" data-delay=".3s">top deal !</h5>
                            <h2 data-animation="fadeInUp" data-delay=".6s">Smart Watch</h2>
                            <p data-animation="fadeInUp" data-delay=".9s">Get up to <span>50%</span> off Today Only</p>
                            <a href="shop-left-sidebar.html" class="btn yellow-btn" data-animation="fadeInUp" data-delay="1s">Shop Now</a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- slider-area-end -->

<!-- top-cat-banner -->
<div class="top-cat-banner-area">
    <div class="custom-container-two">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="top-cat-banner-item mt-30">
                    <a href="{{ route('site.product.index') }}"><img src="https://themebeyond.com/html/venam/img/images/top_cat_banner01.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="top-cat-banner-item mt-30">
                    <a href="{{ route('site.product.index') }}"><img src="https://themebeyond.com/html/venam/img/images/top_cat_banner01.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="top-cat-banner-item mt-30">
                    <a href="{{ route('site.product.index') }}"><img src="https://themebeyond.com/html/venam/img/images/top_cat_banner01.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- top-cat-banner-end -->

<!-- exclusive-collection-area -->
@include('frontend.homepage.exclusive-collection')
<!-- exclusive-collection-area-end -->

<!-- deal-of-the-day -->
<section class="deal-of-the-day theme-bg pt-100 pb-70">
    <div class="custom-container-two">
        <div class="row">
            {{-- <div class="custom-col-4">
                <div class="deal-of-day-banner mb-30">
                    <a href="shop-left-sidebar.html"><img src="img/product/deal_banner.jpg" alt=""></a>
                </div>
            </div> --}}
            <div class="col-12">
                <div class="deal-day-top">
                    <div class="deal-day-title">
                        <h4 class="title">{{trans('language.top_favorite_product')}}</h4>
                    </div>
                    <div class="view-all-deal">
                        {{-- <a href="shop-left-sidebar.html"><i class="flaticon-scroll"></i> View All</a> --}}
                    </div>
                </div>
                <div class="row deal-day-active">
                    @foreach($topFavoriteProduct as $product)
                    @php
                        $checkVariant = $product->product_type == \App\Models\Product::TYPE_VARIANT && $product->skus->isNotEmpty();
                        $data = [];
                        if($checkVariant){
                            $data = \App\Services\ProcessPriceService::variantPrice($product->skus[0]->min_price, $product->skus[0]->min_price, $product->discount);
                        }else{
                            $data = \App\Services\ProcessPriceService::regularPrice($product->price, $product->discount);
                        };
                    @endphp
                    <div class="col-xl-3">
                        <div class="most-popular-viewed-item mb-30">
                            <div class="viewed-item-top">
                                <div class="most--popular--item--thumb mb-20">
                                    <a href="{{ route('site.product.show', ['slug' => $product->slug]) }}">
                                        <img src="{{ !empty($product->gallery) ? asset('storage/'.$product->gallery[0]['file_path']) : '' }}" alt="" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" style="width: 170px; height:178px; oject-fit:containt;">
                                    </a>
                                </div>
                                <div class="super-deal-content">
                                    <h6><a href="{{ route('site.product.show', ['slug' => $product->slug]) }}" class="line-clamp-1">{{$product->name}}</a></h6>
                                    <p>{{ $data['new'] }}@if($product->discount > 0)<span> {Sale: {{ $product->discount}} % }</span>@endif</p>
                                </div>
                            </div>
                            <div class="viewed-item-bottom">
                                <ul>
                                    <li>{{trans('language.number_favorite')}} : {{$product->total}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- deal-of-the-day-end -->

<!-- best-cat-area -->
<section class="best-cat-area">
    <div class="container">
        <div class="best-cat-border pt-100 pb-45">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center mb-60">
                        <span class="sub-title">{{trans('language.browse_category')}}</span>
                        <h2 class="title">{{trans('language.browse_best_category')}}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="best-cat-list">
                        @php
                            $item = 0;
                        @endphp
                        @foreach($globalProductCategories as $key => $productCategory)
                        <div class="best-cat-item">
                            <div class="best-cat-thumb">
                                <a href="{{ route('site.product.index', ['categorySlug' => $productCategory['slug'] ] )}}">
                                    <img src="{{asset('storage/'.$productCategory["thumbnail"])}}" alt="{{ $productCategory["name"] }}" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" style="width:217px; height:217px; object-fit:contain;">
                                </a>
                            </div>
                            <div class="best-cat-content">
                                <h5><a href="{{ route('site.product.index', ['categorySlug' => $productCategory['slug'] ] )}}">{{$productCategory['name']}}</a></h5>
                            </div>
                        </div>
                        @php
                            ++$item;
                            if($item==5)
                                break;
                        @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- best-cat-area-end -->

@stop

@section('js_page')
@stop