@extends('frontend.layouts.master')

@section('content')
 <!-- slider-area -->
 <section class="second-slider-area" data-background="img/slider/slider_bg.jpg">
    <div class="custom-container-two">
        <div class="row justify-content-end">
            <div class="col-xl-10">
                <div class="slider-active">
                    <div class="single-slider slider-bg" data-background="img/slider/s_slider_bg01.jpg">
                        <div class="slider-content">
                            <h5 data-animation="fadeInUp" data-delay=".3s">top deal !</h5>
                            <h2 data-animation="fadeInUp" data-delay=".6s">Smart cream</h2>
                            <p data-animation="fadeInUp" data-delay=".9s">Get up to <span>50%</span> off Today Only</p>
                            <a href="shop-left-sidebar.html" class="btn yellow-btn" data-animation="fadeInUp" data-delay="1s">Shop Now</a>
                        </div>
                    </div>
                    <div class="single-slider slider-bg" data-background="img/slider/s_slider_bg02.jpg">
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
                    </div>
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
                    <a href="shop-left-sidebar.html"><img src="img/images/top_cat_banner01.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="top-cat-banner-item mt-30">
                    <a href="shop-left-sidebar.html"><img src="img/images/top_cat_banner02.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="top-cat-banner-item mt-30">
                    <a href="shop-left-sidebar.html"><img src="img/images/top_cat_banner03.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- top-cat-banner-end -->

