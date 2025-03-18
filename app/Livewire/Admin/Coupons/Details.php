<?php

namespace App\Livewire\Admin\Coupons;

use App\Models\Coupon;
use App\Models\CouponUsage;
use Livewire\Component;
use Livewire\WithPagination;

class Details extends Component
{
    use WithPagination;

    public $couponId;
    public $coupon;
    public $userId = '';
    public $orderId = '';
    public $ip = '';
    public $startDate = '';
    public $endDate = '';

    public function mount(Coupon $coupon)
    {
        $this->couponId = $coupon->id;
    }

    public function render()
    {
        $usages = CouponUsage::with(['coupon', 'user', 'order']) // ← Eager load relationships
        ->where('coupon_id', $this->couponId)
            ->when($this->userId, fn($q) => $q->where('user_id', $this->userId))
            ->when($this->orderId, fn($q) => $q->where('order_id', $this->orderId))
            ->when($this->ip, fn($q) => $q->where('ip_address', 'like', "%{$this->ip}%"))
            ->when($this->startDate, fn($q) => $q->whereDate('used_at', '>=', $this->startDate))
            ->when($this->endDate, fn($q) => $q->whereDate('used_at', '<=', $this->endDate))
            ->latest('used_at')
            ->paginate(10);

        return view('livewire.admin.coupons.details',[
            'usages' => $usages,
            'coupon' => $this->coupon
        ]);
    }
    public function placeholder()
    {
        return <<<'HTML'
        <div>
        <svg width="100%" height="100%" viewBox="0 0 500 200" preserveAspectRatio="none">
            <defs>
                <linearGradient id="table-skeleton-gradient">
                    <stop offset="0%" stop-color="#f0f0f0">
                        <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="50%" stop-color="#e0e0e0">
                        <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="100%" stop-color="#f0f0f0">
                        <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                </linearGradient>
            </defs>

            <!-- Table Header -->
            <rect x="10" y="10" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="10" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 1 -->
            <rect x="10" y="40" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="40" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 2 -->
            <rect x="10" y="70" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="70" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 3 -->
            <rect x="10" y="100" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="100" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
        </svg>

        </div>
        HTML;
    }
}
