<form method="POST" enctype="multipart/form-data" action="{{ $action }}">
    @if(isset($method))
        @method($method)
    @endif
    @csrf
    <div class="row">
        <div class="col-xl-9 theia-content">
            <div class="card mb-1">
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
                                            data-origin="{{isset($category)?route('admin.user.avatar',['id'=>$category->id]) : asset('images/no-image.png')}}"
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
                                <input type="text" class="form-control" placeholder="{{ trans('language.enter_category_name') }}" name="category_name" required autocomplete="off">
                                @if ($errors->first('category_name'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('category_name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">{{trans('language.choose_parent_category')}} <span class="text-red"></span></label>
                                <select class="select2-base {{$errors->first('category_parent_id') ? 'is-invalid' : ''}}"
                                    style="width: 100%"
                                    data-placeholder="{{trans('language.is_parent_category')}}"
                                    name="category_parent_id"
                                    >
                                <option value="">{{trans('language.is_parent_category')}}</option>
                                @php
                                    $chooseCategory = old('category_parent_id') ? old('category_parent_id') : (isset($category->parent_id) ? $category->parent_id:'');
                                @endphp
                                @if(isset($parentCategory))
                                    @foreach($parentCategory as $key => $val)
                                        <option value="{{ $key }}" {{ $chooseCategory == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                @endif
                                </select>
                                @if ($errors->first('category_parent_id'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('category_parent_id') }}</div>
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