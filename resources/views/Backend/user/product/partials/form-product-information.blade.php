@php
    $checkCreate = false;
    if(Route::is('user.product.create')){
        $checkCreate = true;
    }
@endphp

<form method="POST" enctype="multipart/form-data" action="{{ $action }}" id="">
    @if(isset($method))
        @method($method)
    @endif
    @csrf
    <div class="row">
        <div class="col-xl-9 theia-content">
            <div class="card mb-1">
                <div class="card-header d-none d-xl-block">
                    <h3 class="card-title">
                        {{ $checkCreate ? trans('language.add_product') : trans('language.edit_product') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{ trans('language.product_name') }} <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="{{ trans('language.enter_product_name') }}" name="product_name" id="product_name" required autocomplete="off" value="{{ old('product_name') ? old('product_name') : (isset($product->name) ? $product->name : '')}}">
                                @if ($errors->first('product_name'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('product_name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>{{ trans('language.slug') }} <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="{{ trans('language.slug') }}" name="slug" id="slug" required autocomplete="off" value="{{ old('slug') ? old('slug') : (isset($product->slug) ? $product->slug : '')}}">
                                @if ($errors->first('slug'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('slug') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{ trans('language.sku') }} <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="{{ trans('language.sku') }}" name="sku" required autocomplete="off" value="{{ old('sku') ? old('sku') : (isset($product->sku) ? $product->sku : '')}}">
                                @if ($errors->first('sku'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('sku') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>{{ trans('language.price') }} <span class="text-red">*</span></label>
                                <input type="number" class="form-control" placeholder="{{ trans('language.price') }}" name="price" required autocomplete="off" value="{{ old('price') ? old('price') : (isset($product->price) ? $product->price : '')}}">
                                @if ($errors->first('price'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('price') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{trans('language.choose_category')}} <span class="text-red"></span></label>
                                <select class="select2-base {{$errors->first('category_id') ? 'is-invalid' : ''}}"
                                    style="width: 100%"
                                    data-placeholder="{{trans('language.choose_category')}}"
                                    name="category_id"
                                    {{-- required --}}
                                    >
                                <option value=""></option>
                                @php
                                    $chooseCategory = old('category_id') ? old('category_id') : (isset($category->id) ? $category->id:'');
                                @endphp
                                @if(isset($categories))
                                    @foreach($categories as $key => $val)
                                        <option value="{{ $key }}" {{ $chooseCategory == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                @endif
                                </select>
                                @if ($errors->first('category_id'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('category_id') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">{{ trans('language.description') }}</label>
                                <textarea class="form-control summernote {{$errors->first('description') ? 'is-invalid' : ''}}" rows="5" placeholder="{{ trans('language.description') }}" name="description">{!! old('description')?old('description'):(isset($product) ? App\Helpers\StringHelper::escapeHtml($product->description) : '') !!}</textarea>
                                @if ($errors->first('description'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header d-none d-xl-block">
                    <h3 class="card-title">
                        {{ trans('language.gallery') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div id="actions" class="row">
                                    <div class="col-lg-4 fileinput-button">
                                        <div class="btn-group">
                                            <span id="upfile" class="btn btn-success col">
                                                <i class="fas fa-plus"></i>
                                                <span>{{ trans('language.upload_img') }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="table table-striped files" id="previews">
                                    <div id="template" class="row mt-2 file-row">
                                        <div class="col-auto">
                                            <span class="preview"><img src="data:," alt=""
                                                    data-dz-thumbnail /></span>
                                        </div>
                                        <div class="col d-flex align-items-center">
                                            <p class="mb-0">
                                                <span class="lead" data-dz-name></span>
                                                (<span data-dz-size></span>)
                                            </p>
                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                        </div>
                                        <div class="col-auto d-flex align-items-center">
                                            <div class="btn-group">
                                                <div data-dz-remove class="btn btn-danger delete">
                                                    <i class="fas fa-trash"></i>
                                                    <span>{{ trans('language.delete') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="gallery[]">
                                    </div>
                                </div>
                                @if ($errors->first('gallery'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('gallery') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(!$checkCreate)
                @include('backend.user.product.partials.form-variation')
            @endif
        </div>
        <div class="col-xl-3 theia-sidebar">
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
</form>
