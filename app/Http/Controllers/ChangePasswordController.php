<?php

namespace App\Http\Controllers;

use App\Enums\TypeAccountEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    
    /**
     * Change user's password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePasswod(Request $request) {
        try {
            if($request->type == TypeAccountEnum::ADMIN->value){
                $user = Auth::guard('admin')->user();
            }elseif($request->type == TypeAccountEnum::USER->value){
                $user = Auth::guard('user')->user();
            }elseif($request->type == TypeAccountEnum::CUSTOMER->value){
                $user = Auth::guard('customer')->user();
            };
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return back()->with([
                    'status_successed' => trans('message.update_succeed')
                ]);
                // return response()->json([
                //     'status' => Response::HTTP_OK,
                //     'message' => trans('message.update_succeed'),
                // ], Response::HTTP_OK);
            } else {
                return back()->with([
                    'status_failed' => trans('message.wrong_password')
                ]);
                // return response()->json([
                //     'status' => Response::HTTP_FORBIDDEN,
                //     'message' => trans('message.wrong_password'),
                // ],Response::HTTP_FORBIDDEN);
            }
        } catch (\Exception $e) {
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
            // return response()->json([
            //     'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            //     'msg' => trans('message.server_error'),
            // ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
