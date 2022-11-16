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
        // dd($request->all());
        DB::beginTransaction();
        try{
            $params = [
                'user_name' => $request->user_name,
                'language_id' => $request->language_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => isset($request->birthday) ? Carbon::createFromFormat('d/m/Y', $request->birthday) : $request->birthday,
            ];

            $this->adminService->updateAdminProfile($id, $params);
            
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
}
