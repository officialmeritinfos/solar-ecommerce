<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryLocation extends Model
{
    use HasFactory;

    protected $fillable = ['name','is_active'];

    // Relationship: A delivery location has many sub-locations
    public function subLocations()
    {
        return $this->hasMany(DeliverySubLocation::class);
    }
}
