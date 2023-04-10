@extends('frontend.layouts.master')
@section('title', trans('language.customer_register.code'))

@section('css_page')
@stop

@section('content')
@if($customer)
    <!-- main-area -->
    <main>
        <!-- breadcrumb-area -->
        <section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('images/breadcrumb_bg.jpg')}}">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-content text-center">
                            <h2>My-Account</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Account</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- my-account-area -->
        <section class="my-account-area pattern-bg pt-100 pb-100" data-background="">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">
                        <div class="login-page-title">
                            <h2 class="title">
                                <span style="color: #ff6000">CONFIRM CODE </span></h2>
                        </div>
                        <div class="my-account-bg" data-background="">
                            <div class="my-account-content">
                                <form action="{{route('customer.register.step2', ['id' => $customer->id])}}" class="login-form" method="POST">
                                    <div class="form-grp">
                                        <label for="uea">CODE <span>*</span></label>
                                        <input type="text" name="code" placeholder="Enter code">
                                        @if ($errors->first('code'))
                                            <div class="invalid-alert text-danger">{{ $errors->first('code') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-grp-btn">
                                        <button type="submit" class="btn">{{ trans('language.verify') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- my-account-area-end -->

    </main>
    <!-- main-area-end -->
@else
    @include('frontend.layoutStatus.404')
@endif
@stop

@section('js_page')
@stop
