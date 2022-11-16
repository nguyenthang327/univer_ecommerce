<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon;

/**
 * Class Admin
 * @property integer $id
 * @property string $email
 * @property string $user_name
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property integer $gender
 * @property string $phone
 * @property string $identity_card
 * @property date $birthday
 * @property integer $prefecture_id
 * @property integer $district_id
 * @property integer $commune_id
 * @property integer $language_id
 * @property string $remember_token
 * @property timestamp $deleted_at
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property string $avatar
 */

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = [];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
