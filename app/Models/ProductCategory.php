<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Model
{
    use HasFactory;
    use Sluggable;

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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Save id admin created or updated
     */
    protected static function boot()
    {
        parent::boot();
        if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->id){
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
            DB::raw('CONCAT_WS(" " , created.first_name, created.last_name) as created_name'),
            DB::raw('CONCAT_WS(" " , updated.first_name, updated.last_name) as updated_name'),
        ];

        return $this->hasMany(ProductCategory::class, 'parent_id')->select(
                $columns
            )
            ->leftJoin('admins as created','product_categories.created_by_admin_id', 'created.id')
            ->leftJoin('admins as updated','product_categories.updated_by_admin_id', 'updated.id');
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
