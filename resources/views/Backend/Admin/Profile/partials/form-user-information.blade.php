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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">{{trans('language.avatar')}}</label>
                                <div class="text-center">
                                    <div class="form-image">
                                        <img src="{{asset('images/user-default.png')}}" class="form-image__view" id="avatar_view" alt="preview image">
                                        <input type="file"
                                                class="form-image__file"
                                                id="avatar"
                                                accept=".png, .jpg, .jpeg, .gif"
                                                data-origin="{{asset('images/user-default.png')}}"
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">{{trans('language.user_name')}} <span class="text-red">*</span></label>
                                <input type="text" class="form-control {{$errors->first('user_name') ? 'is-invalid' : ''}}" name="user_name" placeholder="{{trans('language.enter_user_name')}}" required
                                        value="{{old('user_name') ? old('user_name') : (isset($admin->user_name) ? $admin->user_name : '') }}">
                                @if ($errors->first('user_name'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('user_name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">{{trans('language.lang')}} <span class="text-red"></span></label>
                                    <select class="select2-base " name="language_id"  style="width: 100%">
                                        @php
                                            $choose_language = old('language') ? old('language') : (isset($admin->language_id)?$admin->language_id:'');
                                        @endphp
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}" {{ ($language->id==$choose_language )?'selected':'' }}>{{ $language->display_name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{trans('language.first_name')}} <span class="text-red">*</span></label>
                                <input type="text" class="form-control {{$errors->first('first_name') ? 'is-invalid' : ''}}" name="first_name" placeholder="{{trans('language.enter_first_name')}}" required
                                       value="{{old('first_name') ? old('first_name') : (isset($admin->first_name) ? $admin->first_name : '') }}" >
                                @if ($errors->first('first_name'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('first_name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{trans('language.last_name')}} <span class="text-red">*</span></label>
                                <input type="text" class="form-control {{$errors->first('last_name') ? 'is-invalid' : ''}}" name="last_name" placeholder="{{trans('language.enter_last_name')}}" required
                                       value="{{old('last_name') ? old('last_name') : (isset($admin->last_name) ? $admin->last_name : '') }}" >
                                @if ($errors->first('last_name'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('last_name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="">{{trans('language.birthday')}}</label>
                                <label class="input-group mb-0 ">
                                    <input type="text" class="form-control {{$errors->first('birthday') ? 'is-invalid' : ''}}" data-picker="date" autocomplete="off" name="birthday" placeholder="{{trans('language.enter_birthday')}}"
                                           value="{{old('birthday') ? old('birthday') : (isset($admin->birthday) ? (new App\Logics\DateFormatManager())->dateFormatLanguage($admin->birthday,'d/m/Y') : '') }}" >
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </label>
                                @if ($errors->first('birthday'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('birthday') }}</div>
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
                    <button type="submit" class="btn btn-primary mr-2 my-1" {{(isset($deleted) && $deleted==true) ? 'disabled'  :  ''}}><i class="far fa-save"></i> {{trans('language.save')}}</button>
                    <button type="reset" class="btn btn-outline-secondary" {{(isset($deleted) && $deleted==true) ? 'disabled'  :  ''}}><i class="far fa-undo"></i> {{trans('language.reset')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>