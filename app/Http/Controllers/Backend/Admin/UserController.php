<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\UserService;
use App\Helpers\StringHelper;
use App\Models\User;
use Illuminate\Http\Response;
use App\Models\Language;
use App\Helpers\RequestHelper;

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


    /**
     * display user list
     * @param \Illuminate\Http\Request $request
     * @return View
     */
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

     /**
     * Check if user exist then return User, else return error message
     *
     * @param $user_id
     * @param bool $deleted
     * @return array|User
     */
    private function checkUserExist($user_id, $deleted=false) {
        if ($deleted) {
            $user = User::withTrashed()->find($user_id);
        } else {
            $user = User::find($user_id);
        }

        if ($user == null) {
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'msg' => trans('message.user_not_exist'),
                'url_callback' => back()->getTargetUrl(),
            ];
        }
        return $user;
    }

    public function edit($id){
        $user = $this->checkUserExist($id, true);
        
        // Return error message if user not exist
        if (!$user instanceof User) {
            dd((new RequestHelper())->parseRequestUri(url()->previous()));
            return back()->with([
                'status_failed' => isset($user['msg']) ? $user['msg'] : ''
            ]);
        }

        $deleted = false;
        // Check user deleted
        if ($user->deleted_at != null) {
            $deleted = true;
        }

        // Store redirect url in session
        if((new RequestHelper())->parseRequestUri(url()->previous()) == route('admin.user.index')) {
            session(['redirect.admin.user.edit' => url()->previous()]);
        }
        $languages = Language::select('id','name','display_name')->get();
        return view($this->pathView . 'edit', [
            'user' => $user,
            'deleted' => $deleted,
            'languages' => $languages,
        ]);
    }

    public function update(){

    }

    public function create(){

    }

    public function destroy(){

    }

    public function getAvatar(){

    }

}
