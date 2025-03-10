<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliatePayout extends Model
{
    protected $guarded = [];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    // Belongs to an affiliate (user)
    public function affiliate()
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    // Belongs to a payout method
    public function payoutMethod()
    {
        return $this->belongsTo(AffiliatePayoutMethod::class, 'payout_method_id');
    }
}
