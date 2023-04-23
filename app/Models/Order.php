<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sortable;

    const PAYMENT_CASH = 0; // cash on delivery
    const PAYMENT_PAYPAL = 1; // using paypal

    const STATUS_0 = 0; // đặt hàng thành công chờ giao hàng
    const STATUS_1 = 1; // đặt hàng thành công đã thanh toán chờ giao hàng
    const STATUS_2 = 2; // đang giao hàng chưa thanh toán
    const STATUS_3 = 3; // đang giao hàng đã thanh toán
    const STATUS_4 = 4; // giao hàng thành công
    const STATUS_5 = 5; // hủy đơn khi status = 0,1

    const STATUS_GROUP_0 = [self::STATUS_0, self::STATUS_2, self::STATUS_4, self::STATUS_5];
    const STATUS_GROUP_1 = [self::STATUS_1, self::STATUS_3, self::STATUS_4, self::STATUS_5];

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * get order detail by order
     */
    public function orderDetail(){
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

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
