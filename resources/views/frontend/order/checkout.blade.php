@extends('frontend.layouts.master')
@section('title', trans('language.checkout'))

@section('css_page')
    <style>
    </style>
@stop

@section('css_library')
    @include('backend.libraryGroup.style-library', [
        'datepicker' => true,
        'icheck' => true,
        'select2' => true,
    ])
@stop

@section('content')
    <!-- main-area -->
    @if (!session('orderCompletedView'))
        <main>

            <!-- breadcrumb-area -->
            @include('frontend.layouts.breadcrumb', [
                'title' => trans('language.shopping_checkout'),
                'breadcrumbItem' => trans('language.checkout'),
            ])
            <!-- breadcrumb-area-end -->

            <!-- checkout-area -->
            <section class="checkout-area pt-100 pb-100">
                <div class="container">
                    <form action="{{ route('customer.order.store') }}" class="checkout-form" method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="checkout-wrap">
                                    <h5 class="title">{{ trans('language.billing_information') }}</h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-grp">
                                                <label for="fName">{{ trans('language.full_name') }}
                                                    <span>*</span></label>
                                                <input type="text" id="fName" name="full_name" required>
                                                @if ($errors->first('full_name'))
                                                    <div class="invalid-alert text-danger">{{ $errors->first('full_name') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $prefectures = \App\Models\Prefecture::orderBy('name')->get();
                                            $choose_prefecture = old('prefecture_id') ? old('prefecture_id') : (isset($admin->prefecture_id) ? $admin->prefecture_id : '');
                                            $districts = \App\Models\District::where('prefecture_id', $choose_prefecture)
                                                ->orderBy('name')
                                                ->get();
                                            $choose_district = old('district_id') ? old('district_id') : (isset($admin->district_id) ? $admin->district_id : '');
                                            $communes = \App\Models\Commune::where('district_id', $choose_district)
                                                ->orderBy('name')
                                                ->get();
                                            $choose_commune = old('commune_id') ? old('commune_id') : (isset($admin->commune_id) ? $admin->commune_id : '');
                                        @endphp
                                        <div class="col-4">
                                            <div class="form-grp">
                                                <label>{{ trans('language.prefecture') }} <span>*</span></label>
                                                <select class="custom-select select2-base dynamic-select-option"
                                                    style="width:100%" data-child="#select_district"
                                                    data-url="{{ route('getDistrictList') }}"
                                                    data-placeholder="{{ trans('language.choose_a_prefecture') }}"
                                                    name="prefecture_id" required>
                                                    <option value="" disabled selected style="display: none">
                                                        {{ trans('language.choose_prefecture') }}</option>
                                                    @if (isset($prefectures))
                                                        @foreach ($prefectures as $prefecture)
                                                            <option value="{{ $prefecture->id }}"
                                                                {{ $choose_prefecture == $prefecture->id ? 'selected' : '' }}>
                                                                {{ $prefecture->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->first('prefecture_id'))
                                                    <div class="invalid-alert text-danger">
                                                        {{ $errors->first('prefecture_id') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-grp">
                                                <label>{{ trans('language.district') }} <span>*</span></label>
                                                <select class="custom-select select2-base dynamic-select-option"
                                                    style="width:100%" name="district_id" data-child="#select_ward"
                                                    data-url="{{ route('getCommuneList') }}" id="select_district"
                                                    data-placeholder="{{ trans('language.choose_a_district') }}" required>
                                                    <option value="" disabled selected style="display: none">
                                                        {{ trans('language.choose_district') }}</option>
                                                    @if (isset($districts))
                                                        @foreach ($districts as $district)
                                                            <option value="{{ $district->id }}"
                                                                {{ $choose_district == $district->id ? 'selected' : '' }}>
                                                                {{ $district->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->first('district_id'))
                                                    <div class="invalid-alert text-danger">
                                                        {{ $errors->first('district_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-grp">
                                                <label>{{ trans('language.commune') }} <span>*</span></label>
                                                <select class="custom-select select2-base" id="select_ward"
                                                    data-placeholder="{{ trans('language.choose_a_commune') }}"
                                                    name="commune_id" style="width: 100%" required>
                                                    <option value="" disabled selected style="display: none">
                                                        {{ trans('language.choose_commune') }}</option>
                                                    @if (isset($communes))
                                                        @foreach ($communes as $commune)
                                                            <option value="{{ $commune->id }}"
                                                                {{ $choose_commune == $commune->id ? 'selected' : '' }}>
                                                                {{ $commune->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->first('commune_id'))
                                                    <div class="invalid-alert text-danger">
                                                        {{ $errors->first('commune_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-grp">
                                                <label for="address">{{ trans('language.address') }}
                                                    <span>*</span></label>
                                                <input type="text" id="address" name="address" required>
                                                @if ($errors->first('address'))
                                                    <div class="invalid-alert text-danger">{{ $errors->first('address') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-grp">
                                                <label for="phone">{{ trans('language.phone') }} <span>*</span></label>
                                                <input type="text" id="phone" name="phone" required>
                                                @if ($errors->first('phone'))
                                                    <div class="invalid-alert text-danger">{{ $errors->first('phone') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                        <div class="different-address custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="stda">
                                            <label class="custom-control-label" for="stda">SHIP TO A DIFFERENT ADDRESS?</label>
                                        </div>
                                    </div> --}}
                                        {{-- <div class="col-12">
                                        <div class="form-grp mb-0">
                                            <label for="message">ORDER you have NOTES <small>(OPTIONAL)</small></label>
                                            <textarea name="message" id="message" placeholder="About Your Special Delivery Notes"></textarea>
                                        </div>
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-8">
                                <aside class="shop-cart-sidebar checkout-sidebar">
                                    <div class="shop-cart-widget">
                                        <h6 class="title">{{trans('language.cart_total')}}</h6>
                                        <ul>
                                            <li class="order-subtotal"><span>{{ trans('language.subtotal') }}</span>
                                            </li>
                                            @if (session('coupon_code'))
                                                <li>
                                                    <span>{{ trans('language.discount') }}:</span>{{ session('coupon_code')['discount'] }}
                                                    %
                                                    <input type="hidden" name="code"
                                                        value="{{ session('coupon_code')['code'] }}">
                                                </li>
                                            @endif
                                            <li>
                                                <span>{{ trans('language.shipping') }}</span>
                                                <div class="shop-check-wrap">
                                                    {{-- <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">FLAT RATE: $15</label>
                                            </div> --}}
                                                    <div class="custom-checkbox">
                                                        {{-- <input type="checkbox" class="custom-control-input" id="customCheck2"> --}}
                                                        {{-- <label class="custom-control-label" for="customCheck2">FREE SHIPPING</label> --}}
                                                        <span class="font-weight-bold"
                                                            for="customCheck2">{{ trans('language.free_shipping') }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="cart-total-amount order-total">
                                                <span>{{ trans('language.total') }}</span> <span class="amount"></span>
                                            </li>
                                        </ul>
                                        <input type="hidden" class="custom-control-input" id="customCheck4"
                                            name="payment_method" value="{{ \App\Models\Order::PAYMENT_CASH }}">
                                        {{-- <div class="bank-transfer">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck3">
                                        <label class="custom-control-label" for="customCheck3">Direct Bank Transfer</label>
                                    </div>
                                </div> --}}
                                {{-- <div class="bank-transfer">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck4" name="payment_method" value="{{ \App\Models\Order::PAYMENT_CASH}}" checked>
                                        <label class="custom-control-label" for="customCheck4" >{{trans('language.cash_on_delivery')}}</label>
                                    </div>
                                </div>
                                <div class="paypal-method">
                                    <div class="paypal-method-flex">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck5" name="payment_method" value="{{ \App\Models\Order::PAYMENT_PAYPAL}}">
                                            <label class="custom-control-label" for="customCheck5" >PayPal</label>
                                        </div>

                                        <div class="paypal-logo">
                                            <img src="{{asset('images/paypal_logo.png')}}" alt="">
                                            <div id="paypal-button-container"></div>

                                        </div>
                                    </div>
                                    <p>Pay via PayPal; you can pay with your credit
                                    card if you don’t have a PayPal account</p>
                                </div>
                                @if ($errors->first('payment_method'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('payment_method') }}
                                    </div>
                                @endif --}}
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
                                    <div><strong>{{trans('language.payment_by')}}</strong></div>
                                        <div id="paypal-button-container" class="mt-2"></div>
                                        <div class="text"><b>{{ trans('language.or') }}</b></div>
                                        <button type="submit" class="btn" style="margin-top: 16px">{{trans('language.order.payment_method')[0]}}</button>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- checkout-area-end -->

            <!-- core-features -->
            {{-- <section class="core-features-area core-features-style-two">
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
        </div> --}}
            </section>
            <!-- core-features-end -->

        </main>
    @else
        @include('frontend.order.order-completed')
    @endif
    <!-- main-area-end -->
@stop

@section('js_library')
    @include('backend.libraryGroup.script-library', ['datepicker' => true, 'select2' => true])
@stop

@section('js_page')
    <script src="{{ asset('common/js/common.js') }}"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AXSWPgMvKuvMc6Qrm-H3fbEIWSHn6vMo3TJRT5SKB6ixdKqkjsF6VqfVtwowOPWHoZbEQfSh6fgnXx7G&currency=USD&disable-funding=credit,card">
    </script>
    <script>
        $(document).ready(function() {

            $('.order-subtotal').append($('.f-right.subtotal').text());
            $('.order-total .amount').append($('.f-right.total').text());
            // $(document).on('click','#paypal-button-container', (function(e){
            //     e.preventDefault();
            // }))
            $("input[name='payment_method']:checkbox").on('click', function() {
                // in the handler, 'this' refers to the box clicked on
                var $box = $(this);
                if ($box.is(":checked")) {
                    // the name of the box is retrieved using the .attr() method
                    // as it is assumed and expected to be immutable
                    var group = "input:checkbox[name='" + $box.attr("name") + "']";
                    // the checked state of the group/box on the other hand will change
                    // and the current value is retrieved using .prop() method
                    $(group).prop("checked", false);
                    $box.prop("checked", true);
                } else {
                    $box.prop("checked", false);
                }
            });

            $(document).on('submit', '.checkout-form', function(e) {
                if ($("input[name='payment_method']:checked").val() == 1) {
                    e.preventDefault();

                }
            })

            $.validator.addMethod('regex_phone', function(value, element, param) {
                return /^(0[3|5|7|8|9])+([0-9]{8})\b$/.test(value);
            }, 'Số điện thoại không đúng định dạng');
            $(".checkout-form").validate({
                rules: {
                    full_name: {
                        required: true,
                        maxlength: 200,
                    },
                    prefecture_id: {
                        required: true,
                    },
                    district_id: {
                        required: true,
                    },
                    commune_id: {
                        required: true,
                    },
                    address: {
                        required: true,
                        maxlength: 100,
                    },
                    phone: {
                        required: true,
                        regex_phone: true,
                    },
                    // payment_method:{
                    //     required: true,
                    // }
                },
                messages: {
                    full_name: {
                        required: "Họ tên không được phép để trống",
                        maxlength: "Họ tên chỉ được tối đa 200 ký tự",
                    },
                    prefecture_id: {
                        required: "Thành phố/Tỉnh không được phép để trống",
                    },
                    district_id: {
                        required: "Quận/Huyện không được phép để trống",
                    },
                    commune_id: {
                        required: 'Phường/Xã không được phép để trống',
                    },
                    address: {
                        required: 'Địa chỉ không được phép để trống',
                        maxlength: 'Địa chỉ tối đa 100 ký tự',
                    },
                    phone: {
                        required: 'Số điện thoại không được phép để trống',
                    },
                    // payment_method:{
                    //     required: 'Vui lòng chọn hình thức thanh toán',
                    // }
                },
                errorClass: "invalid-alert text-danger",
                errorElement: "div",
                errorPlacement: function(error, element) {
                    console.log(element);
                    if (element.data("select2")) {
                        element.parent().append(error);
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                },
            });

            const total = {{ session('cart_total')['valueTotal'] }};

            paypal.Buttons({
                // style: {
                //     shape: 'rect',
                //     color: 'gold',
                //     layout: 'vertical',
                //     label: 'paypal',

                // },
                onClick: function(data, actions) {
                    return $('.checkout-form').valid();
                    // if ($('.checkout-form').valid()) {
                    //     // form is valid, enable PayPal button
                    //     actions.enable();
                    // } else {
                    //     // form is invalid, disable PayPal button
                    //     actions.disable();
                    //     return false;
                    // }
                },
                // Sets up the transaction when a payment button is clicked
                createOrder: (data, actions) => {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: total // Can also reference a variable or function
                            }
                        }]
                    });
                },

                onApprove: (data, actions) => {
                    let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
                    var fd = new FormData();
                    fd.append('full_name', $('.checkout-form input[name="full_name"]').val());
                    fd.append('prefecture_id', $('.checkout-form select[name="prefecture_id"] :selected').val());
                    fd.append('district_id', $('.checkout-form select[name="district_id"] :selected').val());
                    fd.append('commune_id', $('.checkout-form select[name="commune_id"] :selected').val());
                    fd.append('address', $('.checkout-form input[name="address"]').val());
                    fd.append('phone', $('.checkout-form input[name="phone"]').val());
                    fd.append('payment_method', 1);
                    loaderStart();
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": token,
                        },
                        url: $('.checkout-form').attr('action'),
                        type: "POST",
                        data: fd,
                        dataType: "JSON",
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // toastr.success(response.message, {
                            //     timeOut: 5000
                            // });
                            // loaderEnd();
                            return actions.order.capture().then(function(orderData) {
                                loaderEnd();
                                window.location.href = window.location.origin + '/order/order-completed';
                            })
                        },
                        error: function(xhr) {
                            if(xhr.status == 401){
                                    window.location.href = window.location.origin + '/login';
                            }else{
                                toastr.error(xhr.responseJSON.message, {
                                    timeOut: 5000
                                });
                            }
                            loaderEnd();
                            return false;
                            // loaderEnd();
                        }
                    });
                    // return false;
                    // return actions.order.capture().then(function(orderData) {
                    //     console.log('Capture result', orderData, JSON.stringify(orderData, null,
                    //         2));
                    //     const transaction = orderData.purchase_units[0].payments.captures[0];
                    //     // alert(
                    //     //     `Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`
                    //     // );
                    // });
                }
            }).render('#paypal-button-container');

        });
    </script>
@stop
