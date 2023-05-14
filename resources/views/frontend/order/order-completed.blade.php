
@extends('frontend.layouts.master')
@section('title', trans('language.oorder'))

@section('css_page')
    <style>
    </style>
@stop

@section('css_library')
    {{-- @include('backend.libraryGroup.style-library', [
        'datepicker' => true,
        'icheck' => true,
        'select2' => true,
    ]) --}}
@stop
@section('content')
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
                                    Hours.</p>
                                    {{--  You will receive an
                                    email confirmation when your order is completed. --}}
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
    @stop

    @section('js_library')
        {{-- @include('backend.libraryGroup.script-library', ['datepicker' => true, 'select2' => true]) --}}
    @stop
    