<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    /**
    * Get all districts of the prefecture
    *
    * @param $prefecture_id
    * @return array
    */
   public function getDistrictList(Request $request) {
       $prefecture_id = $request->id;
       $districts = District::where('prefecture_id', $prefecture_id)->orderBy('name')->get();
       $options = [];
       foreach ($districts as $district) {
           $options[] = [
               'value' => $district->id,
               'text' => $district->name
           ];
       }

       return [
         'status' => Response::HTTP_OK,
         'options' => $options
       ];
   }

   /**
    * Get all communes of the district
    *
    * @param $district_id
    * @return array
    */
   public function getCommuneList(Request $request) {
       $district_id = $request->id;
       $communes = Commune::where('district_id', $district_id)->orderBy('name')->get();

       $options = [];
       foreach ($communes as $commune) {
           $options[] = [
               'value' => $commune->id,
               'text' => $commune->name
           ];
       }

       return [
           'status' => Response::HTTP_OK,
           'options' => $options
       ];
   }
}
