<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Models\ProductCategory;
use App\Services\Admin\CategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * @var \App\Services\Admin\CategoryService $categoryService
     */
    protected $categoryService;

    /**
     * @param \App\Services\Admin\CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @var string
     */
    protected $pathView = 'backend.admin.productCategory.';

    public function index(Request $request){
        $is_filter = "";
        return view($this->pathView . 'index', compact('is_filter'));
    }

    public function create(){
        $parentCategory = ProductCategory::whereNull('parent_id')->pluck('name', 'id');
        return view($this->pathView . 'create', compact('parentCategory'));
    }

    public function store(CreateCategoryRequest $request){
        DB::beginTransaction();
        try{
            $params = [
                'name' => $request->category_name,
                'parent_id' => $request->category_parent_id,
            ];
            $this->categoryService->createProductCategory($params, $request->thumbnail);

            DB::commit();
            return back()->with([
                'status_successed' => trans('message.create_category_successed')
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.create_category_failed'),
            ]);
        }

    }
}
