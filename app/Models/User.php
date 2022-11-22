<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

/**
 * Class Admin
 * @property integer $id
 * @property string $email
 * @property string $avatar
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
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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

     /**
     * Get the prefecture for the user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prefecture()
    {
        return $this->belongsTo('App\Models\Prefecture');
    }

    /**
     * Get the district for the user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    /**
     * Get the commune for the user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commune()
    {
        return $this->belongsTo('App\Models\Commune');
    }
}
