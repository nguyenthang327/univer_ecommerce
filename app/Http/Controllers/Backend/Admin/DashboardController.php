<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * @var string
     */
    protected $pathView = 'backend.admin.dashboard.';

    public function index()
    {
        $data = [];
        $data['customers'] = Customer::count();
        $data['users'] = User::count();
        $data['orderNeedProcess'] = Order::whereNotIn('status', [Order::STATUS_5, Order::STATUS_4])->count();
        $data['productSell'] = Product::where('status', Product::SELL)->count();
        // $data['products'] = Product::count();

        $data['topFavoriteProduct'] = Product::join('favorite_product', 'favorite_product.product_id', 'products.id')
            ->groupBy('products.id')
            ->select([
                'products.*',
                DB::raw('COUNT(IF(favorite_product.product_id = products.id , 1 , null)) as total')
            ])
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $startOfCurrentWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfCurrentWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        $startOfLastWeek  = Carbon::now()->startOfWeek()->subDays(7)->format('Y-m-d');
        $endtOfLastWeek  =  Carbon::now()->startOfWeek()->subDays(1)->format('Y-m-d');

        $subQuery = OrderDetail::select([
                DB::raw('SUM(order_detail.price) as total_1'),
                'order_detail.order_id'
            ])
            ->groupBy('order_detail.order_id');
    
        $fourteenday = Order::joinSub($subQuery, 'subqr1', function($join){
                $join->on('subqr1.order_id', 'orders.id');
            })
            ->select([
                DB::raw('SUM(subqr1.total_1) as total'),
                DB::raw('DATE(orders.created_at) as date'),
            ])
            ->groupBy('date');

        $queryClone = clone $fourteenday;
        $queryClone2 = clone $fourteenday;

        $sumLastWeek = $queryClone->whereDate('orders.created_at', '>=', $startOfLastWeek)
            ->whereDate('orders.created_at', '<=', $endtOfLastWeek)->get();

        $sumCurrentWeek = $queryClone2->whereDate('orders.created_at', '>=', $startOfCurrentWeek)
            ->whereDate('orders.created_at', '<=', $endOfCurrentWeek)->get();

        $orderLastWeek = [];
        $orderThisWeek = [];

        $i = 0;
        $j = Carbon::now()->diffInDays($startOfCurrentWeek);
        
        $language = App::getLocale();

        if($language == 'vi'){
            $currency = 23000;
        }else{
            $currency = 1;
        }
        for($i = 0; $i <= $j; ++$i){
            $check = true;
            foreach($sumCurrentWeek as $value){
                if(Carbon::now()->startOfWeek()->addDays($i)->format('Y-m-d') == $value->date){
                    $check = false;
                    $orderThisWeek[] = (float)$value->total * $currency;
                    break;
                }
            }
            if($check){
                $orderThisWeek[] = 0;
            }
        }
        $i = 7;
        for($i = 7; $i >= 1; --$i){
            $check = true;
            foreach($sumLastWeek as $value){
                if(Carbon::now()->startOfWeek()->subDays($i)->format('Y-m-d') == $value->date){
                    $check = false;
                    $orderLastWeek[] = (float)$value->total * $currency;
                    break;
                }
            }
            if($check){
                $orderLastWeek[] = 0;
            }
        }
        $orderLastWeek = collect($orderLastWeek);
        $orderThisWeek = collect($orderThisWeek);

        return view($this->pathView . 'index', compact('data', 'orderThisWeek', 'orderLastWeek'));
    }
}
