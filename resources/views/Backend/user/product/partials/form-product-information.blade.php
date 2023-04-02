@php
    $checkCreate = false;
    if(Route::is('user.product.create')){
        $checkCreate = true;
    }
@endphp

<form method="POST" enctype="multipart/form-data" action="{{ $action }}" id="form_product">
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
                          
                        </div>
                        <div class="col-sm-4">
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
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{ trans('language.stock') }} <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="{{ trans('language.stock') }}" name="stock" required autocomplete="off" value="{{ old('stock') ? old('stock') : (isset($product->stock) ? $product->stock : '')}}"
                                min="0" >
                                @if ($errors->first('stock'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('stock') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{ trans('language.price') }} <span class="text-red">*</span></label>
                                <label class="input-group mb-1 ">
                                    <input type="number" class="form-control" placeholder="{{ trans('language.price') }}" name="price" required autocomplete="off" value="{{ old('price') ? old('price') : (isset($product->price) ? $product->price : '')}}"
                                    min="0" step="0.01">
                                    @if ($errors->first('price'))
                                        <div class="invalid-alert text-danger">{{ $errors->first('price') }}</div>
                                    @endif
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-dollar-sign"></span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{ trans('language.discount') }}</label>
                                <label class="input-group mb-1 ">
                                    <input type="number" class="form-control" placeholder="{{ trans('language.discount') }}" name="discount" autocomplete="off" value="{{ old('discount') ? old('discount') : (isset($product->discount) ? $product->discount : '')}}"
                                    min="0" max="100" step="0.01">
                                    @if ($errors->first('discount'))
                                        <div class="invalid-alert text-danger">{{ $errors->first('discount') }}</div>
                                    @endif
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-percent"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{trans('language.choose_brand')}} <span class="text-red"></span></label>
                                <select class="select2-base select2-search__field {{$errors->first('brand_id') ? 'is-invalid' : ''}}"
                                    style="width: 100%"
                                    data-placeholder="{{trans('language.choose_brand')}}"
                                    name="brand_id"
                                    >
                                <option value=""></option>
                                @php
                                    $brands = App\Models\Brand::select('id', 'name')->get();
                                    $chooseBrand = old('brand_id') ? old('brand_id') : (isset($product->brand_id) ? $product->brand_id : '');
                                @endphp
                                @if(isset($brands))
                                    @foreach($brands as $key => $brand)
                                        <option value="{{ $brand->id }}" {{ $brand->id == $chooseBrand ? 'selected' : '' }} >
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                @endif
                                </select>
                                @if ($errors->first('brand_id'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('brand_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="radioStatus">{{trans('language.status')}}</label>
                                <br>
                                @php
                                    $status_s = trans('language.status_s');
                                    $choose_status = old('status') ? old('status') : ( isset($product->status) ? $product->status : 0);
                                @endphp
                                @for($i=0; $i<count($status_s); $i++)
                                    <div class="icheck-primary d-inline mr-4">
                                        <input type="radio" name="status" id="radioStatus{{ $i }}" value="{{ $i }}" {{ ($i == $choose_status) ? 'checked' : '' }} />
                                        <label for="radioStatus{{ $i }}">
                                            {{ $status_s[$i] }}
                                        </label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="col-sm-4 icheck-bee">
                            <div class="form-group">
                                <label></label>
                                <div class="icheck-success">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="{{App\Models\Product::IS_FEATURE}}" @if(isset($product->is_featured) &&$product->is_featured) checked @endif/>
                                    <label for="is_featured">{{trans('language.product_feature')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{trans('language.choose_category')}} <span class="text-red"></span></label>
                                <select class="select2-base select2-search__field {{$errors->first('category_id') ? 'is-invalid' : ''}}"
                                    style="width: 100%"
                                    data-placeholder="{{trans('language.choose_category')}}"
                                    name="category_id[]"
                                    multiple
                                    >
                                <option value=""></option>
                                @php
                                    $chooseCategory = old('category_id') ? old('category_id') : (isset($product->categories) ? $product->categories->pluck('category_id')->toArray(): []);
                                @endphp
                                @if(isset($categories))
                                    @foreach($categories as $key => $category)
                                        <option value="{{ $category["id"] }}" {{ in_array($category["id"], $chooseCategory) ? 'selected' : '' }}>
                                            {{ $category["name"] }}
                                        </option>
                                        @foreach($category["_2_level_cate"] as $subCategory)
                                            <option value="{{ $subCategory["id"] }}" {{ in_array($subCategory["id"], $chooseCategory ) ? 'selected' : '' }}>
                                                &ensp;{{ $subCategory["name"] }}
                                            </option>
                                        @endforeach
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
                                                {{-- (<span data-dz-size></span>) --}}
                                            </p>
                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                        </div>
                                        <div class="col-auto d-flex align-items-center">
                                            <div class="btn-group">
                                                <div data-dz-remove class="btn btn-danger delete_gallery">
                                                    <i class="fas fa-trash"></i>
                                                    <span>{{ trans('language.delete') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="gallery[]">
                                    </div>
                                    @if (isset($product->gallery))
                                        @foreach ($product->gallery as $item)
                                            {{-- <div class="row mt-2 file-row "> --}}
                                                <div class="row mt-2 file-row dz-image-preview">
                                                    <div class="col-auto">
                                                        <span class="preview"><img class="img_gallery" src="{{ asset('storage/'.$item['file_path']) }}"
                                                                alt="" data-dz-thumbnail /></span>
                                                    </div>
                                                    <div class="col d-flex align-items-center">
                                                        <p class="mb-0">
                                                            <span class="lead" data-dz-name>{{ $item['file_name'] }}</span>
                                                            {{-- <span data-dz-size></span> --}}
                                                        </p>
                                                        <strong class="error text-danger" data-dz-errormessage></strong>
                                                    </div>
                                                    <div class="col-auto d-flex align-items-center">
                                                        <div class="btn-group">
                                                            <div data-dz-remove class="btn btn-danger delete_gallery">
                                                                <i class="fas fa-trash"></i>
                                                                <span>{{ trans('language.delete') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="{{ json_encode($item) }}" name="gallery[]">
                                                </div>
                                            {{-- </div> --}}
                                        @endforeach
                                    @endif
                                </div>
                                @if ($errors->first('gallery'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('gallery') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <div class="col-xl-3 theia-sidebar">
            <div class="card">
                <div class="card-body align-items-start flex-wrap">
                    <button type="submit" class="btn btn-primary mr-2 my-1"><i class="far fa-save"></i> {{trans('language.save')}}</button>
                    <button type="reset" class="btn btn-outline-secondary"><i class="far fa-undo"></i> {{trans('language.reset')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>

@if(!$checkCreate)
<div class="row">
    <div class="col-xl-9 theia-content">
        @include('backend.user.product.partials.variation')
    </div>
</div>
@endif
