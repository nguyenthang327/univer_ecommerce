<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerActivation extends Model
{
    use HasFactory;

    const NOT_COMPLETED = 0;
    const COMPLETED = 1;

    /**
     * @var string
     */
    protected $table = 'customer_activations';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

     /**
     * Save id user created or updated
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($data) {
            $data->created_at = Carbon::now();
            $data->updated_at = Carbon::now();
        });

        self::saving(function ($data) {
            $data->updated_at = Carbon::now();
        });
    }
}
