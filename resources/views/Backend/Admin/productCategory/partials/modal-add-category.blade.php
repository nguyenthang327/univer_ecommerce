<div class="modal-add-category modal fade" id="modalAddCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('language.add_product_category') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-message d-none" role="alert"></div>
                <div class="form-group">
                </div>
                <div class="position-select text-danger"></div>
                <div class="form-group">
                    <label>{{ trans('language.select_member') }} <span class="text-red">*</span></label>
                    <div class="position-relative">
                    </div>
                </div>
                <div class="member-select text-danger"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="select-member"><i class="far fa-plus"></i> {{ trans('language.add_new') }}</button>
                <button type="button" class="btn btn-light"  data-dismiss="modal">{{ trans('language.cancel') }}</button>
            </div>
        </div>
    </div>
</div>