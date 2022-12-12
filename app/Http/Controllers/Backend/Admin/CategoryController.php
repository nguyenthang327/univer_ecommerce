<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function create(){

    }
}
