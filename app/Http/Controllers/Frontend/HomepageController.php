<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    //
    protected $pathView = 'frontend.homepage.';
    
    public function index(){
        return view($this->pathView . 'index');
    }
}
