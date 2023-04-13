<?php

namespace App\Http\Requests\Frontend;

use App\Logics\Frontend\ProductManager;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $customerID = Auth::guard('customer')->user()->id;
        $rules = [
            'product_id' => ['required', 'exists:products,id'],
        ];

        $productManager = new ProductManager();
        $dataProduct = $productManager->checkProductType($this->product_id);
        if (!empty($dataProduct)) {
            $productInCart = Cart::query()
                ->leftJoin('cart_detail', 'cart_detail.product_id', '=', 'carts.id')
                ->where('carts.customer_id', $customerID)
                ->select('cart_detail.quantity');

            if ($dataProduct['checkVariant']) {
                $productInCart = $productInCart->where('sku_id',  $this->sku_id)->first();

                $product = Product::leftJoin('product_skus', 'product_skus.product_id', '=', 'products.id')
                    ->where('product_skus.id', $this->sku_id)
                    ->where('products.id', $this->product_id)
                    ->select([
                        'product_skus.stock'
                    ])
                    ->first();
                $rules['sku_id'] = ['required', 'exists:product_skus,id'];
                $rules['quantity'] = ['required', 'integer', 'min:1', function ($attribute, $value, $fail) use ($productInCart, $product) {
 
                    if (!isset($product) || $product->stock == 0 || $product->stock == null) {
                        $fail(trans('language.message_cart.out_stock'));
                    } else {
                        if (isset($productInCart->quantity)) {
                            $canAdd = $product->stock - $productInCart->quantity;
                            if ($value > $canAdd) {
                                $fail(trans('language.message_cart.max_add_in_cart', ['quantity' => $canAdd]));
                            }
                        } else {
                            if ($value > $product->stock) {
                                $fail(trans('language.message_cart.max_add', ['quantity' => $product->stock]));
                            }
                        }
                    }
                }];
            } else {
                $productInCart = $productInCart->whereNull('sku_id')->first();
                $product = Product::where('products.id', $this->product_id)
                    ->select([
                        'products.stock'
                    ])
                    ->first();
                $rules['quantity'] = ['required', 'integer', 'min:1', function ($attribute, $value, $fail) use ($productInCart, $product) {
                    if (!isset($product) || $product->stock == 0 || $product->stock == null) {
                        $fail(trans('language.message_cart.out_stock'));
                    } else {
                        if (isset($productInCart->quantity)) {
                            $canAdd = $product->stock - $productInCart->quantity;
                            if ($value > $canAdd) {
                                $fail(trans('language.message_cart.max_add_in_cart', ['quantity' => $canAdd]));
                            }
                        } else {
                            if ($value > $product->stock) {
                                $fail(trans('language.message_cart.max_add', ['quantity' => $product->stock]));
                            }
                        }
                    }
                }];
            }
        }else{
            $rules['product_id'] = array_push($rules['product_id'], function($attribute, $value, $fail){
                $fail(trans('language.status_s')[Product::NOT_SELL]);
            });
        }

        return $rules;
    }
}
