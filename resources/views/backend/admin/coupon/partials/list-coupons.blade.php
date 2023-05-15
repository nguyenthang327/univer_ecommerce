@if (isset($coupons) && count($coupons) > 0)
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
        <thead class="text-center text-nowrap">
        <tr>
            <th width="5%">{{trans('language.ordinal_number')}}</th>
            <th width="11%">@sortablelink('code', trans('language.code'))</th>
            <th width="11%">@sortablelink('discount_percentage', trans('language.discount'))</th>
            <th width="6%">@sortablelink('quantity', trans('language.quantity'))</th>
            <th width="8%">@sortablelink('started_at', trans('language.started_at'))</th>
            <th width="8%">@sortablelink('ended_at', trans('language.ended_at'))</th>
            <th width="5%">{{trans('language.operation')}}</th>
        </tr>
        </thead>
        <tbody>
            @foreach($coupons as $idx => $coupon)
                <tr>
                    <td class="text-center">{{$idx + $coupons->firstItem()}}</td>
                    <td class="text-center">{{ $coupon->code }}</td>
                    <td class="text-center">{{ $coupon->discount_percentage }} %</td>
                    <td class="text-center">{{ $coupon->quantity }}</td>
                    <td class="text-center">{{ empty($coupon->started_at)?'': (new App\Services\DateFormatService())->dateFormatLanguage($coupon->started_at,'d/m/Y')}}</td>
                    <td class="text-center">{{ empty($coupon->ended_at)?'': (new App\Services\DateFormatService())->dateFormatLanguage($coupon->ended_at,'d/m/Y')}}</td>
                    <td class="text-center text-nowrap">
                        @if($coupon->deleted_at == null)
                            <a href="{{ route('admin.coupon.edit',['id'=>$coupon->id]) }}" data-toggle='tooltip' title="{{trans('language.edit')}}" class="text-md text-primary mr-2"><i class="far fa-pen-alt"></i></a>
                            <a href="{{ route('admin.coupon.destroy', ['id'=>$coupon->id]) }}"
                               data-toggle='tooltip'
                               title="{{trans('language.delete')}}"
                               class="text-md text-danger delete-row-table"
                               data-id="{{ $coupon->id }}"
                               data-title="{{trans('language.delete_coupon')}}"
                               data-text="<span class='text-bee'>ID: {{$coupon->id}}</span> - <strong>{{ $coupon->code }}</strong>"
                               data-url="{{ route('admin.coupon.destroy', ['id'=>$coupon->id]) }}"
                               data-method="DELETE"
                               data-icon="question"><i class="far fa-trash-alt"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pb-4">
    {{ $coupons->appends($request->query())->links('partials.pagination') }}
</div>
@else
    @include('partials.no-data-found')
@endif
