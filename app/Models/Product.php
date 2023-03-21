<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
    ];

    /**
     * get options by product
     */
    public function options(){
        return $this->hasMany(ProductOption::class);
    }

    /**
     * get option values by product
     */
    public function optionValues(){
        return $this->hasMany(ProductOptionValue::class);
    }
}
