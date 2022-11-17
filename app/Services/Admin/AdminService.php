<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\App;
use App\Models\Language;
use App\Traits\StorageTrait;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
// use League\Flysystem\FileNotFoundException;
use App\Enums\GenderEnum;
use Exception;

class AdminService
{
    use StorageTrait;
    use ImageTrait;

    /**
     * Update admin profile
     * @param mixed $admin
     * @param mixed $parameters
     * @param mixed $avatar
     * @return void
     */
    public function updateAdminProfile($admin, $parameters, $avatar = null){
        $old_avatar_path = null;
        $avatar_path = $admin->avatar;
        if($avatar) {
            $old_avatar_path = $admin->avatar;
            $avatar = $this->resizeImage($avatar->getRealPath(), AVATAR_WIDTH);
            $avatar_path = $this->uploadFileByStream($avatar, ADMIN_DIR.'/'.$admin->id.'/'.Str::random(25).'.jpg');
        }

        $parameters += [
            'avatar' => $avatar_path
        ];

        $admin->update($parameters);

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

    public function getImage($id, $typeImage = 'avatar'){
        try {
            $admin = Admin::withTrashed()->find($id,[$typeImage.' as image','gender']);
            if (empty($admin)){
                return response()->file(base_path() . '/public/images/user-default.png');
            }

            if (empty($admin->image)){
                if ($admin->gender == GenderEnum::MALE){
                    $image = response()->file(base_path() . '/public/images/default-male.jpg');
                }else if ($admin->gender == GenderEnum::FEMALE){
                    $image = response()->file(base_path() . '/public/images/default-female.jpg');
                }else{
                    $image = response()->file(base_path() . '/public/images/user-default.png');
                }
            } else {
                $image = Storage::disk(FILESYSTEM)->response($admin->image);
            }
            return $image;
        } catch(Exception $e) {
            return null;
        }
    }
}

?>