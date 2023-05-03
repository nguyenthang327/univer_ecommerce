<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sortable;

    const TYPE_REGULAR = 0;
    const TYPE_VARIANT = 1;

    const IS_NOT_FEATURE = 0;
    const IS_FEATURE = 1;

    const NOT_SELL = 0;
    const SELL = 1;

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
     * get categories by product
     */
    public function categories(){
        return $this->hasMany(ProductCateogryRelation::class);
    }

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

    /**
     * get sku by product
     */
    public function skus(){
        return $this->hasMany(ProductSku::class);
    }

    /**
     * get variants by product
     */
    public function variants(){
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * get product by product
     */
    public function productCategoryRelation(){
        return $this->hasMany(ProductCateogryRelation::class);
    }

    public static function generateVariant(array $input)
    {
        if (! count($input)) return [];

        $result = [[]];

        foreach ($input as $key => $values) {
            $append = [];
            foreach ($values as $value) {
                foreach ($result as $data) {
                    $append[] = $data + [$key => $value];
                }
            }
            $result = $append;
        }

        return $result;
    }

    public function saveVariant(array $variants)
    {
        $skus = $this->skus()->createMany(array_fill(0, count($variants), []));

        $variantOptions = [];

        foreach ($skus as $index => $sku) {
            foreach ($variants[$index] as $optionValue) {
                $variantOptions[] = [
                    'product_id' => $this->id,
                    'sku_id' => $sku->id,
                    'product_option_id' => $optionValue['product_option_id'],
                    'product_option_value_id' => $optionValue['id'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        $this->variants()->insert($variantOptions);
    }

    public function favoriteBycustomers()
    {
        return $this->belongsToMany(Customer::class, 'favorite_product')->withTimestamps();
    }
}
