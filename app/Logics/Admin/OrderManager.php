<?php

namespace App\Logics\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSku;

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


}

?>