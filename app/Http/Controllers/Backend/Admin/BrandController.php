<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Logics\Admin\BrandManager;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    //
    const PER_PAGE = 12;

    protected $pathView = 'backend.admin.brand.';
    protected $brandManager;

    public function __construct(BrandManager $brandManager)
    {
        $this->brandManager = $brandManager;
    }

    public function index(Request $request){
        $brands =  $this->brandManager->getBrands($request);
        // Pagination
        $perPage = $request->has('per_page') ? $request->input('per_page') : self::PER_PAGE;
        $brands = $brands->paginate($perPage);

        // Redirect to last page if page parameter greater than last page
        if ($brands->lastPage() < $request->page) {
            return redirect($request->fullUrlWithQuery(['page' => $brands->lastPage()]));
        }
        // Redirect to first page if page parameter less than 0
        if ($request->page < 0) {
            return redirect($request->fullUrlWithQuery(['page' => 1]));
        }
        $is_filter = "";
        $fields = ['keyword'];

        foreach ($fields as $field){
            $tagSpanOpen = '<span class="badge badge-success">';
            $tagSpanClose = '</span>';
            $value = '';
            if ($request->has($field) && $request->$field!= null){
                switch ($field){
                    default:
                        $value = $tagSpanOpen.StringHelper::escapeHtml($request->$field) . $tagSpanClose;
                        break;
                }
                $is_filter.= $value;
            }
        }

        return view($this->pathView . 'index', ['brands' => $brands, 'is_filter' => $is_filter]);
    }

    public function store(BrandRequest $request){
        DB::beginTransaction();
        try{
            $params = [
                'name' => $request->brand_name,
            ];
            $this->brandManager->createBrand($params, $request->brand_logo ?? null);
            DB::commit();
            return redirect()->back()
                ->with([ 'status_successed' => trans('message.create_brand_successed')]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return redirect()->back()
                ->with([ 'status_failed' => trans('message.create_brand_failed')]);
        }
    }

    public function update(BrandRequest $request, $id){
        $brand = Brand::where('id', $id)->first();
        if(!$brand){
            return redirect()->back()
            ->with(['status_failed' => trans('message.brand_not_found')]);
        }

        DB::beginTransaction();
        try{
            $params = [
                'name' => $request->brand_name,
            ];
            $this->brandManager->updateBrand($brand, $params, $request->brand_logo ?? null);
            DB::commit();
            return redirect()->back()
                ->with(['status_successed' => trans('message.update_brand_successed')]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return redirect()->back()
                ->with([ 'status_failed' => trans('message.update_brand_failed')]);
        }
    }

    public function destroy($id){
        $brand = Brand::where('id', $id)->first();
        if(!$brand){
            return response()->json([
                'message' => [
                    'title' => trans('language.error'),
                    'text' => trans('message.delete_brand_failed'),
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        DB::beginTransaction();
        try{
            if($brand->logo && Storage::disk(FILESYSTEM)->exists($brand->logo)){
                Storage::disk(FILESYSTEM)->delete($brand->logo);
            }
            $brand->delete();
            DB::commit();
            return response()->json([
                'message' => [
                    'title' => trans('language.success'),
                    'text' => trans('message.delete_brand_successed'),
                ]
            ], Response::HTTP_OK);
            return redirect()->back()
                ->with(['status_successed' => trans('message.delete_brand_successed')]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error("File: ".$e->getFile().'---Line: '.$e->getLine()."---Message: ".$e->getMessage());
            return response()->json([
                'message' => [
                    'title' => trans('language.error'),
                    'text' => trans('message.server_error'),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
