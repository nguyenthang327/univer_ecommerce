<?php

namespace App\Logics\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Support\Facades\DB;

class OrderManager
{
    public function handleUpdateProduct($order){
        $productInOrder = Order::join('order_detail', 'order_detail.order_id', 'orders.id')
            ->leftJoin('products', 'products.id', '=', 'order_detail.product_id')
            ->leftJoin('product_skus', 'product_skus.id', '=', 'order_detail.sku_id')
            ->where('orders.id', $order->id)
            ->select([
                'order_detail.order_id as order_id',
                'order_detail.id as order_detail_id',
                'order_detail.product_id',
                'order_detail.sku_id as order_sku_id',
                'order_detail.quantity as order_quantity',
                'product_skus.id as sku_id',
            ])
            ->get();

        foreach($productInOrder as $product){
            if($product->order_sku_id){
                if($product->order_sku_id == $product->sku_id){
                    $productSku = ProductSku::where('id', $product->order_sku_id)->first();
                    if($productSku){
                        $stock = $productSku->stock + $product->order_quantity;
                        $productSku->stock = $stock;
                        $productSku->save();
                    }
                }
            }else{
                $product = Product::withTrashed()->where('id', $product->product_id)->first();
                if($product){
                    $stock = $product->stock + $product->order_quantity;
                    $product->stock = $stock;
                    $product->save();
                }
            }
        }
    }

    public function getOrderDetail($id){
        $order = Order::select([
                'orders.*',
                'coupons.discount_percentage',
                'customers.email',
                DB::raw('CONCAT_WS(" ", customers.first_name, customers.last_name) as customer_account_name'),
                DB::raw('CONCAT_WS(", " , orders.address, communes.name, districts.name, prefectures.name) as full_address'),
            ])
            ->with(['orderDetail' => function($query){
                $query->join('products','order_detail.product_id', 'products.id')
                    ->leftJoin('product_skus','order_detail.sku_id', 'product_skus.id')
                    ->select([
                        'order_detail.*',
                        'gallery',
                    ]);
            }])
            ->leftJoin('prefectures', 'prefectures.id', 'orders.prefecture_id')
            ->leftJoin('districts', 'districts.id', 'orders.district_id')
            ->leftJoin('communes', 'communes.id', 'orders.commune_id')
            ->leftJoin('coupons', 'coupons.id', 'orders.coupon_id')
            ->leftJoin('customers', 'customers.id', 'orders.customer_id')
            ->where('orders.id', $id)
            ->first();
        return $order;
    }


}

?>