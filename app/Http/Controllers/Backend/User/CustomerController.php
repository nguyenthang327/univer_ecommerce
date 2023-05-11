<?php

namespace App\Http\Controllers\Backend\User;

use App\Helpers\RequestHelper;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
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
    protected $pathView = 'backend.user.customer.';


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
     * Get avatar customer
     * @param $id
     * @return URL $image
     */
    public function getAvatar($id)
    {
        return $this->customerManager->getImage($id, 'avatar');
    }

}
