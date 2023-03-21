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

            $product = $this->productManager->createProduct($params, isset($request->gallery) ? $request->gallery : []);
            DB::commit();
            return redirect()->route('user.product.edit', ['slug' => $product->slug])->with(['status_successed' => trans('message.create_product_successed')]);
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
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => trans('message.product_not_exists'),
            ], Response::HTTP_NOT_FOUND);
        }
        DB::beginTransaction();
        try{
            $this->productManager->createOrUpdateOption($request, $product);

            $options = ProductOption::select(
                    'product_options.id',
                    'product_options.name',
                    DB::raw("GROUP_CONCAT( CONCAT(product_option_values.value, '') SEPARATOR '|' ) AS optionValue"),
                )
                ->leftJoin('product_option_values', 'product_option_values.product_option_id', '=', 'product_options.id')
                ->where('product_options.product_id', $product->id)
                ->groupBy('product_options.id')
                ->get();

            if(count($options) > 2){
                DB::rollBack();
                return response()->json([
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => trans('language.max_option'),
                ], Response::HTTP_FORBIDDEN);
            }
            $html = view('backend.user.product.partials.form-option',[
                    'options' => $options,
                    'product' => $product,
                ])->render();
            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.save_option_successed'),
                'html' => $html,
            ], Response::HTTP_OK);
        }catch(Exception $e){
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => trans('message.save_option_failed'),
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

    /**
     * delete option and option values by option
     * @param $productId
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    public function generateVariation($productId){
        $product = Product::with('optionValues')->where('id', $productId)->first();
        if(!$product){
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => trans('message.product_not_exists'),
            ], Response::HTTP_NOT_FOUND);
        }
        if($product->optionValues->isEmpty()){
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => trans('message.option_not_exists'),
            ], Response::HTTP_NOT_FOUND);
        }

        dd($product->optionValues());
    }
}
