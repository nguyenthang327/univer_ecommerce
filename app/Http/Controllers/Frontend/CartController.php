<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CartStoreRequest;
use App\Logics\Frontend\CartManager;
use App\Logics\Frontend\ProductManager;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $pathView = 'frontend.cart.';

    protected $cartManager;
    protected $productManager;

    public function __construct(CartManager $cartManager, ProductManager $productManager)
    {
        $this->cartManager = $cartManager;
        $this->productManager = $productManager;
    }
    
    public function index(){
        // $cartFeature = $this->cartManager->getcarts($take, 'is_featured');
        // $cartNew = $this->cartManager->getcarts($take, 'new');
        $customerID = Auth::guard('customer')->user()->id;
        $productsInCart = Cart::join('cart_detail', 'cart_detail.cart_id', '=', 'carts.id')
            ->join('products', 'products.id', '=', 'cart_detail.product_id')
            ->leftJoin('product_skus', 'product_skus.id', '=', 'cart_detail.sku_id')
            ->where('carts.customer_id', $customerID)
            ->select([
                'carts.id as cart_id',
                'cart_detail.id as cart_detail_id',
                'products.id as product_id',
                'products.slug as product_slug',
                'product_skus.id as sku_id',
                'products.name as product_name',
                'products.gallery as product_gallery',
                'cart_detail.quantity as quantity',
                DB::raw('
                    (CASE WHEN
                        sku_id is not null
                            THEN 
                                product_skus.price - IF(products.discount > 0, products.discount *  product_skus.price / 100, 0)
                            ELSE 
                                products.price - IF(products.discount > 0, products.discount *  products.price / 100, 0)
                    END) AS price
                '),
                DB::raw('
                    (CASE WHEN
                        sku_id is not null
                            THEN 
                                product_skus.stock
                            ELSE 
                                products.stock
                    END) AS stock
                '),
            ])->get();
        // dd($productsInCart->toArray());

        return view($this->pathView . 'cart', compact('productsInCart'));
    }

    /**
     * store product in cart
     * @param \App\Http\Requests\Frontend\CartStoreRequest $request
     * @param \App\Http\Requests\Frontend\CartStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CartStoreRequest $request){
        DB::beginTransaction();
        try{
            $params = [
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ];

            $customerID = Auth::guard('customer')->user()->id;
            $cart = Cart::where('customer_id', $customerID)->first();
            $params['cart_id'] = $cart->id;

            $dataProduct = $this->productManager->checkProductType($params['product_id']);
            if(empty($dataProduct)){
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => trans('message.not_found'),
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }

            $productInCart = CartDetail::where('cart_id', $cart->id)
                ->where('product_id', $params['product_id']);
            if(isset($dataProduct['checkVariant']) && $dataProduct['checkVariant'] == true){
                $params['sku_id'] = $request->sku_id;
                $productInCart = $productInCart->where('sku_id', $params['sku_id'])->first();
            }else{
                $productInCart = $productInCart->whereNull('sku_id')->first();
            }

            if($productInCart){
                $productInCart->quantity = $productInCart->quantity + $params['quantity'];
                $productInCart->save();
            }else{
                $productInCart = CartDetail::create($params);
            }

            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.add_product_in_cart_successed'),
                'data' => $productInCart,
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

     /**
     * update product in cart
     * @param \App\Http\Requests\Frontend\CartStoreRequest $request
     * @param \App\Http\Requests\Frontend\CartStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try{
            $customerID = Auth::guard('customer')->user()->id;
            $item = Cart::join('cart_detail', 'cart_detail.cart_id', '=', 'carts.id')
                ->where('customer_id', $customerID)
                ->where('cart_detail.id', $id)
                ->select([
                    'cart_detail.id as cart_detail_id'
                ])
                ->first();

            if(!$item){
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => trans('message.not_found'),
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            $item = CartDetail::where('id', $item->cart_detail_id)->first();
            $item->quantity = $request->quantity;
            $item->save();

            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.update_product_in_cart_successed'),
                'data' => $item,
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

    /**
     * remove product in cart
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        DB::beginTransaction();
        try{
            $customerID = Auth::guard('customer')->user()->id;
            $item = Cart::join('cart_detail', 'cart_detail.cart_id', '=', 'carts.id')
                ->where('customer_id', $customerID)
                ->where('cart_detail.id', $id)
                ->select([
                    'cart_detail.id as cart_detail_id'
                ])
                ->first();

            if(!$item){
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => trans('message.not_found'),
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            CartDetail::where('id', $item->cart_detail_id)->delete();

            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.delete_product_in_cart_successed'),
                'data' => null,
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


}
