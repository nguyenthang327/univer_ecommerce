@if (isset($customers) && count($customers) > 0)
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered table-valign-middle table-custom min-width-800">
        <thead class="text-center text-nowrap">
        <tr>
            <th width="5%">@sortablelink('id', trans('language.id'))</th>
            <th width="8%">{{trans('language.avatar')}}</th>
            <th width="11%">@sortablelink('last_name', trans('language.full_name'))</th>
            <th width="11%">@sortablelink('email', trans('language.email'))</th>
            <th width="6%">@sortablelink('gender', trans('language.gender'))</th>
            <th width="18%">@sortablelink('hometown', trans('language.hometown'))</th>
            <th width="8%">@sortablelink('phone', trans('language.phone'))</th>
            <th width="8%">@sortablelink('birthday', trans('language.birthday'))</th>
            <th width="5%">{{trans('language.operation')}}</th>
        </tr>
        </thead>
        <tbody>
            @foreach($customers as $idx => $customer)
                <tr>
                    <td class="text-center">{{$customer->id}}</td>
                    <td class="text-center">
                        <a href="{{ isset($customer->avatar) ? asset('storage/'. $customer->avatar) : asset('images/user-default.png')  }}" class="fancybox2" data-fancybox-group="avatar-list-user" title="ID: {{$customer->id}} - {{ $customer->full_name }}">
                            <img src="{{ isset($customer->avatar) ? asset('storage/'. $customer->avatar) : asset('images/user-default.png')  }}"
                                 alt="{{ $customer->full_name }} Avatar"
                                 class="default-img">
                        </a>
                    </td>
                    <td>{{ $customer->full_name }}</td>
                    <td>
                        <a href="mailto:{{$customer->email}}" class="text-dark">{{$customer->email}}</a>
                    </td>
                    <td class="text-center">@if(isset(trans('language.genders')[$customer->gender])) {{trans('language.genders')[$customer->gender]}} @endif</td>
                    @php
                        $hometown = '';
                        if (isset($customer->commune->name)) {
                            $hometown .= $customer->commune->name.', ';
                        }
                        if (isset($customer->district->name)) {
                            $hometown .= $customer->district->name.', ';
                        }
                        if (isset($customer->prefecture->name)) {
                            $hometown .= $customer->prefecture->name;
                        }
                    @endphp
                    <td title="{{$hometown}}">{{$hometown}}</td>
                    <td class="text-center"><a href="tel:{{$customer->phone}}" class="text-nowrap text-dark">{{(new \App\Helpers\StringHelper())->phoneNumberFormat($customer->phone)}}</a></td>
                    <td class="text-center">{{ empty($customer->birthday)?'': (new App\Services\DateFormatService())->dateFormatLanguage($customer->birthday,'d/m/Y')}}</td>
                    <td class="text-center text-nowrap">
                        @if($customer->deleted_at == null)
                            <a href="{{ route('admin.customer.edit',['id'=>$customer->id]) }}" data-toggle='tooltip' title="{{trans('language.edit')}}" class="text-md text-primary mr-2"><i class="far fa-pen-alt"></i></a>
                            <a href="{{ route('admin.customer.destroy', ['id'=>$customer->id]) }}"
                               data-toggle='tooltip'
                               title="{{trans('language.delete')}}"
                               class="text-md text-danger delete-row-table"
                               data-id="{{ $customer->id }}"
                               data-title="{{trans('language.delete_customer')}}"
                               data-text="<span class='text-bee'>ID: {{$customer->id}}</span> - <strong>{{ $customer->full_name }}</strong>"
                               data-url="{{ route('admin.customer.destroy', ['id'=>$customer->id]) }}"
                               data-method="DELETE"
                               data-icon="question"><i class="far fa-trash-alt"></i></a>
                        @else
                            <a href="{{ route('admin.customer.restore', ['id'=>$customer->id]) }}"
                                data-toggle='tooltip'
                                title="{{trans('language.restore')}}"
                                class="text-md text-warning delete-row-table"
                                data-id="{{ $customer->id }}"
                                data-title="{{ trans('language.restore_customer') }}"
                                data-text="<span class='text-bee'>ID: {{$customer->id}}</span> - <strong>{{ $customer->full_name }}</strong>"
                                data-method="POST"
                                data-url="{{ route('admin.customer.restore', ['id'=>$customer->id]) }}"
                                data-icon="question"><i class="far fa-redo"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pb-4">
    {{ $customers->appends($request->query())->links('Partials.pagination') }}
</div>
@else
    @include('Partials.no-data-found')
@endif
