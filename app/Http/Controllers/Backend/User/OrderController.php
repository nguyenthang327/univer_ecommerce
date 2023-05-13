<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Logics\Admin\OrderManager;
use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class OrderController extends Controller
{
    const TAKE = 12;
    protected $pathView = 'backend.user.order.';

     /**
     * @var OrderManager
     */
    protected $orderManager;

    /**
     * @param \App\Logics\Admin\OrderManager $OrderManager
     */
    public function __construct(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }

    public function index(Request $request){
        $orders = Order::select([
                'orders.*',
                'coupons.discount_percentage',
                DB::raw('CONCAT_WS(", " , orders.address, communes.name, districts.name, prefectures.name) as full_address'),
                DB::raw('SUM(order_detail.subtotal) as total'),
            ])
            ->join('order_detail', 'orders.id', 'order_detail.order_id')
            ->leftJoin('prefectures', 'prefectures.id', 'orders.prefecture_id')
            ->leftJoin('districts', 'districts.id', 'orders.district_id')
            ->leftJoin('communes', 'communes.id', 'orders.commune_id')
            ->leftJoin('customers', 'customers.id', 'orders.customer_id')
            ->leftJoin('coupons', 'coupons.id', 'orders.coupon_id')

            ->groupBy('orders.id');
            // ->orderBy('orders.created_at', 'desc');

        $orders = $orders = $orders->sortable()->paginate(self::TAKE);
        $is_filter = '';

        return view($this->pathView . 'index', compact('orders', 'is_filter'));
    }

    public function edit($id){
        $order = $this->orderManager->getOrderDetail($id);
        if(!$order){
            abort(404);
        }
        return view($this->pathView . 'edit', compact('order'));
    }

    public function update(UpdateOrderRequest $request, $id){
        $order = Order::where('id', $id)->first();

        if(!$order){
            abort(404);
        }
        if($order->status == Order::STATUS_5){
            return redirect()->back()->with([
                'status_failed' => trans('message.update_order_failed_with_status_cancell'),
            ]);
        }
        try{
            DB::beginTransaction();
            $order->status = $request->status;
            $order->save();

            if($request->status == Order::STATUS_5){
                $this->orderManager->handleUpdateProduct($order);
            }
            DB::commit();
            return redirect()->back()->with([
                'status_successed' => trans('message.update_order_successed')
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return redirect()->back()->with([
                'status_failed' => trans('message.update_order_failed'),
            ]);
        }
    }

    public function destroy($id){
        // $order = Order::where('id', $id)->first();
        // if(!$order){
        //     abort(404);
        // }
        // try{
        //     DB::beginTransaction();
        //     $order->status = $request->status;
        //     $order->save();
        //     return back()->with([
        //         'status_successed' => trans('message.update_order_successed')
        //     ]);
        // }catch(Exception $e){
        //     DB::rollBack();
        //     Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
        //     return back()->with([
        //         'status_failed' => trans('message.update_order_failed'),
        //     ]);
        // }
    }

    // public function exportOrderPDF($id){
        
    //     $order = $this->orderManager->getOrderDetail($id);
    //     if(!$order){
    //         abort(404);
    //     }

    //     $pdf = PDF::loadView($this->pathView .'orderPDF',  compact('order'));
    // 	return $pdf->download(date('d/m/Y') . "_order_$order->id.pdf");
    // }
}
