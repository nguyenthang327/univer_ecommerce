
    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        @include('frontend.layouts.breadcrumb', [
            'title' => trans('language.order_completed'),
            'breadcrumbItem' => trans('language.order_completed'),
        ])
        <!-- breadcrumb-area-end -->

        <!-- order-complete-area -->
        <section class="order-complete-area pattern-bg pt-100 pb-100" data-background="img/bg/pattern_bg.jpg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">
                        <div class="order-complete-bg" data-background="{{asset('images/order_comp_bg.png')}}">
                            <div class="order-complete-content">
                                <h3><span>your</span> Order Is Completed!</h3>
                                <div class="check mb-25">
                                    <img src="img/icon/check.png" alt="">
                                </div>
                                <p>Thank you for your order! Your order is being processed and will be completed within 6-12
                                    Hours. You will receive an
                                    email confirmation when your order is completed.</p>
                                <a href="shop-left-sidebar.html" class="btn">CONTINUE SHOPPING</a>
                                <p class="get-ans">Get answers to all your <a href="#">Questions</a> you might have.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- order-complete-area-end -->

    </main>
    <!-- main-area-end -->
