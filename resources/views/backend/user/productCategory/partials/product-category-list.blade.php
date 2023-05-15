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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pb-4">
    {{ $data->appends($request->query())->links('partials.pagination') }}
</div>
@else
    @include('partials.no-data-found')
@endif
