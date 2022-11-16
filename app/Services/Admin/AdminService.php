<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\App;
use App\Models\Language;

class AdminService
{

    public function updateAdminProfile($adminId, $parameters, $avatar = null){
        Admin::where('id', $adminId)->update($parameters);
        $language = Language::find($parameters['language_id']);
        if($language){
            $locale = $language->name;
            App::setLocale($locale);
            session()->put('locale', $locale);
        }
    }
}

?>