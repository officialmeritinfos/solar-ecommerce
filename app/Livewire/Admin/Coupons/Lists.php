<?php

namespace App\Livewire\Admin\Coupons;

use App\Models\Coupon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Lists extends Component
{
    use WithPagination,LivewireAlert;

    #[Url]
    public $search = '';
    #[Url]
    public $status = 'all';
    #[Url]
    public $perPage = 10;

    public $selected = [];
    public $selectAll = false;


    public function render()
    {
        $coupons = Coupon::query()
            ->when($this->search, fn ($q) =>
            $q->where('code', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
            )
            ->when($this->status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($this->status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('is_active', 'desc') // Active ones first
            ->latest() // Then by latest created_at
            ->paginate($this->perPage);


        return view('livewire.admin.coupons.lists',[
            'coupons' => $coupons,
        ]);
    }
    public function activate($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = true;
        $coupon->save();

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Coupon activated.',
            'width' => '400',
        ]);
    }

    public function deactivate($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = false;
        $coupon->save();

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Coupon deactivated.',
            'width' => '400',
        ]);
    }

    public function deleteConfirm($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Coupon deleted.',
            'width' => '400',
        ]);
    }
    public function bulkDelete()
    {
        Coupon::whereIn('id', $this->selected)->delete();
        $this->reset('selected', 'selectAll');

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Selected coupons deleted.',
            'width' => '400',
        ]);
    }

    public function bulkActivate()
    {
        Coupon::whereIn('id', $this->selected)->update(['is_active' => true]);
        $this->reset('selected', 'selectAll');

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Selected coupons activated.',
            'width' => '400',
        ]);
    }

    public function bulkDeactivate()
    {
        Coupon::whereIn('id', $this->selected)->update(['is_active' => false]);
        $this->reset('selected', 'selectAll');

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Selected coupons deactivated.',
            'width' => '400',
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
