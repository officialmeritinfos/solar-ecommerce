<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemSpecification extends Model
{
    protected $guarded = [];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function orderItem() {
        return $this->belongsTo(OrderItem::class);
    }

    public function specification() {
        return $this->belongsTo(ProductCheckoutSpecification::class, 'product_checkout_specification_id');
    }

}
