@extends('frontend.layouts.master')
@section('title', trans('language.customer_login.title'))

@section('css_page')
@stop

@section('content')

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
                                    <li class="breadcrumb-item"><a href="{{route('site.home')}}">Home</a></li>
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
                                <span class="{{ isset($type) ? ($type == 'login' ? 'active' : '') : ''}}" id="login">
                                    {{ trans('language.customer_login.title') }}
                                </span> / 
                                <span class="{{ isset($type) ? ($type == 'register' ? 'active' : '') : ''}}" id="register">
                                    {{ trans('language.customer_register.title') }}
                                </span>
                            </h2>
                        </div>
                        <div class="my-account-bg" data-background="">
                            <div class="my-account-content" id="login-group">
                                @if ($errors->first('error'))
                                    <div class="alert alert-danger text-center">
                                        {{ $errors->first('error') }}
                                    </div>
                                @endif
                                {{-- <p>Welcome Vanam Please Login Your <span>Account</span></p>
                                <div class="direct-login">
                                    <a href="#"><i class="fab fa-facebook-f"></i>Login with facebook</a>
                                    <a href="#" class="xing"><i class="fab fa-xing"></i>Login with xing</a>
                                </div>
                                <span class="or">- OR -</span> --}}
                                <form action="{{ route('customer.login') }}" method="POST" class="login-form" id="login-form">
                                    @csrf
                                    <div class="form-grp">
                                        <label for="email_login">{{trans('language.email')}} <span>*</span></label>
                                        <input type="text" name="email_login" value="{{ old('email_login') }}" placeholder="{{trans('language.enter_email')}}">
                                        @if ($errors->first('email_login'))
                                            <div class="invalid-alert text-danger">{{ $errors->first('email_login') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-grp">
                                        <label for="password_login">{{trans('language.password')}} <span>*</span></label>
                                        <input type="password" name="password_login" id="password_login" placeholder="{{trans('language.enter_password')}}">
                                        <i class="far fa-eye toggle-password" toggle="#password_login"></i>
                                        @if ($errors->first('password_login'))
                                            <div class="invalid-alert text-danger">{{ $errors->first('password_login') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-grp-bottom">
                                        <div class="remember">
                                            <input type="checkbox" id="check">
                                            <label for="check">Remember me</label>
                                        </div>
                                        <div class="forget-pass">
                                            {{-- <a href="#">forgot password</a> --}}
                                        </div>
                                    </div>
                                    <div class="form-grp-btn">
                                        <button type="submit" class="btn">{{ trans('language.login') }}</button>
                                    </div>
                                </form>
                            </div>

                            <div class="my-account-content" id="register-group">
                                {{-- <p>Welcome Vanam Please Login Your <span>Account</span></p>
                                <div class="direct-login">
                                    <a href="#"><i class="fab fa-facebook-f"></i>Login with facebook</a>
                                    <a href="#" class="xing"><i class="fab fa-xing"></i>Login with xing</a>
                                </div>
                                <span class="or">- OR -</span> --}}
                                <form action="{{ route('customer.register') }}" class="login-form" method="POST" id="register-form">
                                    @csrf
                                    <div class="form-grp row">
                                        <div class="col-6">
                                            <label for="first_name">{{trans('language.first_name')}} <span>*</span></label>
                                            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="{{trans('language.enter_first_name')}}" required>
                                            @if ($errors->first('first_name'))
                                                <div class="invalid-alert text-danger">{{ $errors->first('first_name') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <label for="last_name">{{trans('language.last_name')}} <span>*</span></label>
                                            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="{{trans('language.enter_last_name')}}" required>
                                            @if ($errors->first('last_name'))
                                                <div class="invalid-alert text-danger">{{ $errors->first('last_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-grp">
                                        <label for="email">{{ trans('language.email') }} <span>*</span></label>
                                        <input type="text" name="email" required placeholder="{{trans('language.enter_email')}}">
                                        @if ($errors->first('email'))
                                            <div class="invalid-alert text-danger">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-grp">
                                        <label for="password">{{ trans('language.password') }} <span>*</span></label>
                                        <input type="password" id="password" name="password" required placeholder="{{trans('language.enter_password')}}">
                                        <i class="far fa-eye toggle-password" toggle="#password"></i>
                                        @if ($errors->first('password'))
                                            <div class="invalid-alert text-danger">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-grp">
                                        <label for="password_confirmation">{{ trans('language.confirm_password') }} <span>*</span></label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" equalTo="#password" required placeholder="{{trans('language.enter_confirm_password') }}">
                                        <i class="far fa-eye toggle-password" toggle="#password_confirmation"></i>
                                        @if ($errors->first('password_confirmation'))
                                            <div class="invalid-alert text-danger">{{ $errors->first('password_confirmation') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-grp-bottom">
                                    </div>
                                    <div class="form-grp-btn">
                                        <button type="submit" class="btn">{{ trans('language.sign_up') }}</button>
                                        {{-- <a href="#" class="btn">Login</a> --}}
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
@stop

@section('js_page')
    <script src="{{ asset('fe-assets/js/page/auth/login-register.js') }}"></script>
@stop
