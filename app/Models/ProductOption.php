<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'product_options';
   
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * get option values by option
     */
    public function optionValues(){
        return $this->hasMany(ProductOptionValue::class);
    }
}
