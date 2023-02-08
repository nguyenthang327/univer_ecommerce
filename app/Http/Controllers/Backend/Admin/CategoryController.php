<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Models\ProductCategory;
use App\Logics\Admin\CategoryManager;
use App\Services\FlattenService;
use App\Services\PaginateService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    const PER_PAGE = 10;

    /**
     * @var \App\Logics\Admin\CategoryManager $categoryManager
     */
    protected $categoryManager;

    /**
     * @param \App\Logics\Admin\CategoryManager $categoryManager
     */
    public function __construct(CategoryManager $categoryManager)
    {
        $this->categoryManager = $categoryManager;
    }

    /**
     * @var string
     */
    protected $pathView = 'backend.admin.productCategory.';

    /**
     * show all product category
     * @param \Illuminate\Http\Request $request
     * @return View
     */
    public function index(Request $request){
        $columns = [
            'product_categories.id',
            'product_categories.name',
            'product_categories.thumbnail',
            'product_categories.parent_id',
            'product_categories.slug',
            'product_categories.created_by_admin_id',
            'product_categories.updated_by_admin_id',
            'product_categories.deleted_at',
            DB::raw('CONCAT_WS(" " , created.first_name, created.last_name) as created_name'),
            DB::raw('CONCAT_WS(" " , updated.first_name, updated.last_name) as updated_name'),
        ];

        $categories = $this->categoryManager->getProductCategories();

        $flattenService = new FlattenService();
        $arrCategories = $flattenService->arrFlatten($categories);

        $data = new Collection();
        foreach($arrCategories as $item){
            $data->push((object)$item);
        }
        $paginateService = new PaginateService();
        $path = route('admin.productCategory.index');
        $data = $paginateService->paginate($data, self::PER_PAGE, isset($params['page'])?$params['page']:null, ['path'=> $path] );

        if(!$request->all() && count($data) > 0){
            if($data[0]->parent_id){
                $cateAppend = ProductCategory::select($columns)
                    ->leftJoin('admins as created','product_categories.created_by_admin_id', 'created.id')
                    ->leftJoin('admins as updated','product_categories.updated_by_admin_id', 'updated.id')
                    ->where('product_categories.id', $data[1]->parent_id)
                    ->first();
                $data->prepend($cateAppend);
            }
        }

        $is_filter = "";
        return view($this->pathView . 'index', compact('is_filter', 'data'));
    }

    /**
     * show view create product category
     * @return View
     */
    public function create(){
        $parentCategory = ProductCategory::whereNull('parent_id')->pluck('name', 'id');
        return view($this->pathView . 'create', compact('parentCategory'));
    }

    /**
     * store new product category
     * @param \App\Http\Requests\Admin\CreateCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCategoryRequest $request){
        DB::beginTransaction();
        try{
            $params = [
                'name' => $request->category_name,
                'parent_id' => $request->category_parent_id,
            ];
            $this->categoryManager->createProductCategory($params, $request->thumbnail);

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

    /**
     * edit product category
     * @return View
     */
    public function edit(ProductCategory $category){
        $parentCategory = ProductCategory::whereNull('parent_id')
            ->where('slug', '<>', $category->slug)
            ->pluck('name', 'id');
        return view($this->pathView . 'edit', compact('parentCategory', 'category'));
    }

    /**
     * store new product category
     * @param \App\Http\Requests\Admin\CreateCategoryRequest $request
     * 
     */
    public function update(CreateCategoryRequest $request){
        dd(1);
        DB::beginTransaction();
        try{
            $params = [
                'name' => $request->category_name,
                'parent_id' => $request->category_parent_id,
            ];

            // dd($category);
            
            // $this->categoryManager->updateProductCategory($category, $params, $request->thumbnail);

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