<!-- exclusive-collection-area -->
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
                    <button class="active" data-filter="*">Best Sellers</button>
                    <button class="" data-filter=".cat-one">Featured</button>
                    <button class="" data-filter=".cat-two">Hot Sell</button>
                    <button class="" data-filter=".cat-three">Trend</button>
                </div>
            </div>
        </div>
        <div class="row exclusive-active">
            <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-two cat-three">
                <div class="exclusive-item exclusive-item-two mb-40">
                    <div class="exclusive-item-thumb">
                        <a href="shop-details.html">
                            <img src="img/product/s_exclusive_product01.png" alt="">
                            <img class="overlay-product-thumb" src="img/product/s_exclusive__product01.png" alt="">
                        </a>
                        <span class="discount">35%</span>
                        <span class="sd-meta">New!</span>
                        <a href="cart.html" class="to-cart">add to cart <i class="fas fa-cart-plus"></i></a>
                    </div>
                    <div class="exclusive-item-content">
                        <div class="exclusive--content--top">
                            <div class="tag">
                                <a href="#">ladies bag</a>
                            </div>
                            <del class="old-price">$69.00</del>
                        </div>
                        <div class="exclusive--content--bottom">
                            <h5><a href="shop-details.html">Hand Gloves</a></h5>
                            <span>$58.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-one cat-three">
                <div class="exclusive-item exclusive-item-two mb-40">
                    <div class="exclusive-item-thumb">
                        <a href="shop-details.html">
                            <img src="img/product/s_exclusive_product02.png" alt="">
                            <img class="overlay-product-thumb" src="img/product/s_exclusive__product02.png" alt="">
                        </a>
                        <span class="sd-meta">New!</span>
                        <a href="cart.html" class="to-cart">add to cart <i class="fas fa-cart-plus"></i></a>
                    </div>
                    <div class="exclusive-item-content">
                        <div class="exclusive--content--top">
                            <div class="tag">
                                <a href="#">ladies bag</a>
                            </div>
                            <del class="old-price">$69.00</del>
                        </div>
                        <div class="exclusive--content--bottom">
                            <h5><a href="shop-details.html">Venam Trimmer</a></h5>
                            <span>$58.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-two">
                <div class="exclusive-item exclusive-item-two mb-40">
                    <div class="exclusive-item-thumb">
                        <a href="shop-details.html">
                            <img src="img/product/s_exclusive_product03.png" alt="">
                            <img class="overlay-product-thumb" src="img/product/s_exclusive__product03.png" alt="">
                        </a>
                        <span class="sd-meta">New!</span>
                        <a href="cart.html" class="to-cart">add to cart <i class="fas fa-cart-plus"></i></a>
                    </div>
                    <div class="exclusive-item-content">
                        <div class="exclusive--content--top">
                            <div class="tag">
                                <a href="#">Men's Shoes</a>
                            </div>
                            <del class="old-price">$69.00</del>
                        </div>
                        <div class="exclusive--content--bottom">
                            <h5><a href="shop-details.html">Casual Shoes</a></h5>
                            <span>$58.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-one cat-three">
                <div class="exclusive-item exclusive-item-two mb-40">
                    <div class="exclusive-item-thumb">
                        <a href="shop-details.html">
                            <img src="img/product/s_exclusive_product04.png" alt="">
                            <img class="overlay-product-thumb" src="img/product/s_exclusive__product04.png" alt="">
                        </a>
                        <span class="sd-meta">New!</span>
                        <a href="cart.html" class="to-cart">add to cart <i class="fas fa-cart-plus"></i></a>
                    </div>
                    <div class="exclusive-item-content">
                        <div class="exclusive--content--top">
                            <div class="tag">
                                <a href="#">ladies Dress</a>
                            </div>
                            <del class="old-price">$69.00</del>
                        </div>
                        <div class="exclusive--content--bottom">
                            <h5><a href="shop-details.html">Fashion Dress</a></h5>
                            <span>$58.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-two cat-three">
                <div class="exclusive-item exclusive-item-two mb-40">
                    <div class="exclusive-item-thumb">
                        <a href="shop-details.html">
                            <img src="img/product/s_exclusive_product05.png" alt="">
                            <img class="overlay-product-thumb" src="img/product/s_exclusive__product05.png" alt="">
                        </a>
                        <span class="sd-meta">New!</span>
                        <a href="cart.html" class="to-cart">add to cart <i class="fas fa-cart-plus"></i></a>
                    </div>
                    <div class="exclusive-item-content">
                        <div class="exclusive--content--top">
                            <div class="tag">
                                <a href="#">ladies Bag</a>
                            </div>
                            <del class="old-price">$99.00</del>
                        </div>
                        <div class="exclusive--content--bottom">
                            <h5><a href="shop-details.html">Fashion Bag</a></h5>
                            <span>$59.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-one">
                <div class="exclusive-item exclusive-item-two mb-40">
                    <div class="exclusive-item-thumb">
                        <a href="shop-details.html">
                            <img src="img/product/s_exclusive_product06.png" alt="">
                            <img class="overlay-product-thumb" src="img/product/s_exclusive__product06.png" alt="">
                        </a>
                        <span class="sd-meta">New!</span>
                        <a href="cart.html" class="to-cart">add to cart <i class="fas fa-cart-plus"></i></a>
                    </div>
                    <div class="exclusive-item-content">
                        <div class="exclusive--content--top">
                            <div class="tag">
                                <a href="#">ladies Dress</a>
                            </div>
                            <del class="old-price">$49.00</del>
                        </div>
                        <div class="exclusive--content--bottom">
                            <h5><a href="shop-details.html">Casual Shoes</a></h5>
                            <span>$40.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-two cat-one cat-three">
                <div class="exclusive-item exclusive-item-two mb-40">
                    <div class="exclusive-item-thumb">
                        <a href="shop-details.html">
                            <img src="img/product/s_exclusive_product07.png" alt="">
                            <img class="overlay-product-thumb" src="img/product/s_exclusive__product07.png" alt="">
                        </a>
                        <span class="discount">35%</span>
                        <span class="sd-meta">New!</span>
                        <a href="cart.html" class="to-cart">add to cart <i class="fas fa-cart-plus"></i></a>
                    </div>
                    <div class="exclusive-item-content">
                        <div class="exclusive--content--top">
                            <div class="tag">
                                <a href="#">Phone</a>
                            </div>
                            <del class="old-price">$29.00</del>
                        </div>
                        <div class="exclusive--content--bottom">
                            <h5><a href="shop-details.html">Mobile Phone</a></h5>
                            <span>$20.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-one cat-two">
                <div class="exclusive-item exclusive-item-two mb-40">
                    <div class="exclusive-item-thumb">
                        <a href="shop-details.html">
                            <img src="img/product/s_exclusive_product08.png" alt="">
                            <img class="overlay-product-thumb" src="img/product/s_exclusive__product08.png" alt="">
                        </a>
                        <span class="sd-meta">New!</span>
                        <a href="cart.html" class="to-cart">add to cart <i class="fas fa-cart-plus"></i></a>
                    </div>
                    <div class="exclusive-item-content">
                        <div class="exclusive--content--top">
                            <div class="tag">
                                <a href="#">Camera</a>
                            </div>
                            <del class="old-price">$59.00</del>
                        </div>
                        <div class="exclusive--content--bottom">
                            <h5><a href="shop-details.html">Casual Camera</a></h5>
                            <span>$29.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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

