<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Logics\User\ProductManager;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOption\Option;

class ProductController extends Controller
{
    //
    protected $pathView = 'backend.user.product.';

    /**
     * @var ProductManager
     */
    protected $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    public function index(){
        return view($this->pathView. 'index');
    }

    public function create(){
        return view($this->pathView. 'create');
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
            $params = [
                'name' => $request->product_name,
                'sku' => $request->sku,
                'slug' => $request->slug,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'description' => $request->description,
            ];

            $product = $this->productManager->createProduct($params, $request->gallery);
            DB::commit();
            return redirect()->route('user.product.edit', ['slug' => $product->slug]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.update_user_failed'),
            ]);
        }
    }

    public function edit($slug){
        $product = Product::where('slug', $slug)->first();
        if(!$product){
            abort(Response::HTTP_NOT_FOUND);
        }
        $options = ProductOption::select(
                'product_options.id',
                'product_options.name',
                DB::raw("GROUP_CONCAT( CONCAT(product_option_values.value, '') SEPARATOR '|' ) AS optionValue"),
            )
            ->leftJoin('product_option_values', 'product_option_values.product_option_id', '=', 'product_options.id')
            ->where('product_options.product_id', $product->id)
            ->groupBy('product_options.id')
            ->get();
            // dd($options);
        return view($this->pathView. 'edit', compact('product', 'options'));
    }

    public function option(Request $request, $id){
        // foreach($request->all() as $key => $request){
        //     // dd($request);
        // }

        $product = Product::where('id', $id)->first();
        if(!$product){
            
        }
        DB::beginTransaction();
        try{
            if(isset($request->option_id) && isset($request->option_name)  && isset($request->option_value)){
                foreach($request->option_id as $key => $value){
                    if($value == null){
                        $option = ProductOption::create([
                            'name' => $request->option_name[$key],
                            'product_id' => $product->id,
                        ]);
                        $optionValue = explode("|", $request->option_value[$key]);

                        foreach($optionValue as $val){
                            ProductOptionValue::create([
                                'value' => $val,
                                'product_id' => $product->id,
                                'product_option_id' => $option->id,
                            ]);
                        }
                    }else{
                        $option = ProductOption::with('optionValues')
                            ->where('id', $value)
                            ->where('product_id', $product->id)
                            ->first();
                        $option->name =  $request->option_name[$key];
                        $option->save();
                        $optionValue = explode("|", $request->option_value[$key]);
                        $optionValueOld = $option->optionValues->pluck('value')->toArray();
                        // dd($optionValueOld);
                        $diff = array_diff($optionValueOld, $optionValue);
dd($diff);
                        foreach($optionValue as $val){
                            $optionValue = ProductOptionValue::where('value', $val)
                                ->where('product_option_id', $option->id)
                                ->where('product_id', $product->id)
                                ->first();
                            if(!$optionValue){
                                ProductOptionValue::create([
                                    'value' => $val,
                                    'product_id' => $product->id,
                                    'product_option_id' => $option->id,
                                ]);
                            }
                        }

                        // ProductOptionValue::whereNotIn('value', $optionValue)
                        //     ->where('product_id', $product->id)
                        //     ->where('product_option_id', $option->id)
                        //     ->delete();
                    }
                }
            }
            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.save_option_successed'),
            ], Response::HTTP_OK);
        }catch(Exception $e){
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => trans('message.save_option_successed'),
            ], Response::HTTP_NOT_FOUND);
        }

        // $request->
        // Option::create();
        // $product = Product::where('slug', $slug)->first();
        // if(!$product){
        //     abort(Response::HTTP_NOT_FOUND);
        // }
        // return view($this->pathView. 'edit', compact('product'));
    }

    public function deleteOption($productId, $id){
        DB::beginTransaction();
        try{
            $option = ProductOption::with('optionValues')
                ->where('product_id',$productId)
                ->where('id', $id)
                ->first();
            if(!$option){
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => trans('message.option_not_found'),
                ], Response::HTTP_NOT_FOUND);
            }
            if($option->optionValues){
                $option->optionValues()->delete();
            }
            $option->delete();
            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.remove_option_successed'),
            ], Response::HTTP_OK);
        }catch(Exception $e){
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => trans('message.option_not_found'),
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
