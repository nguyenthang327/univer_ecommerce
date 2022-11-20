<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\App;
use App\Models\Language;
use App\Models\User;
use App\Traits\StorageTrait;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;

class UserService
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
    public function updateAdminProfile($user, $parameters, $avatar = null){
        $old_avatar_path = null;
        $avatar_path = $user->avatar;
        if($avatar) {
            $old_avatar_path = $user->avatar;
            $avatar = $this->resizeImage($avatar->getRealPath(), AVATAR_WIDTH);
            $avatar_path = $this->uploadFileByStream($avatar, USER_DIR.'/'.$user->id.'/'.Str::random(25).'.jpg');
        }

        $parameters += [
            'avatar' => $avatar_path
        ];

        $user->update($parameters);

        if($old_avatar_path) {
            // Remove old file
            $this->deleteFile($old_avatar_path);
        }

        $language = Language::find($parameters['language_id']);
        if($language){
            $locale = $language->name;
            App::setLocale($locale);
            session()->put('locale', $locale);
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
}

?>