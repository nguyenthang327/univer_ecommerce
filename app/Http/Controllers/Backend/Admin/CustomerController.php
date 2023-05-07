<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Helpers\RequestHelper;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCustomerRequest;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Logics\Admin\CustomerManager;
use App\Models\Customer;
use App\Models\Language;
use App\Models\User;
use App\Services\RandomPasswordService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    protected $pathView = 'Backend.Admin.Customer.';


    /**
     * display customers list
     * @param \Illuminate\Http\Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $customers = $this->customerManager->getCustomerList($request);

        // Pagination
        $perPage = $request->has('per_page') ? $request->input('per_page') : self::PER_PAGE;
        $customers = $customers->sortable()->paginate($perPage);

        // Redirect to last page if page parameter greater than last page
        if ($customers->lastPage() < $request->page) {
            return redirect($request->fullUrlWithQuery(['page' => $customers->lastPage()]));
        }
        // Redirect to first page if page parameter less than 0
        if ($request->page < 0) {
            return redirect($request->fullUrlWithQuery(['page' => 1]));
        }

        $is_filter = "";
        $fields = ['id', 'keyword', 'email', 'phone', 'gender', 'address', 'birthday'];

        foreach ($fields as $field) {
            $tagSpanOpen = '<span class="badge badge-success">';
            $tagSpanClose = '</span>';
            $value = '';
            if ($request->has($field) && $request->$field != null) {
                switch ($field) {
                    case 'id':
                        $value = $tagSpanOpen . "#" . StringHelper::escapeHtml($request->id) . $tagSpanClose;
                        break;
                    case 'gender':
                        foreach ($request->gender as $gender) {
                            $value .= $tagSpanOpen . trans('language.genders')[$gender] . $tagSpanClose;
                        }
                        break;
                    default:
                        $value = $tagSpanOpen . StringHelper::escapeHtml($request->$field) . $tagSpanClose;
                        break;
                }
                $is_filter .= $value;
            }
        }

        return view($this->pathView . 'index', [
            'customers' => $customers,
            'is_filter' => $is_filter,
        ]);
    }

    /**
     * display form create customer
     * @return View
     */
    public function create()
    {
        $languages = Language::select('id', 'name', 'display_name')->get();
        return view($this->pathView . 'create', compact('languages'));
    }

    /**
     * create new customer
     * @param CreateCustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCustomerRequest $request)
    {
        DB::beginTransaction();
        try {
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
                'password' => bcrypt($password),
            ];
            $this->customerManager->createCustomerProfile($params, $request->avatar, $password);

            DB::commit();
            return back()->with([
                'status_successed' => trans('message.create_customer_successed')
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return back()->with([
                'status_failed' => trans('message.create_customer_failed'),
            ]);
        }
    }

    /**
     * Check if customer exist then return Customer, else return error message
     *
     * @param $customer_id
     * @param bool $deleted
     * @return array|User
     */
    private function checkCustomerExist($customer_id, $deleted = false)
    {
        if ($deleted) {
            $customer = Customer::withTrashed()->find($customer_id);
        } else {
            $customer = Customer::find($customer_id);
        }

        if ($customer == null) {
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'msg' => trans('message.customer_not_exist'),
                'url_callback' => back()->getTargetUrl(),
            ];
        }
        return $customer;
    }

    /**
     * display customer info
     * @param $id
     * @return View
     */
    public function edit($id)
    {
        $customer = $this->checkCustomerExist($id, true);

        // Return error message if customer not exist
        if (!$customer instanceof Customer) {
            return back()->with([
                'status_failed' => isset($customer['msg']) ? $customer['msg'] : ''
            ]);
        }

        $deleted = false;
        // Check customer deleted
        if ($customer->deleted_at != null) {
            $deleted = true;
        }

        // Store redirect url in session
        if ((new RequestHelper())->parseRequestUri(url()->previous()) == route('admin.customer.index')) {
            session(['redirect.admin.customer.edit' => url()->previous()]);
        }
        $languages = Language::select('id', 'name', 'display_name')->get();
        return view($this->pathView . 'edit', [
            'customer' => $customer,
            'deleted' => $deleted,
            'languages' => $languages,
        ]);
    }

    /**
     * update customer info
     * @param UpdateCustomerRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = $this->checkCustomerExist($id, true);

        DB::beginTransaction();
        try {
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
            ];
            $this->customerManager->updateCustomerProfile($customer, $params, $request->avatar);

            DB::commit();
            return back()->with([
                'status_successed' => trans('message.update_customer_successed')
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return back()->with([
                'status_failed' => trans('message.update_customer_failed'),
            ]);
        }
    }

    /**
     * Delete customer
     *
     * @param int $id
     * @return User|array
     */
    public function destroy($id)
    {
        $customer = $this->checkCustomerExist($id);
        if (!$customer instanceof Customer) {
            return $customer;
        }
        $customer->delete();

        return response()->json([
            'message' => [
                'title' => trans('language.success'),
                'text' => trans('message.delete_customer_successed'),
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
        $customer = $this->checkCustomerExist($id, true);

        // Return error message if customer not exist
        if (!$customer instanceof Customer) {
            return $customer;
        }
        $customer->restore();

        return response()->json([
            'message' => [
                'title' => trans('language.success'),
                'text' => trans('message.restore_customer_successed'),
            ]
        ], Response::HTTP_OK);

    }

    /**
     * Get avatar customer
     * @param $id
     * @return URL $image
     */
    public function getAvatar($id)
    {
        $image = $this->customerManager->getImage($id, 'avatar');
        return $image;
    }

}
