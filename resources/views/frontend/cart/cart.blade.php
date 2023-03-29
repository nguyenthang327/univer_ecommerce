@extends('frontend.layouts.master')
    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg" data-background="img/bg/breadcrumb_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2>Shopping Cart</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- shop-cart-area -->
    <section class="shop-cart-area wishlist-area pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="table-responsive-xl">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail"></th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">QUANTITY</th>
                                    <th class="product-subtotal">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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
                                </tr>
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
                                    <a href="shop.html" class="btn">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <aside class="shop-cart-sidebar">
                        <div class="shop-cart-widget">
                            <h6 class="title">Cart Totals</h6>
                            <form action="#">
                                <ul>
                                    <li><span>SUBTOTAL</span> $ 136.00</li>
                                    <li>
                                        <span>SHIPPING</span>
                                        <div class="shop-check-wrap">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">FLAT RATE: $15</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                <label class="custom-control-label" for="customCheck2">FREE SHIPPING</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cart-total-amount"><span>TOTAL</span> <span class="amount">$ 151.00</span></li>
                                </ul>
                                <button class="btn">PROCEED TO CHECKOUT</button>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
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
                                <h6>Free Shipping On Over $ 50</h6>
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
                        <a href="#" class="btn">limited time offer</a>
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