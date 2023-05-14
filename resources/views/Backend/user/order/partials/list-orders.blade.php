@if (isset($orders) && count($orders) > 0)
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
        <thead class="text-center text-nowrap">
        <tr>
            <th width="5%">@sortablelink('id', trans('language.id'))</th>
            <th width="11%">{{ trans('language.full_name') }}</th>
            <th width="8%">{{trans('language.phone')}}</th>
            <th width="18%">{{trans('language.address')}}</th>
            <th width="6%">@sortablelink('payment_method', trans('language.payment_method'))</th>
            <th width="8%">@sortablelink('created_at', trans('language.created_at'))</th>
            <th width="5%">{{trans('language.coupon')}}</th>
            <th width="5%">{{trans('language.total')}}</th>
            <th width="8%">@sortablelink('status', trans('language.status'))</th>
            <th width="5%">{{trans('language.operation')}}</th>
        </tr>
        </thead>
        <tbody>
            @foreach($orders as $idx => $order)
                <tr>
                    <td class="text-center">{{$order->id}}</td>
                    <td>{{ $order->full_name }}</td>
                    <td class="text-center"><a href="tel:{{$order->phone}}" class="text-nowrap text-dark">{{(new \App\Helpers\StringHelper())->phoneNumberFormat($order->phone)}}</a></td>
                    <td title="{{$order->full_address}}">{{$order->full_address}}</td>
                    <td class="text-center">{{trans('language.order.payment_method')[$order->payment_method]}}</td>
                    <td class="text-center">{{ empty($order->created_at)? '': (new App\Services\DateFormatService())->dateFormatLanguage($order->created_at,'d/m/Y H:i:s')}}</td>
                    <td class="text-center">{{$order->discount_percentage ? $order->discount_percentage . '%' : '_'}}</td>
                    @php
                        $total = \App\Services\ProcessPriceService::regularPrice($order->total, $order->discount_percentage);
                    @endphp
                    <td class="text-center">{{$total['new']}}</td>
                    <td class="text-center">{{trans('language.order.status')[$order->status]}}</td>

                    <td class="text-center text-nowrap">
                        @if($order->deleted_at == null)
                            <a href="{{ route('user.order.edit',['id'=>$order->id]) }}" data-toggle='tooltip' title="{{trans('language.edit')}}" class="text-md text-primary mr-2"><i class="far fa-pen-alt"></i></a>
                        {{-- @else
                            <a href="{{ route('admin.order.restore', ['id'=>$order->id]) }}"
                                data-toggle='tooltip'
                                title="{{trans('language.restore')}}"
                                class="text-md text-warning delete-row-table"
                                data-id="{{ $order->id }}"
                                data-title="{{ trans('language.restore_order') }}"
                                data-text="<span class='text-bee'>ID: {{$order->id}}</span> - <strong>{{ $order->full_name }}</strong>"
                                data-method="POST"
                                data-url="{{ route('admin.order.restore', ['id'=>$order->id]) }}"
                                data-icon="question"><i class="far fa-redo"></i></a> --}}
                        @endif
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
