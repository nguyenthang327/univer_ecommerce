<div class="modal-category modal fade" id="modalCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="" action="{{ $action }}" method="POST" enctype="multipart/form-data" id="subFormCate">
                @if(isset($method))
                    @method($method)
                @endif
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('language.convert_child_cate_1')}}</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{trans('language.choose_parent_category')}} <span class="text-red"></span></label>
                        <select class="select2-base"
                            style="width: 100%"
                            data-placeholder="{{trans('language.is_parent_category')}}"
                            name="category_parent_id_new"
                            >
                        <option value="">{{trans('language.is_parent_category')}}</option>
                        @if(isset($parentCategory))
                            @foreach($parentCategory as $key => $val)
                                <option value="{{ $key }}">
                                    {{ $val }}
                                </option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="select-member">{{ trans('language.agree') }}</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ trans('language.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>