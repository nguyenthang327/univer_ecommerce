<?php

namespace App\Logics\Admin;

use App\Events\RegisterUser;
use Illuminate\Support\Facades\App;
use App\Models\Language;
use App\Models\User;
use App\Traits\StorageTrait;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Helpers\StringHelper;
use App\Mail\Register;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserManager
{
    use StorageTrait;
    use ImageTrait;

    /**
     * Update user profile
     * @param mixed $user
     * @param mixed $parameters
     * @param mixed $avatar
     * @return void
     */
    public function updateUserProfile($user, $parameters, $avatar = null){
        $old_avatar_path = null;
        $avatar_path = $user->avatar;
        if($avatar) {
            $old_avatar_path = $user->avatar;
            $extention = $avatar->getClientOriginalExtension();
            $avatar = $this->resizeImage($avatar->getRealPath(), AVATAR_WIDTH);
            $avatar_path = $this->uploadFileByStream($avatar, USER_DIR.'/'.$user->id.'/'.Str::random(25).'.' . $extention);
        }

        $parameters += [
            'avatar' => $avatar_path
        ];

        User::where('id', $user->id)->update($parameters);

        if($old_avatar_path) {
            // Remove old file
            $this->deleteFile($old_avatar_path);
        }
    }

    /**
     * get image
     * @param mixed $id
     * @param string $typeImage
     * @return mixed
     */
    public function getImage($id, $typeImage = 'avatar'){
        try {
            $user = User::withTrashed()->find($id,[$typeImage.' as image','gender']);
            if (empty($user)){
                return response()->file(base_path() . '/public/images/user-default.png');
            }

            if (empty($user->image)){
                $image = response()->file(base_path() . '/public/images/user-default.png');
            } else {
                $image = Storage::disk(FILESYSTEM)->response($user->image);
            }
            return $image;
        } catch(Exception $e) {
            return null;
        }
    }

    /**
     * get all user
     * @param $request
     * @return $users
     */
    public function getUserList($request){
        $columns = [
            'users.*',
            'communes.name as commune_name',
            'districts.name as district_name',
            'prefectures.name as prefecture_name'
        ];

        $users = User::select(
                $columns,
            )
            ->leftjoin('communes', 'communes.id','users.commune_id')
            ->leftjoin('districts', 'districts.id','users.district_id')
            ->leftjoin('prefectures', 'prefectures.id','users.prefecture_id');

            $stringHelper = new StringHelper();
            if(isset($request->id)) {
                $users->where('users.id', $request->id);
            }
            if(isset($request->keyword)) {
                $keyword = $stringHelper->formatStringWhereLike($request->keyword);
                $users->where(DB::raw('CONCAT_WS(" ", users.first_name, users.last_name)'), 'LIKE', '%'.$keyword.'%');
            }
            if(isset($request->email)) {
                $email = $stringHelper->formatStringWhereLike($request->email);
                $users->where('email', 'LIKE', '%'.$email.'%');
            }
            if(isset($request->phone)) {
                $phone = $stringHelper->formatStringWhereLike($request->phone);
                $users->where('phone', 'LIKE', '%'.$phone.'%');
            }
            if(isset($request->gender)) {
                $users->whereIn('gender', $request->gender);
            }
            if(isset($request->birthday)) {
                $birthday = Carbon::createFromFormat('d/m/Y',$request->birthday)->format('Y-m-d');
                $users->where('birthday', $birthday);
            }
            if($request->has('deleted')) {
                $users = $users->onlyTrashed();
            }
    
            if ($request->sort === 'hometown') {
                $direction = in_array($request->direction, ['asc', 'desc']) ? $request->direction : 'asc';
                $users = $users->orderBy('prefectures.name', $request->direction)
                            ->orderBy('districts.name', $request->direction)
                            ->orderBy('communes.name', $request->direction);
            }
        return $users;
    }

    /**
     * create user profile
     * @param $parameters
     * @param $avatar
     */
    public function createUserProfile($parameters, $avatar = null, $password){
        // create user
        $user = User::create($parameters);

        $avatar_path = null;
        if($avatar) {
            $extention = $avatar->getClientOriginalExtension();
            $avatar = $this->resizeImage($avatar->getRealPath(), AVATAR_WIDTH);
            $avatar_path = $this->uploadFileByStream($avatar, USER_DIR.'/'.$user->id.'/'.Str::random(25).'.' . $extention);
        }

        $user->update([
            'avatar' => $avatar_path
        ]);

        $user->password = $password;
        event(new RegisterUser($user));
    }
}

?>