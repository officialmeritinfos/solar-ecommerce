<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySubLocation extends Model
{
    use HasFactory;

    protected $table = 'delivery_sub_locations';

    protected $fillable = ['delivery_location_id', 'name', 'delivery_price','is_active'];

    // Relationship: A sub-location belongs to a delivery location
    public function mainLocation()
    {
        return $this->belongsTo(DeliveryLocation::class, 'delivery_location_id');
    }
}
