@extends('Backend.Admin.Layout.master')
@section('title',trans('language.update_category'))

@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link active title">{{ trans('language.update_category') }}</a>
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
            @include('backend.admin.productCategory.partials.form-category-information',[
                    'category' => $category,
                    'action' => route('admin.productCategory.update' , ['id' => $category->id]),
                    'method' => 'PUT',
                ]
            )
        </div>
    </section>
    @include('backend.admin.productCategory.partials.modal-category',[
        'action' => route('admin.productCategory.update' , ['id' => $category->id]),
        'method' => 'PUT',
    ])
@stop

@section('js_library')
    @include('Backend.LibraryGroup.script-library', ['datepicker' => true, 'select2' => true])
@stop

@section('js_page')
    <script src="{{ asset("admin-assets/js/editCategory.js") }}"></script>
@stop
