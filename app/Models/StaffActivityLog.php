<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'description', 'ip_address', 'user_agent'
    ];

    /**
     * Get the user (staff) who performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
