<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Logics\User\ProductManager;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        return view($this->pathView. 'edit', compact('product'));
    }

    public function option(Request $request){
        dd($request->all());
        // $product = Product::where('slug', $slug)->first();
        // if(!$product){
        //     abort(Response::HTTP_NOT_FOUND);
        // }
        // return view($this->pathView. 'edit', compact('product'));
    }
}
