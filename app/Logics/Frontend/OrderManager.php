<?php

namespace App\Logics\Frontend;

use App\Events\CustomerOrder;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSku;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderManager
{
    public function handleUpdateCartDetail($id, $quantity){
        if($quantity == 0){
            CartDetail::where('id', $id)->delete();
        }else{
            CartDetail::where('id', $id)->update(['quantity' => $quantity]);
        }
    }

    public function handleStoreOrder($customer, $params){
        $subQuery = ProductVariant::join('product_options', 'product_options.id', 'product_variants.product_option_id')
                ->join('product_option_values', 'product_option_values.id', 'product_variants.product_option_value_id')
                ->select([
                    'product_variants.sku_id',
                    DB::raw("GROUP_CONCAT(CONCAT(product_options.name, ': ', product_option_values.value)  SEPARATOR ', ') AS attributes")
                ])
                ->groupBy('product_variants.sku_id');

        $productInCart = Cart::join('cart_detail', 'cart_detail.cart_id', 'carts.id')
            ->leftJoin('products', 'products.id', '=', 'cart_detail.product_id')
            ->leftJoin('product_skus', 'product_skus.id', '=', 'cart_detail.sku_id')
            ->leftJoinSub($subQuery, 'product_variants', function($leftJoin){
                $leftJoin->on('cart_detail.sku_id', '=', 'product_variants.sku_id');
            })
            ->where('carts.customer_id', $customer->id)
            ->select([
                'cart_detail.cart_id as cart_id',
                'cart_detail.id as cart_detail_id',
                'cart_detail.product_id',
                'cart_detail.sku_id as cart_sku_id',
                'cart_detail.quantity as cart_quantity',
                'products.stock as product_stock',
                'products.name as product_name',
                'product_skus.stock as sku_stock',
                'product_skus.id as sku_id',
                'product_variants.attributes',
                'products.status as product_status',
                DB::raw('
                    (CASE WHEN
                        product_skus.id is not null
                            THEN 
                                product_skus.price - IF(products.discount > 0, products.discount *  product_skus.price / 100, 0)
                            ELSE 
                                products.price - IF(products.discount > 0, products.discount *  products.price / 100, 0)
                    END) AS price
                '),
            ])
            ->get();

        $errors = [];
        foreach($productInCart as $product){
            if($product->product_status == Product::NOT_SELL){
                $errors[] = "Sản phẩm: $product->product_name $product->attributes đã ngừng bán.";
                $this->handleUpdateCartDetail($product->cart_detail_id, 0);
                break;
            }
            if($product->cart_sku_id && $product->cart_sku_id == $product->sku_id){
                $check = $product->sku_stock - $product->cart_quantity;
                if($check < 0){
                    $errors[] = "Sản phẩm: $product->product_name $product->attributes còn $product->sku_stock trong cửa hàng.";
                    $this->handleUpdateCartDetail($product->cart_detail_id, $product->sku_stock);
                }
            }else{
                $check = $product->product_stock - $product->cart_quantity;
                if($check < 0){
                    $errors[] = "Sản phẩm: $product->product_name còn $product->sku_stock trong cửa hàng.";
                    $this->handleUpdateCartDetail($product->cart_detail_id, $product->product_stock);
                }
            }
        }

        if(!empty($errors)){
            $errors[] = 'Chúng tôi đã cập nhật lại sản phẩm trong giỏ hàng. Vui lòng kiểm tra lại thông tin sản phẩm';
        }else{
            $order = Order::create($params);
            foreach($productInCart as $product){
                if($product->cart_sku_id && $product->cart_sku_id == $product->sku_id){
                    $stock = $product->sku_stock - $product->cart_quantity;
                    ProductSku::where('id', $product->cart_sku_id)->update(['stock'=> $stock]);
                }else{
                    $stock = $product->product_stock - $product->cart_quantity;
                    Product::where('id', $product->product_id)->update(['stock'=> $stock]);
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->product_id,
                    'sku_id' => $product->sku_id,
                    'product_name' => $product->product_name,
                    'attribute' => $product->sku_id ? (string)$product->attributes : null,
                    'price' => $product->price,
                    'quantity' => $product->cart_quantity,
                ]);
            }
            CartDetail::where('cart_id', $productInCart[0]->cart_id)->delete();
            $order = $this->getInfoOrder($order->id);
            event(new CustomerOrder($customer, $order));
        }
        return $errors;
    }

    public function getInfoOrder($id){
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