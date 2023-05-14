
@extends('frontend.layouts.master')
@section('title', trans('language.order_history'))

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
    @php
        $request = request();
    @endphp
    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        @include('frontend.layouts.breadcrumb', [
            'title' => trans('language.order_history'),
            'breadcrumbItem' => trans('language.order_history'),
        ])
        <!-- breadcrumb-area-end -->

        <!-- order-complete-area -->
        <section class="content pt-3">
            <div class="container">
                <div class="table-list-data">
                    @if (isset($orders) && count($orders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
                                <thead class="text-center text-nowrap">
                                <tr>
                                    <th width="5%">{{ trans('language.ordinal_number') }}</th>
                                    <th width="11%">{{ trans('language.full_name') }}</th>
                                    <th width="8%">{{trans('language.phone')}}</th>
                                    <th width="18%">{{trans('language.address')}}</th>
                                    <th width="6%">{{ trans('language.payment_method') }}</th>
                                    <th width="8%">{{ trans('language.created_at') }}</th>
                                    {{-- <th width="5%">{{trans('language.coupon')}}</th>
                                    <th width="5%">{{trans('language.total')}}</th> --}}
                                    <th width="8%">{{trans('language.status')}}</th>
                                    <th width="5%">{{trans('language.operation')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $idx => $order)
                                        <tr>
                                            <td class="text-center">{{$idx + $orders->firstItem()}}</td>
                                            <td>{{ $order->full_name }}</td>
                                            <td class="text-center"><a href="tel:{{$order->phone}}" class="text-nowrap text-dark">{{(new \App\Helpers\StringHelper())->phoneNumberFormat($order->phone)}}</a></td>
                                            <td title="{{$order->full_address}}">{{$order->full_address}}</td>
                                            <td class="text-center">{{trans('language.order.payment_method')[$order->payment_method]}}</td>
                                            {{-- <td class="text-center">{{ empty($order->created_at)? '': (new App\Services\DateFormatService())->dateFormatLanguage($order->created_at,'d/m/Y H:i:s')}}</td> --}}
                                            <td class="text-center">{{ empty($order->created_at)? '': Carbon\Carbon::parse($order->created_at)->format('H:i d/m/Y')}}</td>
                                            {{-- <td class="text-center">{{$order->discount_percentage ? $order->discount_percentage . '%' : '_'}}</td>
                                            @php
                                                $total = \App\Services\ProcessPriceService::regularPrice($order->total, $order->discount_percentage);
                                            @endphp
                                            <td class="text-center">{{$total['new']}}</td> --}}
                                            <td class="text-center">{{trans('language.order.status')[$order->status]}}</td>

                                            <td class="text-center">
                                                <a href="{{ route('customer.order.getDetail', ['id'=>$order->id]) }}" data-toggle='tooltip' title="{{trans('language.detail')}}" class="text-md mr-2" style="color:#222"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pb-4">
                            {{ $orders->appends($request->query())->links('partials.pagination') }}
                        </div>
                    @else
                        @include('partials.no-data-found')
                    @endif
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
    