@extends('frontend.layouts.master')
@section('title',trans('language.product-detail'))

@section('css_page')
    <style>
        .option_value_button.active{
            border: 1px solid red;
            color:red;
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

        <!-- breadcrumb-area -->
        <section class="breadcrumb-area breadcrumb-bg" data-background="img/bg/breadcrumb_bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-content text-center">
                            <h2>Shop Single</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Shop Details</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span>- 3 Customer Reviews</span>
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
                                    <form action="#">
                                        <div class="cart-plus-minus">
                                            <input type="text" value="1">
                                        </div>
                                    </form>
                                </div>
                                <a href="#" class="btn add-card-btn">ADD TO CART</a>
                            </div>
                            <div class="shop-details-bottom">
                                <h5><a href="#"><i class="far fa-heart"></i> Add To Wishlist</a></h5>
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
                        <div class="product-desc-wrap mb-100">
                            <ul class="nav nav-tabs mb-25" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details"
                                        aria-selected="true">Product Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="val-tab" data-toggle="tab" href="#val" role="tab" aria-controls="val"
                                        aria-selected="false">Viewers Also Like</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="looks-tab" data-toggle="tab" href="#looks" role="tab" aria-controls="looks"
                                        aria-selected="false">Looks</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review"
                                        aria-selected="false">Product Reviews</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="qa-tab" data-toggle="tab" href="#qa" role="tab" aria-controls="qa"
                                        aria-selected="false">Q&A</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                    <div class="product-desc-content">
                                        <h4 class="title">Product Details</h4>
                                        <div class="row">
                                            <div class="col-xl-3 col-md-4">
                                                <div class="product-desc-img">
                                                    <img src="img/product/desc_img.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-md-8">
                                                <h5 class="small-title">The Christina Fashion</h5>
                                                <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into electronic typesetting, remaining Lorem
                                                Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                <ul class="product-desc-list">
                                                    <li>65% poly, 35% rayon</li>
                                                    <li>Hand wash cold</li>
                                                    <li>Partially lined</li>
                                                    <li>Hidden front button closure with keyhole accents</li>
                                                    <li>Button cuff sleeves</li>
                                                    <li>Made in USA</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="val" role="tabpanel" aria-labelledby="val-tab">
                                    <div class="product-desc-content">
                                        <h4 class="title">Product Details</h4>
                                        <div class="row">
                                            <div class="col-xl-3 col-md-4">
                                                <div class="product-desc-img">
                                                    <img src="img/product/desc_img.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-md-8">
                                                <h5 class="small-title">The Christina Fashion</h5>
                                                <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into electronic typesetting, remaining Lorem
                                                Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                <ul class="product-desc-list">
                                                    <li>65% poly, 35% rayon</li>
                                                    <li>Hand wash cold</li>
                                                    <li>Partially lined</li>
                                                    <li>Hidden front button closure with keyhole accents</li>
                                                    <li>Button cuff sleeves</li>
                                                    <li>Made in USA</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="looks" role="tabpanel" aria-labelledby="looks-tab">
                                    <div class="product-desc-content">
                                        <h4 class="title">Product Details</h4>
                                        <div class="row">
                                            <div class="col-xl-3 col-md-4">
                                                <div class="product-desc-img">
                                                    <img src="img/product/desc_img.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-md-8">
                                                <h5 class="small-title">The Christina Fashion</h5>
                                                <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into electronic typesetting, remaining Lorem
                                                Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                <ul class="product-desc-list">
                                                    <li>65% poly, 35% rayon</li>
                                                    <li>Hand wash cold</li>
                                                    <li>Partially lined</li>
                                                    <li>Hidden front button closure with keyhole accents</li>
                                                    <li>Button cuff sleeves</li>
                                                    <li>Made in USA</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                    <div class="product-desc-content">
                                        <h4 class="title">Product Details</h4>
                                        <div class="row">
                                            <div class="col-xl-3 col-md-4">
                                                <div class="product-desc-img">
                                                    <img src="img/product/desc_img.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-md-8">
                                                <h5 class="small-title">The Christina Fashion</h5>
                                                <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into electronic typesetting, remaining Lorem
                                                Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                <ul class="product-desc-list">
                                                    <li>65% poly, 35% rayon</li>
                                                    <li>Hand wash cold</li>
                                                    <li>Partially lined</li>
                                                    <li>Hidden front button closure with keyhole accents</li>
                                                    <li>Button cuff sleeves</li>
                                                    <li>Made in USA</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="qa" role="tabpanel" aria-labelledby="qa-tab">
                                    <div class="product-desc-content">
                                        <h4 class="title">Product Details</h4>
                                        <div class="row">
                                            <div class="col-xl-3 col-md-4">
                                                <div class="product-desc-img">
                                                    <img src="img/product/desc_img.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-md-8">
                                                <h5 class="small-title">The Christina Fashion</h5>
                                                <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into electronic typesetting, remaining Lorem
                                                Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                <ul class="product-desc-list">
                                                    <li>65% poly, 35% rayon</li>
                                                    <li>Hand wash cold</li>
                                                    <li>Partially lined</li>
                                                    <li>Hidden front button closure with keyhole accents</li>
                                                    <li>Button cuff sleeves</li>
                                                    <li>Made in USA</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shop-details-add mb-95">
                            <a href="#"><img src="img/product/shop_details_add.jpg" alt=""></a>
                        </div>
                        <div class="related-product-wrap pb-95">
                            <div class="deal-day-top">
                                <div class="deal-day-title">
                                    <h4 class="title">Viewers Also Liked</h4>
                                </div>
                                <div class="related-slider-nav">
                                    <div class="slider-nav"></div>
                                </div>
                            </div>
                            <div class="row related-product-active">
                                <div class="col-xl-3">
                                    <div class="exclusive-item exclusive-item-three text-center">
                                        <div class="exclusive-item-thumb">
                                            <a href="shop-details.html">
                                                <img src="img/product/td_product_img01.jpg" alt="">
                                                <img class="overlay-product-thumb" src="img/product/t_exclusive_product01.jpg" alt="">
                                            </a>
                                            <ul class="action">
                                                <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                                <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                                <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="exclusive-item-content">
                                            <h5><a href="shop-details.html">Farfetch Mulberry Belted</a></h5>
                                            <div class="exclusive--item--price">
                                                <del class="old-price">$69.00</del>
                                                <span class="new-price">$58.00</span>
                                            </div>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="exclusive-item exclusive-item-three text-center">
                                        <div class="exclusive-item-thumb">
                                            <a href="shop-details.html">
                                                <img src="img/product/td_product_img02.jpg" alt="">
                                                <img class="overlay-product-thumb" src="img/product/td_product_img05.jpg" alt="">
                                            </a>
                                            <ul class="action">
                                                <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                                <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                                <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="exclusive-item-content">
                                            <h5><a href="shop-details.html">Luxury Fashion Bag</a></h5>
                                            <div class="exclusive--item--price">
                                                <del class="old-price">$69.00</del>
                                                <span class="new-price">$29.00</span>
                                            </div>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="exclusive-item exclusive-item-three text-center">
                                        <div class="exclusive-item-thumb">
                                            <a href="shop-details.html">
                                                <img src="img/product/td_product_img03.jpg" alt="">
                                                <img class="overlay-product-thumb" src="img/product/t_exclusive_product04.jpg" alt="">
                                            </a>
                                            <ul class="action">
                                                <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                                <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                                <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="exclusive-item-content">
                                            <h5><a href="shop-details.html">Men's Lathers Jacket</a></h5>
                                            <div class="exclusive--item--price">
                                                <del class="old-price">$69.00</del>
                                                <span class="new-price">$58.00</span>
                                            </div>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="exclusive-item exclusive-item-three text-center">
                                        <div class="exclusive-item-thumb">
                                            <a href="shop-details.html">
                                                <img src="img/product/td_product_img04.jpg" alt="">
                                                <img class="overlay-product-thumb" src="img/product/td_product_img05.jpg" alt="">
                                            </a>
                                            <ul class="action">
                                                <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                                <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                                <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="exclusive-item-content">
                                            <h5><a href="shop-details.html">Women Brand T-shirt</a></h5>
                                            <div class="exclusive--item--price">
                                                <del class="old-price">$49.00</del>
                                                <span class="new-price">$21.00</span>
                                            </div>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="exclusive-item exclusive-item-three text-center">
                                        <div class="exclusive-item-thumb">
                                            <a href="shop-details.html">
                                                <img src="img/product/td_product_img02.jpg" alt="">
                                                <img class="overlay-product-thumb" src="img/product/td_product_img05.jpg" alt="">
                                            </a>
                                            <ul class="action">
                                                <li><a href="#"><i class="flaticon-shuffle-1"></i></a></li>
                                                <li><a href="#"><i class="flaticon-supermarket"></i></a></li>
                                                <li><a href="#"><i class="flaticon-witness"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="exclusive-item-content">
                                            <h5><a href="shop-details.html">Luxury Fashion Bag</a></h5>
                                            <div class="exclusive--item--price">
                                                <del class="old-price">$69.00</del>
                                                <span class="new-price">$29.00</span>
                                            </div>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-reviews-wrap">
                            <div class="deal-day-top">
                                <div class="deal-day-title">
                                    <h4 class="title">Product Reviews</h4>
                                </div>
                            </div>
                            <div class="reviews-count-title">
                                <h5 class="title">3 review for Pouch Pocket Jacket</h5>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="product-review-list blog-comment">
                                        <ul>
                                            <li>
                                                <div class="single-comment">
                                                    <div class="comment-avatar-img">
                                                        <img src="img/product/review_author_thumb01.jpg" alt="img">
                                                    </div>
                                                    <div class="comment-text">
                                                        <div class="comment-avatar-info">
                                                            <h5>Emaliy Watson <span class="comment-date"> - November 13, 2020</span></h5>
                                                            <div class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </div>
                                                        </div>
                                                        <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into electronic typesetting, remaining.</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="single-comment">
                                                    <div class="comment-avatar-img">
                                                        <img src="img/product/review_author_thumb02.jpg" alt="img">
                                                    </div>
                                                    <div class="comment-text">
                                                        <div class="comment-avatar-info">
                                                            <h5>Tomas Alexzender <span class="comment-date"> - November 13, 2020</span></h5>
                                                            <div class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </div>
                                                        </div>
                                                        <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into electronic typesetting, remaining.</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="single-comment">
                                                    <div class="comment-avatar-img">
                                                        <img src="img/product/review_author_thumb03.jpg" alt="img">
                                                    </div>
                                                    <div class="comment-text">
                                                        <div class="comment-avatar-info">
                                                            <h5>Rana Watson <span class="comment-date"> - November 13, 2020</span></h5>
                                                            <div class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </div>
                                                        </div>
                                                        <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into electronic typesetting, remaining.</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="single-comment">
                                                    <div class="comment-avatar-img">
                                                        <img src="img/product/review_author_thumb04.jpg" alt="img">
                                                    </div>
                                                    <div class="comment-text">
                                                        <div class="comment-avatar-info">
                                                            <h5>Emaliy Watson <span class="comment-date"> - November 13, 2020</span></h5>
                                                            <div class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </div>
                                                        </div>
                                                        <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into electronic typesetting, remaining.</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="product-review-form">
                                        <p>Your email address will not be published. Required fields are marked *</p>
                                        <div class="rising-star mb-40">
                                            <h5>Your Rating</h5>
                                            <div class="rising-rating"></div>
                                        </div>
                                        <form action="#">
                                            <div class="form-grp">
                                                <label for="message">YOUR REVIEW *</label>
                                                <textarea name="message" id="message"></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-grp">
                                                        <label for="uea">YOUR NAME *</label>
                                                        <input type="text" id="uea">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-grp">
                                                        <label for="email">YOUR Email *</label>
                                                        <input type="email" id="email">
                                                    </div>
                                                </div>
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
    @include('frontend.product.scriptProductDetail')
@stop
       