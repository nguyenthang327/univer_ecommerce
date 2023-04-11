<?php

namespace App\Http\Controllers\Frontend;

use App\Events\RegisterCustomer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\LoginRequest;
use App\Http\Requests\Frontend\RegisterRequest;
use App\Http\Requests\Frontend\RegisterVerifyRequest;
use App\Models\Cart;
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
     * @param \App\Http\Requests\Frontend\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(LoginRequest $request){
        $credentials = [
            'email' => $request->email_login,
            'password' => $request->password_login,
        ];

        if(Auth::guard('customer')->attempt($credentials, $request->has('remember_me'))){
            $request->session()->regenerate();
            return redirect()->route('site.home');
        }
        return back()->withErrors([
            'error' => trans('message.error_login')
        ]);
    }

    public function registerStep1(){
        if(Auth::guard('customer')->check()){
            return redirect()->route('site.home');
        }
        return view($this->pathView . '.my-account')->with('type', 'register');
    }

    /**
     * customer to register
     * @param \App\Http\Requests\Frontend\RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request){
        try{
            DB::beginTransaction();
            $customer = Customer::where('email', $request->email)->first();
            if(!$customer){
                $customer = Customer::create([
                    'email' => $request->email,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'status' => Customer::STATUS_INACTIVE,
                    'password' => Hash::make($request->password),
                ]);
            }else{
                $customer->password = Hash::make($request->password);
                $customer->first_name = $request->first_name;
                $customer->last_name = $request->last_name;
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
            return redirect()->route('customer.register.step2', ['id' =>  $customer->id]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.register_user_failed'),
            ]);
        }
    }

    public function registerStep2($id){
        if(Auth::guard('customer')->check()){
            return redirect()->route('site.home');
        }
        $customer = Customer::where('id', $id)->where('status', Customer::STATUS_INACTIVE)->first();
        return view($this->pathView . '.register-enter-code', compact('customer'));
    }

    /**
     * customer to register
     * @param \App\Http\Requests\Frontend\RegisterVerifyRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerVerify(RegisterVerifyRequest $request, $id){
        try{
            DB::beginTransaction();
            $customer = Customer::where('id', $id)->first();
            if(!$customer){
                return back()->with(['status_failed' => 'Không tồn tại tài khoản']);
            }
            $customer->status = Customer::STATUS_ACTIVE;
            $customer->save();

            CustomerActivation::where('customer_id', $customer->id)->where('code', $request->code)->update([
                'completed' => CustomerActivation::COMPLETED,
                'completed_at' => Carbon::now(),
            ]);
            
            Cart::create(['customer_id' => $customer->id]);

            DB::commit();
            return redirect()->route('login')
                ->with(['status_successed' => 'Bạn đã xác thực tài khoản thành công. Đăng nhập để sử dụng']);
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
