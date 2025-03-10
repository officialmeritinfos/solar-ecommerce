<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliatePayoutMethod extends Model
{
    protected $guarded = [];

    protected $casts = [
        'details' => 'array',
        'is_default' => 'boolean',
    ];

    // Belongs to an affiliate (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Has many payouts made with this method
    public function payouts()
    {
        return $this->hasMany(AffiliatePayout::class, 'payout_method_id');
    }
}
