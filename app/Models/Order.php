<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * The customer who placed the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The coupon applied to this order (if any)
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * The delivery sub-location this order will be sent to (if applicable)
     */
    public function deliverySubLocation()
    {
        return $this->belongsTo(DeliverySubLocation::class);
    }

    /**
     * The list of items purchased in the order
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Track coupon usage on this order
     */
    public function couponUsage()
    {
        return $this->hasOne(CouponUsage::class);
    }

    /**
     * Get full billing address as attribute (optional helper)
     */
    public function getFullBillingAddressAttribute()
    {
        return "{$this->billing_name}, {$this->billing_address}, {$this->billing_phone}";
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function affiliate()
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    public function affiliateEarning()
    {
        return $this->belongsTo(AffiliateEarning::class, 'affiliate_earning_id');
    }

}
