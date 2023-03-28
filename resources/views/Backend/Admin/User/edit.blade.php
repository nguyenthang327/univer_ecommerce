@extends('Backend.Admin.Layout.master')
@section('title',trans('language.update_user_info'))

@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link title">{{ trans('language.profile') }}</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link title">{{ trans('language.update_user_info') }}</a>
    </li>
@endsection


@section('css_library')
    @include('Backend.LibraryGroup.style-library', ['datepicker' => true, 'icheck' => true, 'select2' => true])
@stop

@section('css_page')
    <link rel="stylesheet" href="{{ asset("common/css/profile.css") }}">
@stop

@section('content')
    <section class="content pb-4 pt-3">
        <div class="container-fluid">
            @include('Backend.Admin.User.partials.form-user-information',[
                    'user' => $user,
                    'action' => route('admin.user.update' , ['id' => $user->id]),
                    'method' => 'PUT',
                ]
            )
        </div>
    </section>
@stop

@section('js_library')
    @include('Backend.LibraryGroup.script-library', ['datepicker' => true, 'select2' => true])
@stop
