<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponStoreRequest;
use App\Logics\Admin\CouponManager;
use App\Models\Coupon;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    const PER_PAGE = 12;

    private $couponManager;

    /**
     * @param \App\Logics\Admin\CouponManager $couponManager
     */
    public function __construct(CouponManager $couponManager)
    {
        $this->couponManager = $couponManager;
    }
    
    /**
     * @var string
     */
    protected $pathView = 'backend.admin.coupon.';


    /**
     * display user list
     * @param \Illuminate\Http\Request $request
     * @return View
     */
    public function index(Request $request){
        $coupons = $this->couponManager->getCouponList($request);

        // Pagination
        $perPage = $request->has('per_page') ? $request->input('per_page') : self::PER_PAGE;
        $coupons = $coupons->sortable()->paginate($perPage);

        // Redirect to last page if page parameter greater than last page
        if ($coupons->lastPage() < $request->page) {
            return redirect($request->fullUrlWithQuery(['page' => $coupons->lastPage()]));
        }
        // Redirect to first page if page parameter less than 0
        if ($request->page < 0) {
            return redirect($request->fullUrlWithQuery(['page' => 1]));
        }

        $is_filter = "";
        $fields = ['keyword','discount'];

        foreach ($fields as $field){
            $tagSpanOpen = '<span class="badge badge-success">';
            $tagSpanClose = '</span>';
            $value = '';
            if ($request->has($field) && $request->$field!= null){
                switch ($field){
                    case 'id':
                        $value = $tagSpanOpen."#".StringHelper::escapeHtml($request->id).$tagSpanClose;
                        break;
                    default:
                        $value = $tagSpanOpen.StringHelper::escapeHtml($request->$field) . $tagSpanClose;
                        break;
                }
                $is_filter.= $value;
            }
        }

        return view($this->pathView . 'index', [
            'coupons' => $coupons,
            'is_filter'=> $is_filter,
        ]);
    }

    public function create(){
        return view($this->pathView . 'create');
    }

    public function store(CouponStoreRequest $request){
        DB::beginTransaction();
        try{
            $params = [
                'code' => $request->code,
                'discount_percentage' => $request->discount,
                'quantity' => $request->quantity,
                'started_at' => isset($request->started_at) ? Carbon::createFromFormat('d/m/Y', $request->started_at) : $request->started_at,
                'ended_at' => isset($request->ended_at) ? Carbon::createFromFormat('d/m/Y', $request->ended_at) : $request->ended_at,
            ];
            Coupon::create($params);
            DB::commit();
            return redirect()->route('admin.coupon.index')
                ->with([ 'status_successed' => trans('message.create_coupon_successed')]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return redirect()->back()
                ->with([ 'status_failed' => trans('message.create_coupon_failed')]);
        }
    }

    public function edit($id){
        $coupon = Coupon::where('id', $id)->first();
        if(!$coupon){
            return redirect()->back()
                ->with([ 'status_failed' => trans('message.coupon_not_found')]);
        }
        return view($this->pathView . 'edit', compact('coupon'));
    }

    public function update(CouponStoreRequest $request, $id){
        $coupon = Coupon::where('id', $id)->first();
        if(!$coupon){
            return redirect()->back()
                ->with([ 'status_failed' => trans('message.coupon_not_found')]);
        }
        DB::beginTransaction();
        try{
            $params = [
                'code' => $request->code,
                'discount_percentage' => $request->discount,
                'quantity' => $request->quantity,
                'started_at' => isset($request->started_at) ? Carbon::createFromFormat('d/m/Y', $request->started_at) : $request->started_at,
                'ended_at' => isset($request->ended_at) ? Carbon::createFromFormat('d/m/Y', $request->ended_at) : $request->ended_at,
            ];
            Coupon::where('id', $id)->update($params);
            DB::commit();
            return redirect()->back()
                ->with([ 'status_successed' => trans('message.create_coupon_successed')]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return redirect()->back()
                ->with([ 'status_failed' => trans('message.create_coupon_failed')]);
        }
    }

    /**
     * Delete coupon
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $coupon = Coupon::where('id', $id)->first();
        if(!$coupon){
            return response()->json([
                'message' => [
                    'title' => trans('language.success'),
                    'text' => trans('message.delete_coupon_successed'),
                ]
            ], Response::HTTP_NOT_FOUND);
        }
        $coupon->forceDelete();
        
        return response()->json([
            'message' => [
                'title' => trans('language.success'),
                'text' => trans('message.delete_coupon_successed'),
            ]
        ], Response::HTTP_OK);
    }
    
}