<!-- list-product-area -->
<section class="list-product-area pt-100 pb-30">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-md-6 mb-50">
                <div class="list-product-top">
                    <h4 class="title">Featured Products</h4>
                    <a href="shop-left-sidebar.html" class="view-all">View All</a>
                </div>
                <div class="list-product-item mb-20">
                    <div class="list-product-thumb">
                        <a href="shop-details.html"><img src="img/product/list_product_thumb01.png" alt=""></a>
                    </div>
                    <div class="list-product-content">
                        <h6><a href="shop-details.html">Stylish Bag</a></h6>
                        <p>US $ 17.29<span>{ 50% off }</span></p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <span class="list-product-tag">New!</span>
                </div>
                <div class="list-product-item mb-20">
                    <div class="list-product-thumb">
                        <a href="shop-details.html"><img src="img/product/list_product_thumb02.png" alt=""></a>
                    </div>
                    <div class="list-product-content">
                        <h6><a href="shop-details.html">Party Dress</a></h6>
                        <p>US $ 21.99<span>{ 50% off }</span></p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <span class="list-product-tag">New!</span>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-50">
                <div class="list-product-top">
                    <h4 class="title">Top Rated Products</h4>
                    <a href="shop-left-sidebar.html" class="view-all">View All</a>
                </div>
                <div class="list-product-item mb-20">
                    <div class="list-product-thumb">
                        <a href="shop-details.html"><img src="img/product/list_product_thumb03.png" alt=""></a>
                    </div>
                    <div class="list-product-content">
                        <h6><a href="shop-details.html">Smart Watch</a></h6>
                        <p>US $ 17.29<span>{ 50% off }</span></p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="list-product-item mb-20">
                    <div class="list-product-thumb">
                        <a href="shop-details.html"><img src="img/product/list_product_thumb04.png" alt=""></a>
                    </div>
                    <div class="list-product-content">
                        <h6><a href="shop-details.html">Stylish Bag</a></h6>
                        <p>US $ 21.99<span>{ 50% off }</span></p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <span class="list-product-tag">Hot!</span>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-50">
                <div class="list-product-top">
                    <h4 class="title">On Sale Products</h4>
                    <a href="shop-left-sidebar.html" class="view-all">View All</a>
                </div>
                <div class="list-product-item mb-20">
                    <div class="list-product-thumb">
                        <a href="shop-details.html"><img src="img/product/list_product_thumb05.png" alt=""></a>
                    </div>
                    <div class="list-product-content">
                        <h6><a href="shop-details.html">Web Camera s20</a></h6>
                        <p>US $ 17.29<span>{ 50% off }</span></p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="list-product-item mb-20">
                    <div class="list-product-thumb">
                        <a href="shop-details.html"><img src="img/product/list_product_thumb06.png" alt=""></a>
                    </div>
                    <div class="list-product-content">
                        <h6><a href="shop-details.html">Baby Toys</a></h6>
                        <p>US $ 21.99<span>{ 50% off }</span></p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <span class="list-product-tag">Hot!</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- list-product-area-end -->

<!-- limited-offer-area -->
<section class="limited-offer-area" data-background="img/bg/limited_offer_bg.jpg">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-5 col-lg-6 col-md-7">
                <div class="limited-offer-left">
                    <div class="limited-offer-title">
                        <span class="sub-title">exclusive offer</span>
                        <h2 class="title">Smart Watch Bracelet</h2>
                    </div>
                    <div class="limited-offer-disc">
                        <img src="img/images/limited_offer_discount.png" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="limited-offer-action">
                    <a href="shop-left-sidebar.html" class="btn">limited time offer</a>
                    <div class="amount-info">
                        <span class="upto">UPTO</span>
                        <span class="amount">$ 50.00</span>
                        <span class="off">OFF</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2 class="limited-overlay-title">Vanam Top Sale 35<span>%</span></h2>
    <div class="limited-overlay-img"><img src="img/images/limited_offer_img.png" alt=""></div>
</section>
<!-- limited-offer-area-end -->
@stop