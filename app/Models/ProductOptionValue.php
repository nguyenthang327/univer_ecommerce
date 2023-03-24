<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'product_option_values';
   
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * get option by option value
     */
    public function option(){
        return $this->belongsTo(ProductOption::class);
    }

    /**
     * get variants by option value
     */
    public function variants(){
        return $this->hasMany(ProductVariant::class);
    }
}
