<div class="modal-add-category modal fade" id="modalAddCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" action="{{ route('admin.productCategory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('language.add_product_category') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('language.category_name') }} <span class="text-red">*</span></label>
                        <input type="text" class="form-control" placeholder="{{ trans('language.enter_category_name') }}" name="category_name" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        @php
                            $chooseCategory = old('category_id')?old('category_id'):(isset($categories->id)?$categories->id:'');
                        @endphp
                        <label>{{ trans('language.choose_parent_category') }}</label>
                        <div class="position-relative">
                            <select class="select2-base dynamic-select-option {{$errors->first('category_id') ? 'is-invalid' : ''}}"
                                style="width: 100%"
                                data-child="#select_category"
                                data-url="{{ route('getDistrictList') }}"
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
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="select-member">{{ trans('language.add_new') }}</button>
                    <button type="button" class="btn btn-light"  data-dismiss="modal">{{ trans('language.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>