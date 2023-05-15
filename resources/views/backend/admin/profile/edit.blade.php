@extends('backend.admin.layout.master')
@section('title',trans('language.profile_info'))

@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link active title">{{ trans('language.user_profile') }}</a>
    </li>
@endsection


@section('css_library')
    @include('backend.libraryGroup.style-library', ['datepicker' => true, 'icheck' => true, 'select2' => true])
@stop

@section('css_page')
    <link rel="stylesheet" href="{{ asset("common/css/profile.css") }}">
@stop

@section('content')
    <section class="content pb-4 pt-3">
        <div class="container-fluid">
            @include('backend.admin.profile.partials.form-user-information',[
                    'admin' => $admin,
                    'action' => route('admin.profile.update' , ['id' => $admin->id]),
                    'method' => 'PUT',
                ]
            )
        </div>
    </section>
@stop

@section('js_library')
    @include('backend.libraryGroup.script-library', ['datepicker' => true, 'select2' => true])
@stop
