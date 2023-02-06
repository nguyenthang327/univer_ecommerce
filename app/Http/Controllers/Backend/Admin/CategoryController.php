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

    public function index(Request $request){
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
            if($data[1]->parent_id){
                $cateAppend = ProductCategory::where('id', $data[1]->parent_id)->first();
                $data->prepend($cateAppend);
            }
        }

        $is_filter = "";
        return view($this->pathView . 'index', compact('is_filter', 'data'));
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
}
