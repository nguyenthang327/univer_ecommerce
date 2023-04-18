
@extends('frontend.layouts.master')
@section('title',trans('language.checkout'))

@section('css_page')
@stop

@section('css_library')
    @include('backend.libraryGroup.style-library', ['datepicker' => true, 'icheck' => true, 'select2' => true])
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
                        <h2>Shopping Checkout</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- checkout-area -->
    <section class="checkout-area pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-wrap">
                        <h5 class="title">billing information</h5>
                        <form action="#" class="checkout-form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-grp">
                                        <label for="fName">FULL NAME <span>*</span></label>
                                        <input type="text" id="fName">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-grp">
                                        <label>{{trans('language.prefecture')}} *</label>
                                        <select class="custom-select select2-base dynamic-select-option"
                                            style="width:100%"
                                            data-child="#select_district"
                                            data-url="{{ route('getDistrictList') }}"
                                            data-placeholder="{{trans('language.choose_a_prefecture')}}"
                                            name="prefecture_id"
                                            required
                                        >
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-grp">
                                        <label>{{trans('language.district')}} *</label>
                                        <select class="custom-select select2-base dynamic-select-option"
                                            style="width:100%"
                                            name="district_id"
                                            data-child="#select_ward"
                                            data-url="{{ route('getCommuneList') }}"
                                            id="select_district"
                                            data-placeholder="{{trans('language.choose_a_district')}}"
                                            required
                                        >
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-grp">
                                        <label>{{trans('language.commune')}} *</label>
                                        <select class="custom-select select2-base"
                                            id="select_ward"
                                            data-placeholder="{{trans('language.choose_a_commune')}}"
                                            name="commune_id"
                                            style="width: 100%"
                                            required
                                        >
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-grp">
                                        <label for="address">{{trans('language.address')}} *</label>
                                        <input type="text" id="address">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-grp">
                                        <label for="phone">Your PHONE <span>*</span></label>
                                        <input type="text" id="phone">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="different-address custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="stda">
                                        <label class="custom-control-label" for="stda">SHIP TO A DIFFERENT ADDRESS?</label>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="form-grp mb-0">
                                        <label for="message">ORDER you have NOTES <small>(OPTIONAL)</small></label>
                                        <textarea name="message" id="message" placeholder="About Your Special Delivery Notes"></textarea>
                                    </div>
                                </div> --}}
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <aside class="shop-cart-sidebar checkout-sidebar">
                        <div class="shop-cart-widget">
                            <h6 class="title">Cart Totals</h6>
                            <form action="#">
                                <ul>
                                    <li class="order-subtotal"><span>SUBTOTAL</span> </li>
                                    </li>
                                    @if(session('coupon_code'))
                                    <li>
                                        <span>{{trans('language.discount')}}:</span>{{ session('coupon_code')['discount'] }} %
                                    </li>
                                    @endif
                                    <li>
                                        <span>SHIPPING</span>
                                        <div class="shop-check-wrap">
                                            {{-- <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">FLAT RATE: $15</label>
                                            </div> --}}
                                            <div class="custom-checkbox">
                                                {{-- <input type="checkbox" class="custom-control-input" id="customCheck2"> --}}
                                                {{-- <label class="custom-control-label" for="customCheck2">FREE SHIPPING</label> --}}
                                                <span class="font-weight-bold" for="customCheck2">FREE SHIPPING</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cart-total-amount order-total"><span>TOTAL</span> <span class="amount"></span></li>
                                </ul>
                                {{-- <div class="bank-transfer">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck3">
                                        <label class="custom-control-label" for="customCheck3">Direct Bank Transfer</label>
                                    </div>
                                </div> --}}
                                <div class="bank-transfer">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck4">
                                        <label class="custom-control-label" for="customCheck4">Cash On Delivery</label>
                                    </div>
                                </div>
                                <div class="paypal-method">
                                    <div class="paypal-method-flex">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck5">
                                            <label class="custom-control-label" for="customCheck5">PayPal</label>
                                        </div>
                                        <div class="paypal-logo"><img src="img/images/paypal_logo.png" alt=""></div>
                                    </div>
                                    <p>Pay via PayPal; you can pay with your credit
                                    card if you don’t have a PayPal account</p>
                                </div>
                                {{-- <div class="paypal-method">
                                    <div class="paypal-method-flex">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck6">
                                            <label class="custom-control-label" for="customCheck6">Payments on Card</label>
                                        </div>
                                        <div class="paypal-logo"><img src="img/images/payment_card.png" alt=""></div>
                                    </div>
                                </div>
                                <div class="payment-terms">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck7">
                                        <label class="custom-control-label" for="customCheck7">I have read and agree to the website terms
                                        and conditions *</label>
                                    </div>
                                </div> --}}
                                <button class="btn">PROCEED TO CHECKOUT</button>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- checkout-area-end -->

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

</main>
<!-- main-area-end -->
@stop

@section('js_library')
    @include('backend.libraryGroup.script-library', ['datepicker' => true, 'select2' => true])
@stop

@section('js_page')
    <script src="{{ asset("common/js/common.js") }}"></script>
    <script>
        $(document).ready(function(){
            $('.order-subtotal').append( $('.f-right.subtotal').text())
            $('.order-total .amount').append( $('.f-right.total').text())
        })
    </script>
@stop