<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\StringHelper;
use App\Models\User;
use Illuminate\Http\Response;
use App\Models\Language;
use App\Helpers\RequestHelper;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Logics\Admin\CustomerManager;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use App\Services\RandomPasswordService;

class CustomerController extends Controller
{

    const PER_PAGE = 10;
    // MIN LENGTH = 8
    const PASSWORD_LENGTH = 8;

    /**
     * @var CustomerManager
     */
    protected $customerManager;

    /**
     * @param \App\Logics\Admin\CustomerManager $customerManager
     */
    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
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
        $users = $this->customerManager->getUserList($request);

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
     * display form create user
     * @return View
     */
    public function create(){
        $languages = Language::select('id','name','display_name')->get();
        return view($this->pathView . 'create', compact('languages'));
    }

    /**
     * create new user
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request){
        DB::beginTransaction();
        try{
            $passwordService = new RandomPasswordService();
            $password = $passwordService->randomPassword(self::PASSWORD_LENGTH);
            $params = [
                'email' => $request->email,
                'user_name' => $request->user_name,
                'language_id' => $request->language_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => isset($request->birthday) ? Carbon::createFromFormat('d/m/Y', $request->birthday) : $request->birthday,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'prefecture_id' => $request->prefecture_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
                'identity_card' => $request->identity_card,
                'password' => bcrypt($password),
            ];
            $this->customerManager->createUserProfile($params, $request->avatar, $password);

            DB::commit();
            return back()->with([
                'status_successed' => trans('message.create_user_successed')
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.create_user_failed'),
            ]);
        }
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

    /**
     * display user info
     * @param $id
     * @return View
     */
    public function edit($id){
        $user = $this->checkUserExist($id, true);

        // Return error message if user not exist
        if (!$user instanceof User) {
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

    /**
     * update user infor
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id){
        $user = $this->checkUserExist($id, true);

        DB::beginTransaction();
        try{
            $params = [
                'email' => $request->email,
                'user_name' => $request->user_name,
                'language_id' => $request->language_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => isset($request->birthday) ? Carbon::createFromFormat('d/m/Y', $request->birthday) : $request->birthday,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'prefecture_id' => $request->prefecture_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
                'identity_card' => $request->identity_card,
            ];
            $this->customerManager->updateUserProfile($user, $params, $request->avatar);

            DB::commit();
            return back()->with([
                'status_successed' => trans('message.update_user_successed')
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return back()->with([
                'status_failed' => trans('message.update_user_failed'),
            ]);
        }
    }

    /**
     * Delete user
     *
     * @param int $id
     * @return User|array
     */
    public function destroy($id){
        $user = $this->checkUserExist($id);
        if (!$user instanceof User) {
            return $user;
        }
        $user->delete();
        
        return response()->json([
            'message' => [
                'title' => trans('language.success'),
                'text' => trans('message.delete_user_successed'),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function restore($id)
    {
        $user = $this->checkUserExist($id, true);

        // Return error message if user not exist
        if (!$user instanceof User) {
            return $user;
        }
        $user->restore();

        return response()->json([
            'message' => [
                'title' => trans('language.success'),
                'text' => trans('message.restore_user_successed'),
            ]
        ], Response::HTTP_OK);

    }

    /**
     * Get avatar user
     * @param $id
     * @return URL $image
     */
    public function getAvatar($id){
        $image = $this->customerManager->getImage($id, 'avatar');
        return $image;
    }

}
