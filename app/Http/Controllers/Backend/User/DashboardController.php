<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @var string
     */
    protected $pathView = 'backend.user.dashboard.';

    public function index()
    {
        return view($this->pathView . 'index');
    }
}
