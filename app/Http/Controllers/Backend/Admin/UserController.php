<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @var AdminService
     */
    protected $adminService;

    /**
     * @param \App\Services\AdminService $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    
    /**
     * @var string
     */
    protected $pathView = 'Backend.Admin.Profile.';

}
