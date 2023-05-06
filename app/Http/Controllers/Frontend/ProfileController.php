<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\UpdateCustomerRequest;
use App\Models\Customer;
use App\Traits\ImageTrait;
use App\Traits\StorageTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProfileController extends BaseController
{
    use StorageTrait;
    use ImageTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $customer = Auth::guard('customer')->user();
        return view('frontend.info.index', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request){
        DB::beginTransaction();
        try{
            $params = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => isset($request->birthday) ? Carbon::createFromFormat('d/m/Y', $request->birthday) : $request->birthday,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'prefecture_id' => $request->prefecture_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
            ];
            $customer = Auth::guard('customer')->user();
            $old_avatar_path = null;
            $avatar_path = $customer->avatar;
            if($request->avatar) {
                $old_avatar_path = $customer->avatar;
                $extention = $request->avatar->getClientOriginalExtension();
                $avatar = $this->resizeImage($request->avatar->getRealPath(), AVATAR_WIDTH);
                $avatar_path = $this->uploadFileByStream($avatar, CUSTOMER_DIR. '/' . $customer->id .'/'.Str::random(25).'.' . $extention);
            }

            $params += [
                'avatar' => $avatar_path
            ];

            Customer::where('id', $customer->id)->update($params);

            if($old_avatar_path) {
                // Remove old file
                $this->deleteFile($old_avatar_path);
            }

            DB::commit();
            return back()->with([
                'status_successed' => trans('message.update_successed')
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.update_self_info_failed'),
            ]);
        }
    }
}
