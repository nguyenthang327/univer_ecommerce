<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Logics\Admin\UserManager;
use App\Models\Language;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @param \App\Logics\Admin\UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }
    
    /**
     * @var string
     */
    protected $pathView = 'backend.user.profile.';

    /**
     * display infor user
     * 
     * @return View
     */
    public function userProfile(){
        $user = Auth::guard('user')->user();
        $languages = Language::select('id','name','display_name')->get();

        return view($this->pathView . 'edit', compact('user', 'languages'));
    }

    /**
     * update user infor
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request){
        $user = Auth::guard('user')->user();

        DB::beginTransaction();
        try{
            $params = [
                'language_id' => $request->language_id,
                'birthday' => isset($request->birthday) ? Carbon::createFromFormat('d/m/Y', $request->birthday) : $request->birthday,
                'phone' => $request->phone,
                'prefecture_id' => $request->prefecture_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
            ];
            $this->userManager->updateUserProfile($user, $params, null);

            if(isset($request->language_id) && ($user->language_id != $request->language_id)){
                $language = Language::where('id', $request->language_id)->first();
                App::setLocale($language->name);
                session()->put('locale', $language->name);
            }
            DB::commit();
            return back()->with([
                'status_successed' => trans('message.update_user_successed')
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.update_user_failed'),
            ]);
        }
    }

    /**
     * Get avatar admin
     * @param $id
     * @return mixed
     */
    public function getAvatar($id)
    {
        $image = $this->userManager->getImage($id, 'avatar');
        return $image;
    }
}
