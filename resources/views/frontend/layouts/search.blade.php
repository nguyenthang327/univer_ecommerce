<div class="header-search-area d-none d-md-block">
    <div class="custom-container-two">
        <div class="row align-items-center">
            <div class="col-xl-3 col-lg-4 d-none d-lg-block">
                <div class="header-category d-none d-lg-block">
                    <a href="#" class="cat-toggle"><i class="flaticon-menu"></i>{{ trans('language.product_category') }}</a>
                    <ul class="category-menu">
                        @foreach($globalProductCategories as $key => $productCategory)
                        @if($key < 9)
                        <li class="has-dropdown">
                            <a href="{{ route('site.product.index', ['categorySlug' => $productCategory['slug'] ] )}}" class="d-flex justify-content-between align-items-center">
                                <div class="wrap-cat">
                                    <div class="cat-menu-img">
                                        <img src="{{asset('storage/'.$productCategory["thumbnail"])}}" alt="{{ $productCategory["name"] }}" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                    </div> {{ $productCategory["name"] }} 
                                </div>
                                @if(!empty($productCategory['_2_level_cate']))
                                    <span class="cate-arrow"><i class="fas fa-chevron-right"></i></span>
                                @endif
                            </a>
                            @if(!empty($productCategory['_2_level_cate']))
                            <ul class="mega-menu">
                                <li>
                                    <ul>
                                        @foreach ($productCategory['_2_level_cate'] as $item)
                                            <li><a href="{{ route('site.product.index', ['categorySlug' => $item['slug'] ] )}}">{{ $item['name']}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                            @endif
                        </li>
                        @else
                        <li class="has-dropdown">
                            <ul class="more_slide_open">
                                <li class="has-dropdown">
                                    <a href="#" class="d-flex justify-content-between align-items-center">
                                        <div class="wrap-cat">
                                            <div class="cat-menu-img">
                                                <img src="{{asset('storage/'.$productCategory["thumbnail"])}}" alt="{{ $productCategory["name"] }}" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                            </div> {{ $productCategory["name"] }} 
                                        </div>
                                        @if(!empty($productCategory['_2_level_cate']))
                                            <span class="cate-arrow"><i class="fas fa-chevron-right"></i></span>
                                        @endif
                                    </a>
                                    @if(!empty($productCategory['_2_level_cate']))
                                    <ul class="mega-menu">
                                        <li>
                                            <ul>
                                                @foreach ($productCategory['_2_level_cate'] as $item)
                                                    <li><a href="#">{{ $item['name']}}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                    @endif
                                </li>
                            </ul>
                        </li>
                        @endif
                        @endforeach
                        @if(count($globalProductCategories) > 9)
                            <li class="more_categories">{{ trans('language.see_more')}}<i class="fas fa-angle-down"></i></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                    <div class="header-search-wrap">
                        <form action="{{ route('site.product.index') }}">
                            <input type="text" placeholder="Search for your item's type....." name="search_keyword">
                            <select class="custom-select" name="search_category">
                                <option selected value="">{{ trans('language.all_categories')}}</option>
                                @foreach($globalProductCategories as $key => $productCategory)
                                    <option value="{{ $productCategory["id"] }}">{{ $productCategory['name'] }}</option>
                                @endforeach
                            </select>
                            <button><i class="flaticon-magnifying-glass-1"></i></button>
                        </form>
                    </div>
                    <div class="header-free-shopping">
                        <p>Free Shipping on Orders <span>$39+</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>