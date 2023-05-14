@extends('frontend.layouts.master')
@section('title', trans('language.order_detail'))

@section('css_page')
    <style>
        .product-image-table{
            object-fit: contain !important;
            max-width: 200px;
        }
        .list-product-label{
            font-size: 16px;
            font-weight: bold;
            color: #222;
        }
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
    @php
        $request = request();
    @endphp
    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        @include('frontend.layouts.breadcrumb', [
            'title' => trans('language.order_detail'),
            'breadcrumbItem' => trans('language.order_detail'),
        ])
        <!-- breadcrumb-area-end -->

        <!-- order-complete-area -->
        <section class="content pt-4 mb-4">
            <div class="container">
                <form enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12 theia-content">
                            <div class="card mb-1">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">{{ trans('language.customer_account_name') }}</label>
                                                <input type="text" class="form-control" disabled
                                                    value="{{ isset($order->customer_account_name) ? $order->customer_account_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">{{ trans('language.consignee_name') }}</label>
                                                <input type="text" class="form-control" disabled
                                                    value="{{ isset($order->full_name) ? $order->full_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">{{ trans('language.consignee_phone') }}</label>
                                                <input type="text" class="form-control" disabled
                                                    value="{{ isset($order->phone) ? $order->phone : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">{{ trans('language.payment_method') }}</label>
                                                <input type="text" class="form-control" disabled
                                                    value="{{ isset($order->payment_method) ? trans('language.order.payment_method')[$order->payment_method] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">{{ trans('language.status') }} <span
                                                        class="text-red"></span></label>
                                                <input type="text" class="form-control" disabled
                                                        value="{{ isset($order->status) ? trans('language.order.status')[$order->status] : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">{{ trans('language.delivery_address') }}</label>
                                                <textarea disabled style="width:100%">{{ isset($order->full_address) ? $order->full_address : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @include('backend.admin.order.partials.table-list-item', [
                                            'order' => $order,
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- order-complete-area-end -->

    </main>
    <!-- main-area-end -->
@stop

@section('js_library')
    {{-- @include('backend.libraryGroup.script-library', ['datepicker' => true, 'select2' => true]) --}}
@stop
