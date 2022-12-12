<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Language;
use App\Http\Requests\Admin\UpdateAdminRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\AdminService;
use Carbon\Carbon;

class AdminController extends Controller
{

    /**
     * @var AdminService
     */
    protected $adminService;

    /**
     * @param \App\Services\AdminService $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    
    /**
     * @var string
     */
    protected $pathView = 'Backend.Admin.Profile.';

    /**
     * display infor admin
     * 
     * @return View
     */
    public function adminProfile(){
        $admin = Auth::guard('admin')->user();
        $languages = Language::select('id','name','display_name')->get();

        return view($this->pathView . 'edit', compact('admin', 'languages'));
    }

    /**
     * @param \App\Http\Requests\Admin\UpdateAdminRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAdminRequest $request, $id){
        DB::beginTransaction();
        $admin = $this->checkAdminExist($id);
        try{
            $params = [
                'email' => $request->email,
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

            $this->adminService->updateAdminProfile($admin, $params, $request->avatar);
            
            DB::commit();
            return back()->with([
                'status_successed' => trans('message.update_profile_successed')
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.update_profile_failed'),
            ]);
        }
    }

    /**
     * Check if admin exist then return ADmin, else return error message
     *
     * @param $admin_id
     * @param bool $deleted
     * @return array|Admin
     */
    private function checkAdminExist($admin_id, $deleted=false) {
        if ($deleted) {
            $admin = Admin::onlyTrashed()->find($admin_id);
        } else {
            $admin = Admin::find($admin_id);
        }

        if ($admin == null) {
            return [
                'status' => 302,
                'msg' => trans('message.admin_not_exist'),
                'url_callback' => back()->getTargetUrl(),
            ];
        }

        return $admin;
    }

    /**
     * Get avatar admin
     * @param $id
     * @return mixed
     */
    public function getAvatar($id)
    {
        $image = $this->adminService->getImage($id, 'avatar');
        return $image;
    }
}
