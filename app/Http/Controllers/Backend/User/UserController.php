<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Logics\Admin\UserManager;
use App\Models\Language;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    public function update(UpdateUserRequest $request, $id){
        $user = $this->checkUserExist($id, true);

        DB::beginTransaction();
        try{
            $params = [
                'user_name' => $request->user_name,
                'language_id' => $request->language_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => isset($request->birthday) ? Carbon::createFromFormat('d/m/Y', $request->birthday) : $request->birthday,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'prefecture_id' => $request->prefecture_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
                'identity_card' => $request->identity_card,
            ];
            $this->userManager->updateUserProfile($user, $params, $request->avatar);

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
     * Check if user exist then return User, else return error message
     *
     * @param $user_id
     * @param bool $deleted
     * @return array|User
     */
    private function checkUserExist($user_id, $deleted=false) {
        if ($deleted) {
            $user = User::withTrashed()->find($user_id);
        } else {
            $user = User::find($user_id);
        }

        if ($user == null) {
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'msg' => trans('message.user_not_exist'),
                'url_callback' => back()->getTargetUrl(),
            ];
        }
        return $user;
    }
}
