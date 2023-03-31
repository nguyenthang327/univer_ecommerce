@extends('frontend.layouts.master')
@section('title',trans('language.product-detail'))

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
                            <h2>Page Not Found</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">404 Page</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- 404-area -->
        <section class="error-area pt-80 pb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-10">
                        <div class="error-content text-center">
                            <div class="error_txt">404</div>
                            <h5>oops! The page you requested was not found!</h5>
                            <p>The page you are looking for was moved, removed, renamed or might never existed.</p>
                            <div class="search_form">
                                <form method="post">
                                    <input name="text" id="text" type="text" placeholder="Search" class="form-control">
                                    <button type="submit" class="icon_search"><i class="flaticon-loupe"></i></button>
                                </form>
                            </div>
                            <a href="index.html" class="btn btn-fill-out">Back To Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- 404-area-end -->

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

    </main>
    <!-- main-area-end -->
@stop

@section('js_page')
@stop