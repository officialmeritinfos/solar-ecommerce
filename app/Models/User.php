<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\GenerateRecoveryCode;
use App\GeneratesUniqueId;
use App\UserTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, GeneratesUniqueId, GenerateRecoveryCode,UserTrait, HasRoles,SoftDeletes;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function google2faSecret(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  decrypt($value),
            set: fn ($value) =>  encrypt($value),
        );
    }

    protected function recoveryCode(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Crypt::decryptString($value),
            set: fn ($value) => Crypt::encryptString($value),
        );
    }

    /**
     * Boot method to automatically generate `user_reference` on creation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->user_reference = $user->generateUniqueId('users', 'user_reference', 7);
            $user->recovery_code = $user->generateRecoveryCode();
        });
    }
    public function activityLogs()
    {
        return $this->hasMany(StaffActivityLog::class);
    }

    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function affiliateEarnings()
    {
        return $this->hasMany(AffiliateEarning::class, 'affiliate_id');
    }

    // An affiliate can have many payout methods
    public function payoutMethods()
    {
        return $this->hasMany(AffiliatePayoutMethod::class, 'user_id');
    }

    // An affiliate can have many payout requests
    public function affiliatePayouts()
    {
        return $this->hasMany(AffiliatePayout::class, 'affiliate_id');
    }

}
