<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

     /**
     * @var string
     */
    protected $table = 'product_variants';
   
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * get option by variant
     */
    public function option(){
        return $this->belongsTo(ProductOption::class);
    }

    /**
     * get option value by variant
     */
    public function optionValue(){
        return $this->belongsTo(ProductOptionValue::class, 'product_option_value_id');
    }

    /**
     * get product value by variant
     */
    public function product(){
        return $this->belongsTo(Product::class);
    }

    /**
     * get sku value by variant
     */
    public function sku(){
        return $this->belongsTo(ProductSku::class);
    }

}
