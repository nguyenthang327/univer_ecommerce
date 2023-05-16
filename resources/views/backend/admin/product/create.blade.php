@extends('backend.admin.layout.master')
@section('title',trans('language.add_product'))

@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link title">{{ trans('language.product') }}</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link title">{{ trans('language.add_product') }}</a>
    </li>
@endsection


@section('css_library')
    @include('backend.libraryGroup.style-library', ['datepicker' => true, 'icheck' => true, 'select2' => true, 'summernote' => true, 'dropzone' => true])
@stop

@section('css_page')
    <link rel="stylesheet" href="{{ asset("common/css/profile.css") }}">
@stop

@section('content')
    <section class="content pb-4 pt-3">
        <div class="container-fluid">
            @include('backend.user.product.partials.form-product-information',[
                    'action' => route('user.product.store'),
                    'method' => 'POST',
                ]
            )
        </div>
    </section>
@stop

@section('js_library')
    @include('backend.libraryGroup.script-library', ['datepicker' => true, 'select2' => true, 'summernote' => true, 'dropzone' => true])
@stop

@section('js_page')
    <script src="{{ asset("user-assets/js/product.js") }}"></script>
@stop
