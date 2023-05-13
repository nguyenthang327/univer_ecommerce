<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProductCommentRequest;
use App\Models\Order;
use App\Models\ProductComment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductCommentController extends Controller
{
    //
    public function index(){
        $columns = [];
        ProductComment::select($columns)->get();
    }

    public function store(ProductCommentRequest $request){
        DB::beginTransaction();
        $customerID = Auth::guard('customer')->user()->id;
        $order = Order::join('order_detail', 'order_detail.order_id', 'orders.id')
            ->where('product_id', $request->product_id)
            ->where('customer_id', $customerID)
            ->where('status',  Order::STATUS_4)
            ->first();

        if(!$order){
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => trans('message.customer_has_not_purchased_this_product'),
                'data' => null,
            ], Response::HTTP_FORBIDDEN);
        }
        try{
            $params = [
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'content' => $request->content,
                'customer_id' => $customerID,
            ];
            $data = ProductComment::create($params);

            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.add_comment_successed'),
                'data' => $data,
            ], Response::HTTP_OK);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => trans('message.server_error'),
                'data' => null,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function destroy(ProductCommentRequest $request, $id){
        // dd($request->all());
        
    }

}
