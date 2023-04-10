<?php

namespace App\Http\Controllers\Frontend;

use App\Events\RegisterCustomer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\RegisterRequest;
use App\Http\Requests\Frontend\RegisterVerifyRequest;
use App\Models\Customer;
use App\Models\CustomerActivation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    //

    /**
     * @var string
     */
    protected $pathView = 'frontend.auth.';

    /**
     * check customer logged in
     * @return \Illuminate\Contracts\View\View
     */
    public function index(){
        if(Auth::guard('customer')->check()){
            return redirect()->route('site.home');
        }

        return view($this->pathView . '.my-account')->with('type', 'login');
    }

    /**
     * authenticate customer to login
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'status' => Customer::STATUS_ACTIVE,
        ]);

        if(Auth::guard('customer')->attempt($credentials, $request->has('remember_me'))){
            $request->session()->regenerate();
            return redirect()->route('site.home');
        }

        return back()->withErrors([
            'error' => trans('message.error_login')
        ]);
    }

    public function registerStep1(){
        return view($this->pathView . '.my-account')->with('type', 'register');
    }

    /**
     * customer to register
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request){
        try{
            DB::beginTransaction();
            $customer = Customer::where('email', $request->email)->first();
            if(!$customer){
                $customer = Customer::create([
                    'email' => $request->email,
                    'status' => Customer::STATUS_INACTIVE,
                    'password' => Hash::make($request->password),
                ]);
            }else{
                $customer->password = Hash::make($request->password);
                $customer->save();
            }
    
            $code = sprintf("%06d", mt_rand(1, 999999));
            CustomerActivation::create([
                'customer_id' => $customer->id,
                'code' => $code,
                'completed' => CustomerActivation::NOT_COMPLETED,
                'expired_time' => Carbon::now()->addMinutes(TIME_EXPIRED_CODE),
            ]);
            
            event(new RegisterCustomer($customer, $code));
            DB::commit();
            return back()->with([
                'status_successed' => trans('message.update_user_successed')
            ]);
            // return back()->withErrors([
            //     'error' => trans('message.error_login')
            // ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.update_user_failed'),
            ]);
        }
    }

    /**
     * customer to register
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerVerify(RegisterVerifyRequest $request, $id){
        dd($request->all());
        try{
            DB::beginTransaction();
            $customer = Customer::where('id', $id)->update(['status' => Customer::STATUS_ACTIVE])->first();
            CustomerActivation::where('customer_id', $customer->id)->update([
                'completed' => CustomerActivation::COMPLETED,
                'expired_time' => Carbon::now()->addMinutes(TIME_EXPIRED_CODE),
            ]);
            if(!$customer){
                $customer = Customer::create([
                    'email' => $request->email,
                    'status' => Customer::STATUS_INACTIVE,
                    'password' => Hash::make($request->password),
                ]);
            }else{
                $customer->password = Hash::make($request->password);
                $customer->save();
            }
            
            
            // event(new RegisterCustomer($customer, $code));
            DB::commit();
            return back()->with([
                'status_successed' => trans('message.update_user_successed')
            ]);
            // return back()->withErrors([
            //     'error' => trans('message.error_login')
            // ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.update_user_failed'),
            ]);
        }
    }

    /**
     * customer logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('site.home');
    }
}
