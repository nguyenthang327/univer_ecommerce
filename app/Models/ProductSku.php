<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    use HasFactory;

     /**
     * @var string
     */
    protected $table = 'product_skus';
   
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * get product by sku
     */
    public function product(){
        return $this->belongsTo(Product::class);
    }

    /**
     * get variants by sku
     */
    public function variants(){
        return $this->hasMany(ProductVariant::class);
    }

}
