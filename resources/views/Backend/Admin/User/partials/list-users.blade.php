@if (isset($users) && count($users) > 0)
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
            @foreach($users as $idx => $user)
                <tr>
                    <td class="text-center">{{$user->id}}</td>
                    @php
                        $full_name = $user->first_name.' '.$user->last_name;
                    @endphp
                    <td class="text-center">
                        <a href="{{ isset($user->avatar) ? asset('storage/'. $user->avatar) : asset('images/user-default.png')  }}" class="fancybox2" data-fancybox-group="avatar-list-user" title="ID: {{$user->id}} - {{ $full_name }}">
                            <img src="{{ isset($user->avatar) ? asset('storage/'. $user->avatar) : asset('images/user-default.png')  }}"
                                 alt="{{ $full_name }} Avatar"
                                 class="default-img">
                        </a>
                    </td>
                    <td>{{ $full_name }}</td>
                    <td>
                        <a href="mailto:{{$user->email}}" class="text-dark">{{$user->email}}</a>
                    </td>
                    <td class="text-center">@if(isset(trans('language.genders')[$user->gender])) {{trans('language.genders')[$user->gender]}} @endif</td>
                    @php
                        $hometown = '';
                        if (isset($user->commune->name)) {
                            $hometown .= $user->commune->name.', ';
                        }
                        if (isset($user->district->name)) {
                            $hometown .= $user->district->name.', ';
                        }
                        if (isset($user->prefecture->name)) {
                            $hometown .= $user->prefecture->name;
                        }
                    @endphp
                    <td title="{{$hometown}}">{{$hometown}}</td>
                    <td class="text-center"><a href="tel:{{$user->phone}}" class="text-nowrap text-dark">{{(new \App\Helpers\StringHelper())->phoneNumberFormat($user->phone)}}</a></td>
                    <td class="text-center">{{ empty($user->birthday)?'': (new App\Services\DateFormatService())->dateFormatLanguage($user->birthday,'d/m/Y')}}</td>
                    <td class="text-center text-nowrap">
                        @if($user->deleted_at == null)
                            <a href="{{ route('admin.user.edit',['id'=>$user->id]) }}" data-toggle='tooltip' title="{{trans('language.edit')}}" class="text-md text-primary mr-2"><i class="far fa-pen-alt"></i></a>
                            <a href="{{ route('admin.user.destroy', ['id'=>$user->id]) }}"
                               data-toggle='tooltip'
                               title="{{trans('language.delete')}}"
                               class="text-md text-danger delete-row-table"
                               data-id="{{ $user->id }}"
                               data-title="{{trans('language.delete_user')}}"
                               data-text="<span class='text-bee'>ID: {{$user->id}}</span> - <strong>{{ $full_name }}</strong>"
                               data-url="{{ route('admin.user.destroy', ['id'=>$user->id]) }}"
                               data-method="DELETE"
                               data-icon="question"><i class="far fa-trash-alt"></i></a>
                        @else
                            <a href="{{ route('admin.user.restore', ['id'=>$user->id]) }}"
                                data-toggle='tooltip'
                                title="{{trans('language.restore')}}"
                                class="text-md text-warning delete-row-table"
                                data-id="{{ $user->id }}"
                                data-title="{{ trans('language.restore_employee') }}"
                                data-text="<span class='text-bee'>ID: {{$user->id}}</span> - <strong>{{ $full_name }}</strong>"
                                data-method="POST"
                                data-url="{{ route('admin.user.restore', ['id'=>$user->id]) }}"
                                data-icon="question"><i class="far fa-redo"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pb-4">
    {{ $users->appends($request->query())->links('Partials.pagination') }}
</div>
@else
    @include('Partials.no-data-found')
@endif
