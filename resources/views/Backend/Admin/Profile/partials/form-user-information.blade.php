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
                                <label for="">{{trans('language.avatar')}}</label>
                                <div class="text-center">
                                    <div class="form-image">
                                        <img src="{{ route('admin.avatar', ['id' => isset($admin) ? $admin->id : -1]) }}" class="form-image__view" id="avatar_view" alt="preview image">
                                        <input type="file"
                                                class="form-image__file"
                                                id="avatar"
                                                accept=".png, .jpg, .jpeg, .gif"
                                                data-origin="{{isset($admin)?route('admin.avatar',['id'=>$admin->id]):asset('images/user-default.png')}}"
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
                                           value="{{old('birthday') ? old('birthday') : (isset($admin->birthday) ? (new App\Services\DateFormatService())->dateFormatLanguage($admin->birthday,'d/m/Y') : '') }}"
                                            >
                                           
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
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="">{{trans('language.email')}} <span class="text-red">*</span></label>
                                <label class="input-group mb-0">
                                    <input type="email" class="form-control {{$errors->first('email') ? 'is-invalid' : ''}}" name="email" placeholder="{{trans('language.enter_email')}}" required
                                           value="{{old('email') ? old('email') : (isset($admin->email) ? $admin->email : '') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="far fa-envelope"></span>
                                        </div>
                                    </div>
                                </label>
                                @if ($errors->first('email'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="">{{trans('language.phone')}}</label>
                                <label class="input-group mb-0">
                                    <input type="text" class="form-control {{$errors->first('phone') ? 'is-invalid' : ''}}" name="phone" placeholder="{{trans('language.enter_phone')}}"
                                           value="{{old('phone') ? old('phone') : (isset($admin->phone) ? $admin->phone : '') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="far fa-phone"></span>
                                        </div>
                                    </div>
                                </label>
                                @if ($errors->first('phone'))
                                    <div class="invalid-alert text-danger">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="radioGender1">{{trans('language.gender')}}</label>
                                <br>
                                @php
                                    $genders = trans('language.genders');
                                    $choose_gender = old('gender') ? old('gender') : (isset($admin->gender)?$admin->gender:0);
                                @endphp
                                @for($i=0;$i<count($genders);$i++)
                                    <div class="icheck-primary d-inline mr-4">
                                        <input type="radio" name="gender" id="radioGender{{ $i }}" value="{{ $i }}" {{ ($i===$choose_gender)?'checked':'' }}>
                                        <label for="radioGender{{ $i }}">
                                            {{ $genders[$i] }}
                                        </label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="">{{trans('language.hometown')}}</label>
                            <div class="row">
                                @php
                                    $prefectures = \App\Models\Prefecture::orderBy('name')->get();
                                    $choose_prefecture = old('prefecture_id')?old('prefecture_id'):(isset($admin->prefecture_id)?$admin->prefecture_id:'');
                                    $districts = \App\Models\District::where('prefecture_id', $choose_prefecture)->orderBy('name')->get();
                                    $choose_district = old('district_id')?old('district_id'):(isset($admin->district_id)?$admin->district_id:'');
                                    $communes = \App\Models\Commune::where('district_id', $choose_district)->orderBy('name')->get();
                                    $choose_commune = old('commune_id')?old('commune_id'):(isset($admin->commune_id)?$admin->commune_id:'');
                                @endphp
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select class="select2-base dynamic-select-option {{$errors->first('prefecture_id') ? 'is-invalid' : ''}}"
                                                style="width: 100%"
                                                data-child="#select_district"
                                                data-url="{{ route('getDistrictList') }}"
                                                data-placeholder="{{trans('language.choose_a_prefecture')}}"
                                                name="prefecture_id"
                                                >
                                            <option value="" disabled selected style="display: none">{{trans('language.choose_prefecture')}}</option>
                                            @if(isset($prefectures))
                                                @foreach($prefectures as $prefecture)
                                                    <option value="{{$prefecture->id}}" {{ $choose_prefecture == $prefecture->id?'selected':'' }}>
                                                        {{$prefecture->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->first('prefecture_id'))
                                            <div class="invalid-alert text-danger">{{ $errors->first('prefecture_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select class="select2-base dynamic-select-option {{$errors->first('district_id') ? 'is-invalid' : ''}}"
                                                style="width: 100%"
                                                name="district_id"
                                                data-child="#select_ward"
                                                data-url="{{ route('getCommuneList') }}"
                                                id="select_district"
                                                data-placeholder="{{trans('language.choose_a_district')}}"
                                                >
                                            <option value="" disabled selected>{{trans('language.choose_district')}}</option>
                                            @if($districts)
                                                @foreach($districts as $district)
                                                    <option value="{{$district->id}}" {{$choose_district == $district->id?'selected':''}}>
                                                        {{$district->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->first('district_id'))
                                            <div class="invalid-alert text-danger">{{ $errors->first('district_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select class="select2-base {{$errors->first('commune_id') ? 'is-invalid' : ''}}"
                                                id="select_ward"
                                                data-placeholder="{{trans('language.choose_a_commune')}}"
                                                name="commune_id"
                                                style="width: 100%" >
                                            <option value="" disabled selected>{{trans('language.choose_commune')}}</option>
                                            @if($communes)
                                                @foreach($communes as $commune)
                                                    <option value="{{$commune->id}}" {{$choose_commune == $commune->id?'selected':''}}>
                                                        {{$commune->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->first('commune_id'))
                                            <div class="invalid-alert text-danger">{{ $errors->first('commune_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="">{{trans('language.identity_card')}}</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control {{$errors->first('identity_card') ? 'is-invalid' : ''}}" name="identity_card" placeholder="{{trans('language.enter_identity_card')}}"
                                               value="{{old('identity_card') ? old('identity_card') : (isset($admin->identity_card) ? $admin->identity_card : '') }}">
                                        @if ($errors->first('identity_card'))
                                            <div class="error">{{ $errors->first('identity_card') }}</div>
                                        @endif
                                    </div>
                                </div>
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