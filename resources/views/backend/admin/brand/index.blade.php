@extends('backend.admin.layout.master')
@section('title',trans('language.brand_list'))
@section('meta')
@stop

@section('css_library')
    @include('backend.libraryGroup.style-library', ['fancybox' => true ,'select2' => true])
@stop

@section('css_page')
    <link rel="stylesheet" href="{{ asset("common/css/profile.css") }}">
@stop


@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link title">{{ trans('language.brand_list') }}</a>
    </li>
@endsection
@section('content')
    @php
        $request = request();
    @endphp
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-end flex-wrap">
                <div class="mr-1 mb-2">
                    <a href="{{route('admin.brand.index',['refresh'=>'true'])}}" class="btn btn-default text-success d-none d-sm-inline-block"><i class="fal fa-sync"></i> {{trans('language.refresh')}}</a>
                    <a href="#collapseFilter" class="btn btn-default text-primary" data-toggle="collapse"><i class="far fa-filter"></i> {{trans('language.filter')}}</a>
                </div>
                <div class="actions mb-2">
                    <a href="#" data-url="{{ route('admin.brand.store') }}" data-img_default="{{ asset('images/no-image.png') }}" class="btn btn-primary ml-2" id="butonAddBrand" data-target="#modalBrand" data-toggle="modal">
                        <i class="fas fa-plus"></i><span class="d-none d-sm-inline"> {{ trans('language.add_new') }}</span>
                    </a>
                </div>
            </div>
            <div id="collapseFilter" class="collapse">
                <div class="card mb-3">
                    <div class="card-body border-0">
                        @include('backend.admin.brand.partials.form-filter')
                    </div>
                </div>
            </div>
            @if($is_filter)
                <div class="mb-2">
                    {{ trans('language.filter_mode') }}: {!! $is_filter !!}
                </div>
            @endif
            <div class="table-list-data">
                @include('backend.admin.brand.partials.brand-list')
            </div>
        </div>
    </section>
    @include('backend.admin.brand.partials.modal-brand', [
        'action' => route('admin.brand.store'),
        'method' => 'POST',
    ])
@stop

@section('js_library')
    @include('backend.libraryGroup.script-library', ['fancybox' => true, 'select2' => true])
@stop

@section('js_page')
    <script src="{{ asset('admin-assets/js/brand.js') }}"></script>
    @if($errors->any())
        <script>
            $('#modalBrand').modal('show');
        </script>
    @endif
@stop