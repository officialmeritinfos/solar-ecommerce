<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;


    protected $guarded = [];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function productCheckoutSpecifications()
    {
        return $this->hasMany(ProductCheckoutSpecification::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_product');
    }

}
