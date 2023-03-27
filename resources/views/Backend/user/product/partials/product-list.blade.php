@if (isset($products) && count($products) > 0)
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
        <thead class="text-center text-nowrap">
        <tr>
            <th width="5%">@sortablelink('id', trans('language.ordinal_number'))</th>
            <th width="8%">{{trans('language.sku')}}</th>
            <th width="11%">{{trans('language.image')}}</th>
            <th width="11%">@sortablelink('name', trans('language.product_name'))</th>
            <th width="6%">@sortablelink('product_type', trans('language.variant'))</th>
            <th width="18%">@sortablelink('hometown', trans('language.price'))</th>
            <th width="8%">@sortablelink('phone', trans('language.stock'))</th>
            <th width="5%">{{trans('language.operation')}}</th>
        </tr>
        </thead>
        <tbody>
            @foreach($products as $idx => $product)
                <tr>
                    <td class="text-center">{{ $idx }}</td>
                    <td class="text-center">{{ $product->sku }}</td>
                    <td class="text-center">
                        {{-- <a href="{{ isset($product->avatar) ? asset('storage/'. $product->) : asset('images/img-default.png')  }}" class="fancybox2" data-fancybox-group="avatar-list-user" title="ID: {{$user->id}} - {{ $user->full_name }}">
                            <img src="{{ isset($user->avatar) ? asset('storage/'. $user->avatar) : asset('images/img-default.png')  }}"
                                 alt="{{ $user->full_name }} Avatar"
                                 class="default-img">
                        </a> --}}
                    </td>
                    <td class="text-center">{{ $product->name }}</td>
                    <td class="text-center">{{ $product->product_type }}</td>
                    <td class="text-center">{{ $product->price }}</td>
                    <td class="text-center">{{ $product->stock }}</td>
                    <td class="text-center text-nowrap">
                        <a href="{{ route('user.product.edit',['slug'=> $product->slug]) }}" data-toggle='tooltip' title="{{trans('language.edit')}}" class="text-md text-primary mr-2"><i class="far fa-pen-alt"></i></a>
                        {{-- @if($product->deleted_at == null)
                            <a href="{{ route('admin.user.edit',['id'=>$user->id]) }}" data-toggle='tooltip' title="{{trans('language.edit')}}" class="text-md text-primary mr-2"><i class="far fa-pen-alt"></i></a>
                            <a href="{{ route('admin.user.destroy', ['id'=>$user->id]) }}"
                               data-toggle='tooltip'
                               title="{{trans('language.delete')}}"
                               class="text-md text-danger delete-row-table"
                               data-id="{{ $user->id }}"
                               data-title="{{trans('language.delete_user')}}"
                               data-text="<span class='text-bee'>ID: {{$user->id}}</span> - <strong>{{ $user->full_name }}</strong>"
                               data-url="{{ route('admin.user.destroy', ['id'=>$user->id]) }}"
                               data-method="DELETE"
                               data-icon="question"><i class="far fa-trash-alt"></i></a>
                        @else
                            <a href="{{ route('admin.user.restore', ['id'=>$user->id]) }}"
                                data-toggle='tooltip'
                                title="{{trans('language.restore')}}"
                                class="text-md text-warning delete-row-table"
                                data-id="{{ $user->id }}"
                                data-title="{{ trans('language.restore_user') }}"
                                data-text="<span class='text-bee'>ID: {{$user->id}}</span> - <strong>{{ $user->full_name }}</strong>"
                                data-method="POST"
                                data-url="{{ route('admin.user.restore', ['id'=>$user->id]) }}"
                                data-icon="question"><i class="far fa-redo"></i></a>
                        @endif --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pb-4">
    {{-- {{ $products->appends($request->query())->links('Partials.pagination') }} --}}
</div>
@else
    @include('Partials.no-data-found')
@endif
