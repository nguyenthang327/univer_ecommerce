<div class="modal-change-password modal fade" id="modalChangePassword" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route('password.update')}}" method="post" class="form-change-password" id="change-password-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('language.change_password') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <div class="alert alert-message d-none" role="alert"></div> --}}
                    <input type="hidden" name="type" value="{{$typeAccount}}" />
                    <div class="form-group">
                        <label>{{ trans('language.old_password') }}</label>
                        <input type="password" class="form-control" name="old_password" required placeholder="{{ trans('language.input_old_password') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('language.new_password') }}</label>
                        <input type="password" minlength="6" id="password" name="new_password" class="form-control" required placeholder="{{ trans('language.input_new_password') }}">
                        @if ($errors->first('new_password'))
                            <div class="invalid-alert text-danger">{{ $errors->first('new_password') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('language.confirm_password') }}</label>
                        <input type="password" minlength="6" id="confirm_password" name="confirm_password" class="form-control" required placeholder="{{ trans('language.input_confirm_password') }}">
                        @if ($errors->first('confirm_password'))
                            <div class="invalid-alert text-danger">{{ $errors->first('confirm_password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> {{ trans('language.change') }}</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ trans('language.return') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>