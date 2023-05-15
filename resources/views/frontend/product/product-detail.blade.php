@extends('frontend.layouts.master')
@section('title',trans('language.product_detail'))

@section('css_page')
    <style>
        .option_value_button.active{
            border: 1px solid red;
            color:red;
        }
        .rating_avg{
            font-size: 18px;
            color:#ff6000;
            text-decoration: underline;
            font-weight: bold
        }
        .product-variation--disabled,
        .product-variation-important--disabled{
            color: rgba(0,0,0,.26) !important;
            cursor: not-allowed !important;
            border-color: rgba(0,0,0,.09) !important;
        }
    </style>
@stop

@section('content')
    <!-- main-area -->
    <main>
        @include('frontend.layouts.breadcrumb', [
            'title' => trans('language.product'),
            'breadcrumbItem' => trans('language.product_detail'),
        ])
        <!-- breadcrumb-area-end -->

        <!-- shop-details-area -->
        @php
            $checkVariant = $product->product_type == \App\Models\Product::TYPE_VARIANT && $product->skus->isNotEmpty();
            $data = [];
            $stock = '';
            if($checkVariant){
                $stock = $product->skus->sum('stock');
                $data = \App\Services\ProcessPriceService::variantPrice($product->skus->min('price'), $product->skus->max('price'), $product->discount);
            }else{
                $data = \App\Services\ProcessPriceService::regularPrice($product->price, $product->discount);
                $stock = $product->stock;
            };
        @endphp
        <section class="shop-details-area pt-100 pb-100">
            <div class="container">
                <div class="row mb-95">
                    <div class="col-xl-7 col-lg-6">
                        <div class="shop-details-nav-wrap">
                            <div class="shop-details-nav">
                                @if(isset($product->gallery) && !empty($product->gallery))
                                    @foreach($product->gallery as $item)
                                    <div class="shop-nav-item">
                                        <img src="{{ asset('storage/'. $item['file_path']) }}" alt="" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                    </div>
                                    @endforeach
                                @else
                                <div class="shop-nav-item">
                                    <img src="" alt="" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="shop-details-img-wrap">
                            <div class="shop-details-active">
                                @if(isset($product->gallery) && !empty($product->gallery))
                                    @foreach($product->gallery as $item)
                                    <div class="shop-details-img">
                                        <a href="{{ asset('storage/'. $item['file_path']) }}" class="popup-image"><img src="{{ asset('storage/'. $item['file_path']) }}" alt="" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"></a>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="shop-details-img">
                                        <a href="javascript:void(0)" class="popup-image"><img src="img/product/shop_details_img01.jpg" alt="" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"></a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <div class="shop-details-content">
                            <span class="stock-info">In Stock</span>
                            <h2 class="line-clamp-2">{{ $product->name }}</h2>
                            <div class="shop-details-review">
                                <span class="mr-2 rating_avg" style="">{{$product->rating_avg}}</span>
                                <div class="rating detail" style="color:#ff6000" data-rating_value="{{$product->rating_avg}}">
                                    {{-- <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i> --}}
                                </div>
                                <span>- {{trans('language.number_review', ['quantity' => $productComments->total()])}}</span>
                            </div>
                            <div class="shop-details-price">
                                <h2> @if($data['old']) <del>{{ $data['old'] }}</del> @endif {{ $data['new'] }} </h2>
                            </div>
                            <p class="line-clamp-2">{{ $product->desciption}}</p>
                            @if($checkVariant)
                                <form method="get" id="form_change_option_value" data-product="{{ $product }}">
                                    @foreach($product->options as $key => $option)
                                    <div class="product-details-size mb-3 row pr_variant pr-option-{{ $option->id }}" data-option_id="{{ $option->id }}">
                                        <span class="col-2">{{ $option->name}} : </span>
                                        <input type="hidden" name="option_{{$key}}" value="" class="option_value">
                                        <ul class="col-8">
                                            @foreach($option->optionValues as $optionValue)
                                            @php
                                                $skuID = $product->variants->where('product_option_value_id', $optionValue->id)->pluck('sku_id');
                                                $checkOptionHaveNotSku = $product->skus->whereIn('id', $skuID)->where('stock', '>', 0)->whereNotNull('price')->isEmpty();
                                            @endphp
                                                {{-- @dd($product->variants) --}}
                                                <li><a href="#" class="option_value_button {{$checkOptionHaveNotSku ? 'product-variation-important--disabled' : ''}}" data-option_value_id="{{ $optionValue->id }}">{{ $optionValue->value }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                </form>
                            @endif
                            <div class="mb-3">
                                <span>{{ trans('language.stock') }} : <span class="product-detail-stock">{{ $stock > 0 ? $stock : trans('language.out_stock') }}</span></span>
                            </div>
                            <div class="perched-info">
                                <div class="cart-plus">
                                    <div class="cart-plus-minus">
                                        <input type="text" value="1" name="quantity" data-max="{{$stock}}">
                                        <div class="dec qtybutton">-</div>
                                        <div class="inc qtybutton">+</div>
                                    </div>
                                </div>
                                <a href="#" class="btn add-cart-btn" id="add-cart" data-url="{{route('customer.cart.store')}}" data-product_id="{{$product->id}}">ADD TO CART</a>
                            </div>
                            <div class="shop-details-bottom">
                                <h5>
                                    <a href="#"
                                        data-url="{{route('customer.product.favoriteStore')}}"
                                        id="add-wishlist"
                                        data-product_id="{{$product->id}}"
                                        @if($product->favoriteID) style="color:#ff6000;" @endif
                                        >
                                        <i class="far fa-heart"></i> Add To Wishlist
                                    </a>
                                </h5>
                                <ul>
                                    @if($product->brand_name)
                                        <li>
                                            <span>{{trans('language.brand')}} : </span>
                                            <a href="javascript:void(0)">{{ $product->brand_name }}</a>
                                        </li>
                                    @endif
                                    <li>
                                        <span>{{trans('language.product_category')}} :</span>
                                        @if($categoryInProduct)
                                            @php
                                                $count = count($categoryInProduct);
                                            @endphp
                                            @foreach($categoryInProduct as $key => $category)
                                                <a href="{{ $category->slug }}">{{ $category->name }}{{ ($key != $count - 1) ? ',' : '' }}</a>
                                            @endforeach
                                        @else
                                            <a href="javascript:void(0)">{{ trans('language.other') }}</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if($product->description)
                        <div class="product-desc-wrap mb-100">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                    <div class="product-desc-content">
                                        <h4 class="title">{{trans('language.description')}}</h4>
                                        <div class="row">
                                            <div class="col-xl-2 col-md-2">
                                                {{-- <div class="product-desc-img">
                                                    <img src="img/product/desc_img.jpg" alt="">
                                                </div> --}}
                                            </div>
                                            <div class="col-xl-10 col-md-10">
                                                <h5 class="small-title">{{$product->name}}</h5>
                                                <p>{!! $product->description !!}</p>
                                                {{-- <ul class="product-desc-list">
                                                    <li>65% poly, 35% rayon</li>
                                                    <li>Hand wash cold</li>
                                                    <li>Partially lined</li>
                                                    <li>Hidden front button closure with keyhole accents</li>
                                                    <li>Button cuff sleeves</li>
                                                    <li>Made in USA</li>
                                                </ul> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- <div class="shop-details-add mb-95">
                            <a href="#"><img src="img/product/shop_details_add.jpg" alt=""></a>
                        </div> --}}

                        @if(count($relatedProduct) > 0)

                        <div class="related-product-wrap pb-95">
                            <div class="deal-day-top">
                                <div class="deal-day-title">
                                    <h4 class="title">{{trans('language.product_related')}}</h4>
                                </div>
                                <div class="related-slider-nav">
                                    <div class="slider-nav"></div>
                                </div>
                            </div>
                            <div class="row related-product-active">
                                @foreach($relatedProduct as $item)
                                    @php
                                        $checkVariant = $item->product_type == \App\Models\Product::TYPE_VARIANT && $item->skus->isNotEmpty();
                                        $data = [];
                                        if($checkVariant){
                                            $data = \App\Services\ProcessPriceService::variantPrice($item->skus[0]->min_price, $item->skus[0]->min_price, $item->discount);
                                        }else{
                                            $data = \App\Services\ProcessPriceService::regularPrice($item->price, $item->discount);
                                        };
                                    @endphp
                                    <div class="col-xl-3">
                                        <div class="exclusive-item exclusive-item-three text-center">
                                            <div class="exclusive-item-thumb">
                                                <a href="{{ route('site.product.show', ['slug' => $item->slug]) }}">
                                                    {{-- <img src="img/product/td_product_img01.jpg" alt="">
                                                    <img class="overlay-product-thumb" src="img/product/t_exclusive_product01.jpg" alt=""> --}}
                                                    <img src="{{ !empty($item->gallery) ? asset('storage/'.$item->gallery[0]['file_path']) : '' }}" alt="" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                                </a>
                                                {{-- <ul class="action">
                                                    <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                                    <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                                    <li><a href="{{ route('site.product.show', ['slug' => $item->slug]) }}"><i class="flaticon-witness"></i></a></li>
                                                </ul> --}}
                                            </div>
                                            <div class="exclusive-item-content">
                                                <h5><a class="line-clamp-2" href="{{ route('site.product.show', ['slug' => $item->slug]) }}">{{$item->name}}</a></h5>
                                                <div class="exclusive--item--price">
                                                    @if($data['old'] )
                                                        <del class="old-price">{{ $data['old'] }}</del>
                                                    @endif
                                                    <span class="new-price">{{ $data['new'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        <div class="product-reviews-wrap">
                            <div class="deal-day-top">
                                <div class="deal-day-title">
                                    <h4 class="title">Product Reviews</h4>
                                </div>
                            </div>
                            <div class="reviews-count-title">
                                <h5 class="title">{{trans('language.number_review', ['quantity' => $productComments->total()])}}</h5>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="product-review-list blog-comment">
                                        <ul>
                                            @foreach($productComments as $comment)
                                            <li>
                                                <div class="single-comment">
                                                    <div class="comment-avatar-img">
                                                        <img src="{{ asset('storage/'. $comment->avatar) }}" alt="" onerror="this.onerror=null;this.src='{{ asset('images/user-default.png') }}';">

                                                    </div>
                                                    <div class="comment-text" style="width:100%">
                                                        <div class="comment-avatar-info">
                                                            {{-- - November 13, 2020 --}}
                                                            <h5>{{ $comment->customer_name }} <span class="comment-date"> - {{ Carbon\Carbon::parse($comment->created_at)->toDayDateTimeString()}}</span></h5>
                                                            <div class="rating">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star {{ $comment->rating >= $i ? 'active' : ''}} "></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <p>{{ $comment->content}}</p>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="product-review-form">
                                        <p>{{trans('language.reuquired_comment')}}</p>
                                        <form action="{{route('customer.comment.product.store')}}" id="rating_product" method="POST">
                                            <input type="hidden" name="product_id" value={{$product->id}} >
                                            <div class="form-grp">
                                                <div class="rising-star mb-20">
                                                    <h5>Your Rating *</h5>
                                                    <div class="rising-rating"></div>
                                                    <input type="hidden" name="rating" value="" style="display: inline-block;">
                                                    <div id="rating-error" class="error hidden-error"></div>
                                                </div>
                                            </div>
                                            <div class="form-grp">
                                                <label for="content">YOUR REVIEW *</label>
                                                <textarea name="content" id="content_comment"></textarea>
                                            </div>
                                            <button class="btn">SUBMIT</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- shop-details-area-end -->


    </main>
    <!-- main-area-end -->
@stop

@section('js_page')
    {{-- @if($checkVariant) --}}
        @include('frontend.product.scriptProductDetail')
    {{-- @endif --}}
    <script src="{{asset('fe-assets/js/page/product/product-detail.js')}}"></script>
@stop
       