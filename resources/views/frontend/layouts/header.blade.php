
<!-- header-area -->
<header class="header-style-two">

    <!-- header-top -->
    <div class="header-top-area">
        <div class="custom-container-two">
            <div class="row">
                <div class="col-md-8 col-sm-7">
                    <div class="header-top-left">
                        <ul>
                            <li>
                                <div class="ship-to">
                                    <span>Ship to</span>
                                    <div class="dropdown">
                                        @php
                                            $language = \App\Models\Language::where('name', session('locale'))->first();
                                        @endphp
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            {{-- <img src="img/icon/ship_flag.png" alt="">  --}}
                                            {{$language ? $language->display_name : 'Việt Nam'}}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{route('changeLanguage', ['locale'=> 'vi'])}}">
                                                {{-- <img src="img/icon/australia.png" alt=""> --}}
                                                Việt Nam</a>
                                            <a class="dropdown-item" href="{{route('changeLanguage', ['locale'=> 'en'])}}">
                                                {{-- <img src="img/icon/australia.png" alt=""> --}}
                                                English</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="heder-top-guide">
                                    <span>Quick Guide</span>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Help
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item" href="javascript:void(0)">Returns</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Privacy</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{-- <li>
                                <div class="heder-top-guide">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton3" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Sell With Us
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <a class="dropdown-item" href="javascript:void(0)">Seller Login</a>
                                        </div>
                                    </div>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-5">
                    <div class="header-top-right">
                        <ul>
                            <li>
                                @if(!$globalCustomer)
                                    <a href="{{route('customer.register.step1')}}"><i class="flaticon-user"></i>{{ trans('language.customer_register.title') }}</a>
                                    <span>{{ trans('language.or') }}</span>
                                    <a href="{{route('login')}}">{{ trans('language.customer_login.title_header') }}</a>
                                @else
                                    <a class="nav-link" href="#" data-toggle="dropdown" role="button">
                                        <i class="fas fa-user-tie" aria-hidden="true"></i>
                                        <span>{{ $globalCustomer->full_name }}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-center">
                                        <a href="{{route('customer.index')}}">
                                        <img class="header-avartar avatar-customer"
                                            src="{{ !empty($globalCustomer->avatar) ? asset('storage/'.$globalCustomer->avatar) : '' }}"
                                            alt="{{ $globalCustomer->full_name }}"
                                            onerror="this.onerror=null;this.src='{{ asset('images/user-default.png') }}';"
                                            />
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <div class="customer-action d-flex flex-column align-items-center">
                                            <a href="{{route('customer.order.orderHistory')}}" class="dropdown-item font-weight-bold">
                                                {{-- <i class="fa fa-key"></i>  --}}
                                                {{trans('language.order_history')}}</a>
                                            <a href="" class="dropdown-item font-weight-bold" data-toggle="modal" data-target="#modalChangePassword">
                                                {{-- <i class="fa fa-key"></i>  --}}
                                                {{trans('language.change_password')}}</a>
                                            <a href="#"
                                                class="dropdown-item font-weight-bold ml-3"
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"
                                                >
                                                {{trans('language.logout')}}
                                                <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                                                <!-- <span class="float-right text-muted text-sm"></span> -->
                                                <form id="logout-form" action="{{route('customer.logout')}}" method="post">
                                                    @csrf
                                                </form>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header-top-end -->

    <!-- menu-area -->
    <div id="sticky-header" class="main-header menu-area">
        <div class="custom-container-two">
            <div class="row">
                <div class="col-12">
                    <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                    <div class="menu-wrap">
                        <nav class="menu-nav show">
                            <div class="logo">
                                <a href="{{ route('site.home')}}">
                                    <img src="{{ asset('images/main-logo-edited.png')}}" class="logo-img" alt="Logo">
                                    <span class="shop-name">V SHOP</span>
                                </a>
                            </div>
                            @php
                                $currentRoute = Route::current()->getName();
                                // $shopShow = ['site.product.index', 'site.product.show'];
                            @endphp
                            <div class="navbar-wrap main-menu d-none d-lg-flex">
                                <ul class="navigation">
                                    <li class="{{$currentRoute == 'site.home' ? 'active' : ''}} dropdown"><a href="{{ route('site.home') }}">{{ trans('language.home') }}</a>
                                    </li>
                                    <li class="{{$currentRoute == 'site.product.index' ? 'active' : ''}} dropdown"><a href="{{ route('site.product.index') }}">SHOP</a>
                                        {{-- <ul class="submenu">
                                            <li><a href="shop-left-sidebar.html">Shop Left Sidebar</a></li>
                                        </ul> --}}
                                    </li>
                                    {{-- <li><a href="special.html">SPECIAL</a></li>
                                    <li><a href="contact.html">contacts</a></li> --}}
                                </ul>
                            </div>
                            <div class="header-action d-none d-md-block header-cart-mini">
                                @php
                                    $checkCart = isset($globalProductsInCart) && count($globalProductsInCart) > 0 ? true : false;
                                    $subTotal = 0;
                                @endphp
                                <ul>
                                    {{-- <li><a href="#"><i class="flaticon-two-arrows"></i></a></li> --}}
                                    <li><a href="{{route('customer.product.listFavoriteProduct')}}"><i class="flaticon-heart"></i></a></li>
                                    <li class="header-shop-cart"><a href="{{ route('customer.cart.index') }}">
                                        <i class="flaticon-shopping-bag"></i>
                                        <span class="cart-count">{{$checkCart ? count($globalProductsInCart) : 0}}</span>
                                    </a>
                                        @if($globalCustomer && $checkCart)
                                        {{-- <span class="cart-total-price">$ 128.00</span> --}}
                                            <ul class="minicart">
                                            @foreach ($globalProductsInCart as $product)
                                            @php
                                                $price = \App\Services\ProcessPriceService::regularPrice($product->price, null);
                                                $aSubTotal = \App\Services\ProcessPriceService::regularPrice($product->price * $product->quantity, null);
                                                $subTotal += $product->price * $product->quantity;
                                            @endphp
                                                <li class="d-flex align-items-start">
                                                    <div class="cart-img">
                                                        <a href="#">
                                                            <img
                                                                {{-- class="imageInCart" --}}
                                                                src="{{ !empty($product->product_gallery) ? asset('storage/'.json_decode($product->product_gallery)[0]->file_path) : '' }}"
                                                                alt="{{ $product->product_name }}"
                                                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                                                            >
                                                        </a>
                                                    </div>
                                                    <div class="cart-content">
                                                        <h4>
                                                            <a href="{{ route('site.product.show', ['slug' =>$product->product_slug]) }}" class="line-clamp-3">{{ $product->product_name }}</a>
                                                        </h4>
                                                        @if($product->attributes)
                                                            <p style="word-wrap: break-word;">{{$product->attributes}}</p>
                                                        @endif
                                                        <div class="cart-price">
                                                            <span class="new">{{$price['new']}} x {{ $product->quantity}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="del-icon">
                                                        <a href="#">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                                @endforeach

                                                @php
                                                    if(session('coupon_code')){
                                                        $total = \App\Services\ProcessPriceService::regularPrice($subTotal, session('coupon_code')['discount']);
                                                        $valueTotal = $subTotal - ($subTotal * session('coupon_code')['discount'] / 100);
                                                    }else{
                                                        $total = \App\Services\ProcessPriceService::regularPrice($subTotal, null);
                                                        $valueTotal = $subTotal;
                                                    }
                                                    $subTotal = \App\Services\ProcessPriceService::regularPrice($subTotal, null);
                                                    // session()->forget('cart_total');
                                                    session()->put('cart_total', [
                                                        'subTotal' => $subTotal,
                                                        'total' => $total,
                                                        'valueTotal' => round($valueTotal,2),
                                                    ]);
                                                @endphp
                                                <li>
                                                    <div class="total-price">
                                                        <span class="f-left">{{trans('language.subtotal')}}:</span>
                                                        <span class="f-right subtotal">{{$subTotal['new']}}</span>
                                                    </div>
                                                </li>
                                                @if(session('coupon_code'))
                                                <li>
                                                    <div class="">
                                                        <span class="f-left">{{trans('language.discount')}}:</span>
                                                        <span class="f-right">{{ session('coupon_code')['discount'] }} %</span>
                                                    </div>
                                                </li>
                                                @endif
                                                <li>
                                                    <div class="font-weight-bold">
                                                        <span class="f-left">{{trans('language.total')}}:</span>
                                                        <span class="f-right total">{{$total['new']}}</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkout-link">
                                                        <a href="{{route('customer.cart.index')}}">{{trans('language.shopping_cart')}}</a>
                                                        <a class="red-color" href="{{route('customer.order.checkoutView')}}">{{trans('language.checkout')}}</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Mobile Menu  -->
                    <div class="mobile-menu">
                        <div class="menu-backdrop"></div>
                        <div class="close-btn"><i class="fas fa-times"></i></div>

                        <nav class="menu-box">
                            <div class="nav-logo"><a href="{{route('site.home')}}"><img src="{{ asset('images/main-logo-edited.png')}}" alt="" title=""></a>
                            </div>
                            <div class="menu-outer">
                                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                            </div>
                            <div class="social-links">
                                <ul class="clearfix">
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- End Mobile Menu -->
                </div>
            </div>
        </div>
    </div>
    <!-- menu-area-end -->

    <!-- header-search-area -->
    @include('frontend.layouts.search')
    <!-- header-search-area-end -->
{{-- @dd( $subTotal); --}}
</header>
<!-- header-area-end -->