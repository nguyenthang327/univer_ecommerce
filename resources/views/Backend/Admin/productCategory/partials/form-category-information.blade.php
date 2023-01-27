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
                                            id="avatar_view"
                                            alt="preview image"
                                        >
                                        <input type="file"
                                            class="form-image__file"
                                            id="avatar"
                                            accept=".png, .jpg, .jpeg, .gif"
                                            data-origin="{{isset($category)?route('admin.user.avatar',['id'=>$category->id]) : asset('images/no-image.png')}}"
                                            name="avatar"
                                            {{(isset($deleted) && $deleted==true) ? 'disabled'  :  ''}}>
                                        <label for="avatar" class="form-image__label"><i class="fas fa-pen"></i></label>
                                    </div>
                                    @if ($errors->first('avatar'))
                                        <div class="invalid-alert text-danger">{{ $errors->first('avatar') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>{{ trans('language.category_name') }} <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="{{ trans('language.enter_category_name') }}" name="category_name" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="">{{trans('language.choose_parent_category')}} <span class="text-red"></span></label>
                                <select class="select2-base dynamic-select-option {{$errors->first('category_id') ? 'is-invalid' : ''}}"
                                    style="width: 100%"
                                    data-placeholder="{{trans('language.is_parent_category')}}"
                                    name="category_id"
                                    >
                                <option value="" disabled selected style="display: none">{{trans('language.is_parent_category')}}</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $chooseCategory == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                                </select>
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