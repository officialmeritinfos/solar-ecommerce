<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateEarning extends Model
{
    protected $guarded = [];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function affiliate()
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }

}
