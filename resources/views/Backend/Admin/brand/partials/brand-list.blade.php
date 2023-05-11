@if (isset($brands) && count($brands) > 0)
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
        <thead class="text-center text-nowrap">
        <tr>
            <th width="4%">{{ trans('language.id') }}</th>
            <th width="4%">{{ trans('language.logo') }}</th>
            <th width="10%">{{ trans('language.name') }}</th>
            <th width="5%">{{trans('language.operation')}}</th>
        </tr>
        </thead>
        <tbody>
            @foreach($brands as $idx => $brand)
                <tr>
                    <td class="text-center">{{$brand->id}}</td>
                    <td class="text-center">
                        <a href="{{ isset($brand->logo) ? asset('storage/'. $brand->logo) : asset('images/no-image.png')  }}" class="fancybox2" data-fancybox-group="logo-list-brand" title="ID: {{$brand->id}} - {{ $brand->name }}">
                            <img src="{{ isset($brand->logo) ? asset('storage/'. $brand->logo) : asset('images/no-image.png')  }}"
                                alt="{{ $brand->name }} Avatar"
                                class="default-img">
                        </a>
                    </td>
                    <td class="brand-name">{{ $brand->name }}</td>
                    <td class="text-center text-nowrap">
                            <a href="javascript:void(0)" data-toggle='tooltip' title="{{trans('language.edit')}}" class="text-md text-primary mr-2 edit-brand" data-url = "{{ route('admin.brand.update', ['id' => $brand->id]) }}"><i class="far fa-pen-alt"></i></a>
                            <a href="{{ route('admin.brand.destroy', ['id' => $brand->id]) }}"
                               data-toggle='tooltip'
                               title="{{trans('language.delete')}}"
                               class="text-md text-danger delete-row-table"
                               data-id="{{ $brand->id }}"
                               data-title="{{trans('language.delete_brand')}}"
                               data-text="<span class='text-bee'>ID: {{$brand->id}}</span> - <strong>{{ $brand->name }}</strong>"
                               data-url="{{ route('admin.brand.destroy', ['id'=>$brand->id]) }}"
                               data-method="DELETE"
                               data-icon="question"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pb-4">
    {{ $brands->appends($request->query())->links('partials.pagination') }}
</div>
@else
    @include('partials.no-data-found')
@endif
