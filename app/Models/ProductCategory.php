<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
}
