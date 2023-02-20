@extends('backend.admin.layout.master')
@section('title',trans('language.product_category_list'))
@section('meta')
@stop

@section('css_library')
    @include('backend.libraryGroup.style-library', ['datepicker' => true, 'fancybox' => true, 'select2' => true, 'icheck' => true])
@stop

@section('css_page')
@stop

@section('header')
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link active title">{{ trans('language.product_list') }}</a>
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
                    <a href="{{route('admin.product.index',['refresh'=>'true'])}}" class="btn btn-default text-success d-none d-sm-inline-block"><i class="fal fa-sync"></i> {{trans('language.refresh')}}</a>
                    <a href="#collapseFilter" class="btn btn-default text-primary" data-toggle="collapse"><i class="far fa-filter"></i> {{trans('language.filter')}}</a>
                </div>
                <div class="actions mb-2">
                    <a href="{{ route('admin.productCategory.create') }}" class="btn btn-primary ml-2" id="butonAddCategory">
                        <i class="fas fa-plus"></i><span class="d-none d-sm-inline"> {{ trans('language.add_new') }}</span>
                    </a>
                </div>
            </div>
            <div id="collapseFilter" class="collapse">
                <div class="card mb-3">
                    <div class="card-body border-0">
                        @include('backend.admin.product.partials.form-filter')
                    </div>
                </div>
            </div>
            @if($is_filter)
                <div class="mb-2">
                    {{ trans('language.filter_mode') }}: {!! $is_filter !!}
                </div>
            @endif
            <div class="table-list-data">
                @include('backend.admin.product.partials.product-list')
            </div>
        </div>
    </section>
@stop

@section('js_library')
    @include('backend.libraryGroup.script-library', ['datepicker' => true, 'fancybox' => true, 'select2' => true])
@stop

@section('js_page')
@stop