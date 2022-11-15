<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @var string
     */
    protected $pathView = 'Backend.Admin.Dashboard.';

    public function index()
    {
        return view($this->pathView . 'index');
    }
}
