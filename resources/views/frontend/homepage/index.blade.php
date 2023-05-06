@extends('frontend.layouts.master')
@section('title',trans('language.home'))

@section('css_page')
@stop

@section('content')
 <!-- slider-area -->
 {{-- @dd(session('coupon_code')) --}}
 <section class="second-slider-area" data-background="img/slider/slider_bg.jpg">
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
                    <a href="shop-left-sidebar.html"><img src="https://themebeyond.com/html/venam/img/images/top_cat_banner01.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="top-cat-banner-item mt-30">
                    <a href="shop-left-sidebar.html"><img src="https://themebeyond.com/html/venam/img/images/top_cat_banner01.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="top-cat-banner-item mt-30">
                    <a href="shop-left-sidebar.html"><img src="https://themebeyond.com/html/venam/img/images/top_cat_banner01.jpg" alt=""></a>
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
            <div class="custom-col-4">
                <div class="deal-of-day-banner mb-30">
                    <a href="shop-left-sidebar.html"><img src="img/product/deal_banner.jpg" alt=""></a>
                </div>
            </div>
            <div class="custom-col-8">
                <div class="deal-day-top">
                    <div class="deal-day-title">
                        <h4 class="title">Deal Of The Day</h4>
                    </div>
                    <div class="view-all-deal">
                        <a href="shop-left-sidebar.html"><i class="flaticon-scroll"></i> View All</a>
                    </div>
                </div>
                <div class="row deal-day-active">
                    <div class="col-xl-3">
                        <div class="most-popular-viewed-item mb-30">
                            <div class="viewed-item-top">
                                <div class="most--popular--item--thumb mb-20">
                                    <a href="shop-details.html"><img src="img/product/most_popular_01.jpg" alt=""></a>
                                </div>
                                <div class="super-deal-content">
                                    <h6><a href="shop-details.html">Vacuum Cleaner</a></h6>
                                    <p>US $ 49.00<span>{ 50% off }</span></p>
                                </div>
                            </div>
                            <div class="viewed-item-bottom">
                                <ul>
                                    <li>Total Sold : 25</li>
                                    <li>Stocks : 3456</li>
                                </ul>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="viewed-offer-time">
                                    <p><span>Hurry Up</span> Limited Time Offer</p>
                                    <div class="coming-time" data-countdown="2020/9/20"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="most-popular-viewed-item mb-30">
                            <div class="viewed-item-top">
                                <div class="most--popular--item--thumb mb-20">
                                    <a href="shop-details.html"><img src="img/product/most_popular_02.jpg" alt=""></a>
                                </div>
                                <div class="super-deal-content">
                                    <h6><a href="shop-details.html">Stylish Smart Watch</a></h6>
                                    <p>US $ 17.00<span>{ 50% off }</span></p>
                                </div>
                            </div>
                            <div class="viewed-item-bottom">
                                <ul>
                                    <li>Total Sold : 35</li>
                                    <li>Stocks : 3456</li>
                                </ul>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="viewed-offer-time">
                                    <p><span>Hurry Up</span> Limited Time Offer</p>
                                    <div class="coming-time" data-countdown="2020/9/15"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="most-popular-viewed-item mb-30">
                            <div class="viewed-item-top">
                                <div class="most--popular--item--thumb mb-20">
                                    <a href="shop-details.html"><img src="img/product/most_popular_03.jpg" alt=""></a>
                                </div>
                                <div class="super-deal-content">
                                    <h6><a href="shop-details.html">Fashion Party Dress</a></h6>
                                    <p>US $ 17.00<span>{ 50% off }</span></p>
                                </div>
                            </div>
                            <div class="viewed-item-bottom">
                                <ul>
                                    <li>Total Sold : 35</li>
                                    <li>Stocks : 3456</li>
                                </ul>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 55%;" aria-valuenow="35" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="viewed-offer-time">
                                    <p><span>Hurry Up</span> Limited Time Offer</p>
                                    <div class="coming-time" data-countdown="2020/9/11"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="most-popular-viewed-item mb-30">
                            <div class="viewed-item-top">
                                <div class="most--popular--item--thumb mb-20">
                                    <a href="shop-details.html"><img src="img/product/most_popular_01.jpg" alt=""></a>
                                </div>
                                <div class="super-deal-content">
                                    <h6><a href="shop-details.html">Vacuum Fashion Bag</a></h6>
                                    <p>US $ 31.00<span>{ 50% off }</span></p>
                                </div>
                            </div>
                            <div class="viewed-item-bottom">
                                <ul>
                                    <li>Total Sold : 35</li>
                                    <li>Stocks : 3456</li>
                                </ul>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="35" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="viewed-offer-time">
                                    <p><span>Hurry Up</span> Limited Time Offer</p>
                                    <div class="coming-time" data-countdown="2020/9/9"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="most-popular-viewed-item mb-30">
                            <div class="viewed-item-top">
                                <div class="most--popular--item--thumb mb-20">
                                    <a href="shop-details.html"><img src="img/product/most_popular_02.jpg" alt=""></a>
                                </div>
                                <div class="super-deal-content">
                                    <h6><a href="shop-details.html">Stylish Smart Watch</a></h6>
                                    <p>US $ 17.00<span>{ 50% off }</span></p>
                                </div>
                            </div>
                            <div class="viewed-item-bottom">
                                <ul>
                                    <li>Total Sold : 35</li>
                                    <li>Stocks : 3456</li>
                                </ul>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="viewed-offer-time">
                                    <p><span>Hurry Up</span> Limited Time Offer</p>
                                    <div class="coming-time" data-countdown="2020/9/15"></div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <span class="sub-title">BROWSE CATEGORIES</span>
                        <h2 class="title">BROWSE best CATEGORIES</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="best-cat-list">
                        <div class="best-cat-item">
                            <div class="best-cat-thumb">
                                <a href="shop-left-sidebar.html"><img src="img/product/b_cat_product01.png" alt=""></a>
                            </div>
                            <div class="best-cat-content">
                                <h5><a href="shop-left-sidebar.html">fashion clothes</a></h5>
                                <span>Women Fashion</span>
                            </div>
                        </div>
                        <div class="best-cat-item">
                            <div class="best-cat-thumb">
                                <a href="shop-left-sidebar.html"><img src="img/product/b_cat_product02.png" alt=""></a>
                            </div>
                            <div class="best-cat-content">
                                <h5><a href="shop-left-sidebar.html">smart watch</a></h5>
                                <span>Men Fashion</span>
                            </div>
                        </div>
                        <div class="best-cat-item">
                            <div class="best-cat-thumb">
                                <a href="shop-left-sidebar.html"><img src="img/product/b_cat_product03.png" alt=""></a>
                            </div>
                            <div class="best-cat-content">
                                <h5><a href="shop-left-sidebar.html">Casual Shoes</a></h5>
                                <span>Men Fashion</span>
                            </div>
                        </div>
                        <div class="best-cat-item">
                            <div class="best-cat-thumb">
                                <a href="shop-left-sidebar.html"><img src="img/product/b_cat_product04.png" alt=""></a>
                            </div>
                            <div class="best-cat-content">
                                <h5><a href="shop-left-sidebar.html">Woman clothes</a></h5>
                                <span>Woman Fashion</span>
                            </div>
                        </div>
                        <div class="best-cat-item">
                            <div class="best-cat-thumb">
                                <a href="shop-left-sidebar.html"><img src="img/product/b_cat_product05.png" alt=""></a>
                            </div>
                            <div class="best-cat-content">
                                <h5><a href="shop-left-sidebar.html">hair removal</a></h5>
                                <span>Woman Fashion</span>
                            </div>
                        </div>
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