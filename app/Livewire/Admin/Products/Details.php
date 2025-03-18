<?php

namespace App\Livewire\Admin\Products;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductPhoto;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Details extends Component
{
    use WithPagination,LivewireAlert;

    public Product $product;
    public $perPage = 10;
    #[Url]
    public $tab = 'overview';

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function deletePhoto($photoId)
    {
        $photo = ProductPhoto::findOrFail($photoId);
        if (file_exists(public_path($photo->path))) {
            unlink(public_path($photo->path)); // Delete from filesystem
        }
        $photo->delete();

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Photo deleted successfully.',
            'width' => '400',
        ]);
    }

    public function render()
    {
        $orders = OrderItem::with(['order.user'])
            ->where('product_id', $this->product->id)
            ->latest()
            ->paginate($this->perPage);
        $totalOrders = OrderItem::with(['order.user'])
            ->where('product_id', $this->product->id)
            ->latest()
            ->get()->count();

        $customers = $orders->pluck('order.user')->unique('id')->filter();
        $photos = $this->product->photos;

        return view('livewire.admin.products.details',[
            'orders' => $orders,
            'customers' => $customers,
            'photos' => $photos,
            'totalOrders'=>$totalOrders
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
