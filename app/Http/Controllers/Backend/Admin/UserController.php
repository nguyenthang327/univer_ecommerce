<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\UserService;
use App\Helpers\StringHelper;

class UserController extends Controller
{

    const PER_PAGE = 10;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param \App\Services\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * @var string
     */
    protected $pathView = 'Backend.Admin.User.';

    public function index(Request $request){
        $users = $this->userService->getUserList($request);

        // Pagination
        $perPage = $request->has('per_page') ? $request->input('per_page') : self::PER_PAGE;
        $users = $users->sortable()->paginate($perPage);

        // Redirect to last page if page parameter greater than last page
        if ($users->lastPage() < $request->page) {
            return redirect($request->fullUrlWithQuery(['page' => $users->lastPage()]));
        }
        // Redirect to first page if page parameter less than 0
        if ($request->page < 0) {
            return redirect($request->fullUrlWithQuery(['page' => 1]));
        }

        $is_filter = "";
        $fields = ['id','keyword','email','phone','gender','address','birthday'];

        foreach ($fields as $field){
            $tagSpanOpen = '<span class="badge badge-success">';
            $tagSpanClose = '</span>';
            $value = '';
            if ($request->has($field) && $request->$field!= null){
                switch ($field){
                    case 'id':
                        $value = $tagSpanOpen."#".StringHelper::escapeHtml($request->id).$tagSpanClose;
                        break;
                    case 'gender':
                        foreach ($request->gender as $gender){
                            $value .= $tagSpanOpen . trans('language.genders')[$gender] . $tagSpanClose;
                        }
                        break;
                    default:
                        $value = $tagSpanOpen.StringHelper::escapeHtml($request->$field) . $tagSpanClose;
                        break;
                }
                $is_filter.= $value;
            }
        }

        return view($this->pathView . 'index', [
            'users' => $users,
            'is_filter'=> $is_filter,
        ]);
    }

    public function edit(){

    }

    public function create(){

    }

    public function destroy(){

    }

}
