<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * @var string
     */
    protected $pathView = 'Backend.Admin.';

    public function index(){
        $admin = Auth::guard('admin')->user();
        return view('');
    }
}
