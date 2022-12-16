<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Models\ProductCategories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * @var string
     */
    protected $pathView = 'backend.admin.productCategory.';

    public function index(Request $request){
        $is_filter = "";
        return view($this->pathView . 'index', compact('is_filter'));
    }

    public function store(CreateCategoryRequest $request){
        DB::beginTransaction();
        try{
            ProductCategories::create([
                ''
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        dd($request);

    }
}
