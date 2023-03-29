@if (isset($data) && count($data) > 0)
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
        <thead class="text-center text-nowrap">
        <tr>
            <th width="4%">{{ trans('language.id') }}</th>
            <th width="4%">{{ trans('language.thumbnail') }}</th>
            <th width="10%">{{ trans('language.category_name') }}</th>
            <th width="4%">{{ trans('language.id_parent_category') }}</th>
            <th width="6%">{{ trans('language.slug') }}</th>
            <th width="6%">{{ trans('language.created_by') }}</th>
            <th width="6%">{{ trans('language.updated_by') }}</th>
            <th width="5%">{{trans('language.operation')}}</th>
        </tr>
        </thead>
        <tbody>
            @foreach($data as $idx => $category)
                <tr class="{{ $category->parent_id ? 'bg-light' : 'bg-white' }}">
                    <td class="text-center {{ $category->parent_id ? 'pl-5' : '' }}">{!! $category->parent_id ? '' : "<i class='fas fa-angle-down mr-1'></i>" !!}{{$category->id}}</td>
                    <td class="text-center">
                        <a href="{{ isset($category->thumbnail) ? asset('storage/'. $category->thumbnail) : asset('images/no-image.png')  }}" class="fancybox2" data-fancybox-group="thumbnail-list-category" title="ID: {{$category->id}} - {{ $category->name }}">
                            <img src="{{ isset($category->thumbnail) ? asset('storage/'. $category->thumbnail) : asset('images/no-image.png')  }}"
                                alt="{{ $category->name }} Avatar"
                                class="default-img">
                        </a>
                    </td>
                    <td>{{ $category->name }}</td>
                    <td class="text-center">{{ $category->parent_id }}</td>
                    <td class="text-center">{{ $category->slug }}</td>
                    <td class="text-center">{{ $category->created_name }}</td>
                    <td class="text-center">{{ $category->updated_name }}</td>
                    <td class="text-center text-nowrap">
                        @if($category->deleted_at == null)
                            <a href="{{ route('admin.productCategory.edit', ['category' => $category->slug]) }}" data-toggle='tooltip' title="{{trans('language.edit')}}" class="text-md text-primary mr-2"><i class="far fa-pen-alt"></i></a>
                            <a href="{{ route('admin.user.destroy', ['id'=>$category->id]) }}"
                               data-toggle='tooltip'
                               title="{{trans('language.delete')}}"
                               class="text-md text-danger delete-row-table"
                               data-id="{{ $category->id }}"
                               data-title="{{trans('language.delete_user')}}"
                               data-text="<span class='text-bee'>ID: {{$category->id}}</span> - <strong>{{ $category->name }}</strong>"
                               data-url="{{ route('admin.user.destroy', ['id'=>$category->id]) }}"
                               data-method="DELETE"
                               data-icon="question"><i class="far fa-trash-alt"></i></a>
                        @else
                            <a href="{{ route('admin.user.restore', ['id'=>$category->id]) }}"
                                data-toggle='tooltip'
                                title="{{trans('language.restore')}}"
                                class="text-md text-warning delete-row-table"
                                data-id="{{ $category->id }}"
                                data-title="{{ trans('language.restore_user') }}"
                                data-text="<span class='text-bee'>ID: {{$category->id}}</span> - <strong>{{ $category->name }}</strong>"
                                data-method="POST"
                                data-url="{{ route('admin.user.restore', ['id'=>$category->id]) }}"
                                data-icon="question"><i class="far fa-redo"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pb-4">
    {{ $data->appends($request->query())->links('Partials.pagination') }}
</div>
@else
    @include('Partials.no-data-found')
@endif
