<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $guarded = [];

    /**
     * Coupon associated with this usage.
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * User who used the coupon.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order the coupon was applied to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
