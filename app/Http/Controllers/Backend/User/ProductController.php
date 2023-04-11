<?php

namespace App\Http\Controllers\Backend\User;

use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateSkuRequest;
use App\Logics\User\ProductManager;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductSku;
use App\Models\ProductVariant;
use App\Traits\StorageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use StorageTrait;

    const PER_PAGE = 15;
    const PATH_VIEW_ADMIN = 'backend.admin.product.';

    protected $pathView = 'backend.user.product.';

    /**
     * @var ProductManager
     */
    protected $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    /**
     * check admin to change path
     */
    private function checkAdmin(){
        if(Auth::guard('admin')->check()){
            $this->pathView = self::PATH_VIEW_ADMIN;
        }
    }

    /**
     * display product view
     * @param \Illuminate\Http\Request $request
     * @return View
     */
    public function index(Request $request){
        $stringHelper = new StringHelper();
        $products = Product::with(['skus' => function($query){
                $query->select([
                    'product_skus.*',
                    DB::raw('MIN(product_skus.price) as min_price'),
                    DB::raw('MAX(product_skus.price) as max_price'),
                    DB::raw('SUM(product_skus.stock) as total_stock'),
                ])
                ->whereNotNull('product_skus.price')
                ->whereNotNull('product_skus.stock')
                ->groupBy('product_skus.product_id');
            }])
            ->select([
                'products.*',
                DB::raw("GROUP_CONCAT( CONCAT(product_categories.name, '') SEPARATOR ', ' ) AS cateogry"),
                'brands.name as brand_name',
            ])
            ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
            ->leftJoin('product_category_relation', 'products.id', '=', 'product_category_relation.product_id')
            ->leftJoin('product_categories', 'product_categories.id', '=', 'product_category_relation.category_id');

        if(isset($request->categories_id)){
            $products = $products->whereIn('product_categories.id', $request->categories_id);
        }

        // if(isset($request->price_from)){
        //     $products = $products->whereIn('products.prices', $request->price_from);
        // }
        // if(isset($request->price_to)){
        //     $products = $products->whereIn('products.prices', $request->price_to);
        // }

        if(isset($request->keyword)){
            $keyword = $stringHelper->formatStringWhereLike($request->keyword);
            $products = $products->where('products.name', 'LIKE', '%'.$keyword.'%')
                ->orWhere('products.sku', 'LIKE', '%'.$keyword.'%');
        }

        if(!isset($request->direction)){
            $products = $products->orderBy('products.created_at', 'desc');
        }

        $products = $products->groupBy('products.id');

        // Pagination
        $perPage = $request->has('per_page') ? $request->input('per_page') : self::PER_PAGE;
        $products = $products->sortable()->paginate($perPage);

        $categories = ProductCategory::select('id', 'name')->get()->toArray();

        $this->checkAdmin();
        return view($this->pathView. 'index', compact('products', 'categories'));
    }

    /**
     * display product view
     * @return View
     */
    public function create(){
        $categories = ProductCategory::select([
                'product_categories.id',
                'product_categories.name',
                ])
            ->with(['_2LevelCate'])
            ->whereNull('product_categories.parent_id')
            ->get()
            ->toArray();

        $this->checkAdmin();
        return view($this->pathView. 'create', compact('categories'));
    }

    /**
     * save product
     * @param \App\Http\Requests\Product\ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request){
        DB::beginTransaction();
        try{
            $params = [
                'name' => $request->product_name,
                'sku' => $request->sku,
                'slug' => $request->slug,
                'price' => $request->price,
                'stock' => $request->stock,
                'discount' =>  $request->discount,
                'is_featured' => $request->is_featured ? Product::IS_FEATURE : Product::IS_NOT_FEATURE,
                'description' => $request->description,
                'brand_id' => $request->brand_id,
                'status' => $request->status,
            ];

            $categories = isset($request->category_id) ? $request->category_id : [];

            $product = $this->productManager->createProduct($params, isset($request->gallery) ? $request->gallery : [], $categories);
            if(isset($request->gallery_remove) && !empty($request->gallery_remove)){
                foreach($request->gallery_remove as $file){
                    $this->deleteFile($file);
                }
            }
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

    /**
     * edit product screen
     * @param $slug
     * @return View
     */
    public function edit($slug){
        $product = Product::with('categories')->where('slug', $slug)->first();
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
        
        $skus = ProductSku::with(['variants' => function($query) {
                $query->select([
                    DB::raw("GROUP_CONCAT( CONCAT(product_option_values.value, '') SEPARATOR ' | ' ) AS optionValue"),
                    'product_variants.*',
                ])
                ->leftJoin('product_option_values', 'product_option_values.id', '=', 'product_variants.product_option_value_id')
                ->groupBy('product_variants.sku_id');
            }])
            ->where('product_id', $product->id)
            ->get();

        $categories = ProductCategory::select([
                'product_categories.id',
                'product_categories.name',
                ])
            ->with(['_2LevelCate'])
            ->whereNull('product_categories.parent_id')
            ->get()
            ->toArray();

        $this->checkAdmin();
        return view($this->pathView. 'edit', compact('product', 'options', 'skus', 'categories'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, $id){
        $product = Product::with('categories')->where('id', $id)->first();
        if(!$product){
            return back()->with([
                'status_failed' => trans('message.product_not_found'),
            ]);
        }
        DB::beginTransaction();
        try{
            $params = [
                'name' => $request->product_name,
                'sku' => $request->sku,
                'slug' => $request->slug,
                'price' => $request->price,
                'stock' => $request->stock,
                'discount' =>  $request->discount,
                'is_featured' => $request->is_featured ? Product::IS_FEATURE : Product::IS_NOT_FEATURE,
                'description' => $request->description,
                'brand_id' => $request->brand_id,
                'status' => $request->status,
            ];

            $categories = isset($request->category_id) ? $request->category_id : [];

            $product = $this->productManager->updateProduct($product, $params, isset($request->gallery) ? $request->gallery : [], $categories);

            if(isset($request->gallery_remove) && !empty($request->gallery_remove)){
                foreach($request->gallery_remove as $file){
                    $this->deleteFile($file);
                }
            }
            DB::commit();
            return redirect()->route('user.product.edit', ['slug' => $params['slug']])->with(['status_successed' => trans('message.update_product_successed')]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.update_user_failed'),
            ]);
        }
    }

    /**
     * Process save option
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function option(Request $request, $id){
        $product = Product::with('optionValues', 'options', 'skus', 'variants')->where('id', $id)->first();
        if(!$product){
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => trans('message.product_not_exists'),
            ], Response::HTTP_NOT_FOUND);
        }
        DB::beginTransaction();
        try{
            $check = $this->productManager->createOrUpdateOption($request, $product);
            if(isset($check) && is_array($check) && $check['status'] == false){
                DB::rollBack();
                return response()->json([
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => trans('message.please_enter_option_value', ['position' =>  $check['position']]),
                ], Response::HTTP_FORBIDDEN);
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

            if(count($options) > 2){
                DB::rollBack();
                return response()->json([
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => trans('language.max_option'),
                ], Response::HTTP_FORBIDDEN);
            }

            $skus = ProductSku::with(['variants' => function($query) {
                    $query->select([
                        DB::raw("GROUP_CONCAT( CONCAT(product_option_values.value, '') SEPARATOR ' | ' ) AS optionValue"),
                        'product_variants.*',
                    ])
                    ->leftJoin('product_option_values', 'product_option_values.id', '=', 'product_variants.product_option_value_id')
                    ->groupBy('product_variants.sku_id');
                }])
                ->where('product_id', $product->id)
                ->get();

            $html = view('backend.user.product.partials.variant-content',[
                    'options' => $options,
                    'skus' => $skus,
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
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => trans('message.server_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * delete option and option values by option
     * @param $productId
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOption($productId, $id){
        $product = Product::where('id', $productId)->first();
        if(!$product){
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => trans('message.product_not_exists'),
            ], Response::HTTP_NOT_FOUND);
        }
        DB::beginTransaction();
        try {
            $option = ProductOption::with([
                    'optionValues',
                    'variants' => function ($query) {
                        $query->groupBy('product_variants.sku_id');
                    }
                ])
                ->where('product_id', $productId)
                ->where('id', $id)
                ->first();
            if(!$option){
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => trans('message.option_not_found'),
                ], Response::HTTP_NOT_FOUND);
            }
            if($option->optionValues->isNotEmpty()){
                $option->optionValues()->delete();
            }
            if($option->variants->isNotEmpty()){
                ProductSku::whereIn('id', $option->variants->pluck('sku_id'))->delete();
            }
            $option->delete();

            // regenerate
            $product = Product::with('optionValues')->where('id', $product->id)->first();
            $optionValuesNow = $product->optionValues->groupBy('product_option_id')->values()->toArray();
            if($product->optionValues->isNotEmpty()){
                $variants = Product::generateVariant($optionValuesNow);
                $product->saveVariant($variants);
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

            $skus = ProductSku::with(['variants' => function($query) {
                    $query->select([
                        DB::raw("GROUP_CONCAT( CONCAT(product_option_values.value, '') SEPARATOR ' | ' ) AS optionValue"),
                        'product_variants.*',
                    ])
                    ->leftJoin('product_option_values', 'product_option_values.id', '=', 'product_variants.product_option_value_id')
                    ->groupBy('product_variants.sku_id');
                }])
                ->where('product_id', $product->id)
                ->get();

            $html = view('backend.user.product.partials.variant-content',[
                    'options' => $options,
                    'skus' => $skus,
                    'product' => $product,
                ])->render();
            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.remove_option_successed'),
                'html' => $html,
            ], Response::HTTP_OK);
        }catch(Exception $e){
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => trans('message.server_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * update sku
     * @param \App\Http\Requests\Product\UpdateSkuRequest $request
     * @param mixed $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSku(UpdateSkuRequest $request, $productId){
        $product = Product::where('id', $productId)->first();
        if(!$product){
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => trans('message.product_not_exists'),
            ], Response::HTTP_NOT_FOUND);
        }
        DB::beginTransaction();
        try{
            if(isset($request->remove_sku_id) && is_array($request->remove_sku_id)){
                ProductSku::whereIn('id', $request->remove_sku_id)->delete();
            }
            $product = Product::with('skus')->where('id', $productId)->first();
            if(isset($request->sku_id)){
                $skus = $product->skus;
                foreach ($skus as $key => $sku) {
                    // $validator = Validator::make($request->all(), [
                    //     $key => [
                    //         'required',
                    //         'integer',
                    //         Rule::exists('product_skus', 'id'),
                    //     ],
                    //     'sku_price.' . $key => [
                    //         'nullable',
                    //         'numeric',
                    //         'min:0',
                    //     ],
                    //     'sku_stock.' . $key => [
                    //         'nullable',
                    //         'numeric',
                    //         'min:0',
                    //     ],
                    //     'sku_name.' . $key => [
                    //         Rule::unique('product_skus', 'name')->ignoreModel($sku),
                    //         Rule::unique('products', 'sku'),
                    //     ]
                    // ]);

                    // if ($validator->fails()) {
                    //     // dd($validator->errors()->first());
                    //     $errors[$key] = $validator->errors()->first();
                    // }
                    $sku->price = $request->sku_price[$key];
                    $sku->stock = $request->sku_stock[$key];
                    $sku->name = $request->sku_name[$key];
                    $sku->save();
                }
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

            $skus = ProductSku::with(['variants' => function($query) {
                    $query->select([
                        DB::raw("GROUP_CONCAT( CONCAT(product_option_values.value, '') SEPARATOR ' | ' ) AS optionValue"),
                        'product_variants.*',
                    ])
                    ->leftJoin('product_option_values', 'product_option_values.id', '=', 'product_variants.product_option_value_id')
                    ->groupBy('product_variants.sku_id');
                }])
                ->where('product_id', $product->id)
                ->get();
            $html = view('backend.user.product.partials.variant-content',[
                'options' => $options,
                'skus' => $skus,
                'product' => $product,
            ])->render();
            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.update_sku_successed'),
                'html' => $html,
            ], Response::HTTP_OK);
        }catch(Exception $e){
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => trans('message.server_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // public function generateVariation($productId){
    //     $product = Product::with('optionValues', 'options', 'skus', 'variants')->where('id', $productId)->first();

    //     if(!$product){
    //         return response()->json([
    //             'status' => Response::HTTP_NOT_FOUND,
    //             'message' => trans('message.product_not_exists'),
    //         ], Response::HTTP_NOT_FOUND);
    //     }
    //     if($product->optionValues->isEmpty()){
    //         return response()->json([
    //             'status' => Response::HTTP_NOT_FOUND,
    //             'message' => trans('message.option_not_exists'),
    //         ], Response::HTTP_NOT_FOUND);
    //     }
    // //    dd($product->optionValues, $product->options);

    //     // dd($product->options, $product->optionValues);
    //     // $productOptions = ProductOption::with('optionValues')->where('product_id', $productId)->get();
    //     // dd($productOptions->optionValues);
    //     // dd($product->optionValues->groupBy('product_option_id')->values()->toArray());

    //     DB::beginTransaction();
    //     try{
    //         // foreach($productOptions as $productOption){
    //         //     if($productOption->optionValues->isNotEmpty()){
    //         //         dd($productOption->optionValues);
    //         //     }
    //         // }
    //         $input = $product->optionValues->groupBy('product_option_id')->values()->toArray();
    //         $result = [[]];

    //         foreach ($input as $key => $values) {
    //             $append = [];
    //             foreach ($values as $value) { 
    //                 foreach ($result as $data) {
    //                     $append[] = $data + [$key => $value];
    //                 }
    //             }
    //             $result = $append;
    //         }
    //         dd($result);

    //         // foreach($result as $skuItem){
    //         //     $productSku = ProductSku::create(['product_id' => $product->id]);
    //         //     foreach($skuItem as $variantItem){
    //         //         ProductVariant::create([
    //         //             'product_id' => $product->id,
    //         //             'product_option_id' => $variantItem['product_option_id'],
    //         //             'product_option_value_id' => $variantItem['id'],
    //         //             'sku_id' => $productSku->id,
    //         //         ]);
    //         //     }
    //         // }

    //         // if(!empty($productOptionValue)){
    //         //     if(count())
    //         // }

    //         DB::commit();
    //         return response()->json([
    //             'status' => Response::HTTP_OK,
    //             'message' => trans('message.remove_option_successed'),
    //         ], Response::HTTP_OK);
    //     }catch(Exception $e){
    //         Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
    //         DB::rollBack();
    //         return response()->json([
    //             'status' => Response::HTTP_NOT_FOUND,
    //             'message' => trans('message.option_not_found'),
    //         ], Response::HTTP_NOT_FOUND);
    //     }
    // }

    /**
     * update tyoe product
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTypeProduct(Request $request, $id){
        $product = Product::where('id', $id)->first();
        if(!$product){
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => trans('message.product_not_exists'),
            ], Response::HTTP_NOT_FOUND);
        }
        DB::beginTransaction();
        try{
            if(isset($request->product_type) && $request->product_type == Product::TYPE_VARIANT){
                $product->product_type = Product::TYPE_VARIANT;
            }else{
                $product->product_type = Product::TYPE_REGULAR;
            }
            $product->save();
            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('message.update_type_product_successed'),
            ], Response::HTTP_OK);
        }catch(Exception $e){
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => trans('message.server_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * destroy product
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        DB::beginTransaction();
        try{
            $product = Product::where('id', $id)->first();
            if(!$product){
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'msg' => trans('message.product_not_exists'),
                    'url_callback' => back()->getTargetUrl(),
                ], Response::HTTP_NOT_FOUND);
            }

            $product->delete();
            
            return response()->json([
                'message' => [
                    'title' => trans('language.success'),
                    'text' => trans('message.delete_product_successed'),
                ]
            ], Response::HTTP_OK);
        }catch(Exception $e){
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => trans('message.server_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
