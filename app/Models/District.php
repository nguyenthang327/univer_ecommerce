<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class District
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $prefecture_id
 */
class District extends Model
{
    public $timestamps = false;

    protected $table = 'districts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
    ];

    /**
     * Get admins for the district
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admins()
    {
    	return $this->hasMany('App\Admin');
    }

     /**
     * Get users for the district
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
    	return $this->hasMany('App\User');
    }
}
