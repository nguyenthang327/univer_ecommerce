@php
    $canShow = 'notShow';
    if(isset($category) && $category->parent_id == null && count($cateHasChild) > 0){
        $canShow = 'canShowSubModal';
    }
@endphp

<form method="POST" enctype="multipart/form-data" action="{{ $action }}" class="{{ $canShow }}" id="formCategory">
    @if(isset($method))
        @method($method)
    @endif
    @csrf
    <div class="row">
        <div class="col-xl-9 theia-content">
            <div class="card mb-1">
                <div class="card-header d-none d-xl-block">
                    <h3 class="card-title">
                        {{ trans('language.add_product') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{trans('language.thumbnail')}}</label>
                                <div class="text-center">
                                    <div class="form-image">
                                        <img
                                            src="{{ isset($category->thumbnail) ? asset('storage/'. $category->thumbnail) : asset('images/no-image.png')  }}"
                                            class="form-image__view form-thumbnail__view"
                                            id="thumbnail_view"
                                            alt="preview image"
                                        >
                                        <input type="file"
                                            class="form-image__file"
                                            id="thumbnail"
                                            accept=".png, .jpg, .jpeg, .gif"
                                            data-origin="{{isset($category->thumbnail)? asset('storage/'. $category->thumbnail) : asset('images/no-image.png')}}"
                                            name="thumbnail"
                                            {{(isset($deleted) && $deleted==true) ? 'disabled'  :  ''}}>
                                        <label for="thumbnail" class="form-image__label"><i class="fas fa-pen"></i></label>
                                    </div>
                                    @if ($errors->first('thumbnail'))
                                        <div class="invalid-alert text-danger">{{ $errors->first('thumbnail') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{ trans('language.category_name') }} <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="{{ trans('language.enter_category_name') }}" name="category_name" required autocomplete="off" value="{{ old('category_name') ? old('category_name') : (isset($category->name) ? $category->name : '')}}">
                                @if ($errors->first('category_name'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('category_name') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="theia-sidebar">
                <div class="card">
                    <div class="card-body align-items-start flex-wrap">
                        {{-- @if(!isset($cateHasChild)) --}}
                            <button type="submit" class="btn btn-primary mr-2 my-1"><i class="far fa-save"></i> {{trans('language.save')}}</button>
                        {{-- @else
                            <a class="btn btn-primary mr-2 my-1" data-toggle="modal" data-target="#modalCategory"><i class="far fa-save"></i> {{trans('language.save')}}</a>
                        @endif --}}
                        <button type="reset" class="btn btn-outline-secondary"><i class="far fa-undo"></i> {{trans('language.reset')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<label for="text">Enter Text:</label>
	<input type="text" id="text"><br><br>
	<label for="slug">Slug:</label>
	<input type="text" id="slug" readonly>
	
