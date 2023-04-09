<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Logics\Frontend\ProductManager;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomepageController extends Controller
{
    //
    protected $pathView = 'frontend.homepage.';

    protected $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }
    
    public function index(){
        $take = 12;
        $productFeature = $this->productManager->getProducts($take, 'is_featured');
        $productNew = $this->productManager->getProducts($take, 'new');

        return view($this->pathView . 'index', compact('productFeature', 'productNew'));
    }

     /**
     *  change language
     * 
     * @param string $locale
     * 
     * @return Response
     */ 
    public function changeLanguage($locale)
    {
        $languae = Language::where('name', $locale)->first();
        $type = 'vi';
        if($languae){
            $type = $languae->name;
        }
        App::setLocale($type);
        session()->put('locale', $type);
        // dd($type);
        return redirect()->back();

    } 
}
