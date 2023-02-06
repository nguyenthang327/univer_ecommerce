<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ProductCategory extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'product_categories';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    /**
     * Save id admin created or updated
     */
    protected static function boot()
    {
        if(Auth::guard('admin')->user()->id){
            parent::boot();
            self::creating(function ($data) {
                $data->created_by_admin_id =  Auth::guard('admin')->user()->id;
            });
            self::saving (function ($data) {
                $data->updated_by_admin_id =  Auth::guard('admin')->user()->id;
            });
        }
    }

     /**
     * get 2 level categories from parent to child
     */
    public function _2LevelCate(){
        $columns = [
            'product_categories.id',
            'product_categories.name',
            'product_categories.thumbnail',
            'product_categories.parent_id',
            'product_categories.slug',
            'product_categories.created_by_admin_id',
            'product_categories.updated_by_admin_id',
            'product_categories.deleted_at',
        ];

        return $this->hasMany(ProductCategory::class, 'parent_id')->select(
                $columns
            );
    }

     /**
     * get all level categories from parent to child
     */
    public function _nLevelCate(){
        $columns = [
            'product_categories.id',
            'product_categories.name',
            'product_categories.thumbnail',
            'product_categories.parent_id',
            'product_categories.slug',
            'product_categories.created_by_admin_id',
            'product_categories.updated_by_admin_id',
        ];

        return $this->hasMany(ProductCategory::class, 'parent_id')->with(['_nLevelCate' => function($q1) use ($columns){
            $q1->select(
                $columns
            );
        }]);
    }
}
