<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;


    protected $guarded = [];

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function productCheckoutSpecifications(): HasMany
    {
        return $this->hasMany(ProductCheckoutSpecification::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'coupon_product');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    // Optional: get primary image
    public function primaryPhoto(): HasOne
    {
        return $this->hasOne(ProductPhoto::class)->where('is_primary', true);
    }

    //order items
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class,'product_id');
    }

    public function getTagsAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

}
