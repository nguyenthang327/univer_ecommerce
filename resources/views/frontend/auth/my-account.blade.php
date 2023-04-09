@extends('frontend.layouts.master')
@section('title', trans('language.customer_login'))

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
                                <span class="{{ isset($type) ? ($type == 'login' ? 'active' : '') : ''}}" id="login">Login</span> / <span class="{{ isset($type) ? ($type == 'register' ? 'active' : '') : ''}}" id="register">Register</span></h2>
                        </div>
                        <div class="my-account-bg" data-background="">
                            <div class="my-account-content" id="login-group">
                                {{-- <p>Welcome Vanam Please Login Your <span>Account</span></p>
                                <div class="direct-login">
                                    <a href="#"><i class="fab fa-facebook-f"></i>Login with facebook</a>
                                    <a href="#" class="xing"><i class="fab fa-xing"></i>Login with xing</a>
                                </div>
                                <span class="or">- OR -</span> --}}
                                <form action="#" class="login-form">
                                    <div class="form-grp">
                                        <label for="uea">USERNAME OR EMAIL ADDRESS <span>*</span></label>
                                        <input type="text" id="uea">
                                    </div>
                                    <div class="form-grp">
                                        <label for="password">PASSWORD <span>*</span></label>
                                        <input type="password" id="password">
                                        <i class="far fa-eye"></i>
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
                                        <a href="#" class="btn">Login</a>
                                        <a href="#" class="btn">Sign up</a>
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
                                <form action="{{ route('customer.register') }}" class="login-form" method="POST">
                                    @csrf
                                    <div class="form-grp">
                                        <label for="uea">USERNAME OR EMAIL ADDRESSds regist <span>*</span></label>
                                        <input type="text" id="uea" name="email">
                                    </div>
                                    <div class="form-grp">
                                        <label for="password">PASSWORD <span>*</span></label>
                                        <input type="password" id="password" name="password">
                                        <i class="far fa-eye"></i>
                                    </div>
                                    <div class="form-grp-bottom">
                                        <div class="remember">
                                            <input type="checkbox" id="check">
                                            <label for="check"  >Remember me</label>
                                        </div>
                                        <div class="forget-pass">
                                            {{-- <a href="#">forgot password</a> --}}
                                        </div>
                                    </div>
                                    <div class="form-grp-btn">
                                        <button type="submit" class="btn">Sign up</button>
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
    <script>
        function changeForm(){
            // var pathname = window.location.href;

            if($('#login').hasClass('active')){
                $('#login-group').removeClass('d-none');
                $('#register-group').addClass('d-none');

                window.history.replaceState(null, null, '/login');
                
            }else{
                $('#register-group').removeClass('d-none');
                $('#login-group').addClass('d-none');

                window.history.replaceState(null, null, '/register');
            }
        }

        $(document).ready(function(){
            changeForm();
            
            $('#login').on('click', function(){
                if(!$(this).hasClass('active')){
                    $(this).addClass('active')
                }
                $('#register').removeClass('active');
                changeForm();
            });
            $('#register').on('click', function(){
                if(!$(this).hasClass('active')){
                    $(this).addClass('active')
                }
                $('#login').removeClass('active');

                changeForm();
            })
        });
    </script>
@stop
