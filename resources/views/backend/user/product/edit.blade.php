@extends('backend.user.layout.master')
@section('title',trans('language.profile_info'))

@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link title">{{ trans('language.product') }}</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link title">{{ trans('language.edit_product') }}</a>
    </li>
@endsection

@section('css_library')
    @include('backend.libraryGroup.style-library', ['datepicker' => true, 'icheck' => true, 'select2' => true, 'summernote' => true, 'dropzone' => true])
@stop

@section('css_page')
    <link rel="stylesheet" href="{{ asset("admin-assets/css/product.css") }}">
@stop

@section('content')
    <section class="content pb-4 pt-3">
        <div class="container-fluid">
            @include('backend.user.product.partials.form-product-information',[
                    'action' => route('user.product.update', ['id' => $product->id]),
                    'method' => 'PUT',
                ]
            )
        </div>
    </section>
@stop

@section('js_library')
    @include('backend.libraryGroup.script-library', ['datepicker' => true, 'select2' => true, 'summernote' => true, 'dropzone' => true])
@stop

@section('js_page')
    @include('backend.user.product.script')
    <script src="{{ asset("user-assets/js/product.js") }}"></script>
@stop
