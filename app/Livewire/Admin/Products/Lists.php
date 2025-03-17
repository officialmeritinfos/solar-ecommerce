<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductCategory;
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
    public $perPage = 10;
    #[Url]
    public $status = 'all';
    #[Url]
    public $category = 'all';

    public $staff;
    public function mount()
    {
        $this->staff = auth()->user();
    }
    public function render()
    {
        $query = Product::when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%")
                ->orWhere('sku', 'like', "%{$this->search}%")
                ->orWhere('barcode', 'like', "%{$this->search}%");
        })->when($this->category!='all', function ($query) {
            $query->where('product_category_id', $this->category);
        })->when($this->status!='all', function ($query) {
            $query->where('status', $this->status);
        })->with('category')->orderBy('created_at', 'desc')->paginate($this->perPage);

        // Paginate results
        $products = $query;

        return view('livewire.admin.products.lists',[
            'categories' => ProductCategory::get(),
            'products' => $products,
        ]);
    }
    public function toggleFeatured($productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['featured' => !$product->featured]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Operation successful',
            'width' => '400',
        ]);
    }

    public function toggleActivation($productId)
    {
        $product = Product::findOrFail($productId);
        $newStatus = $product->status === 'active' ? 'inactive' : 'active';
        $product->update(['status' => $newStatus]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Operation successful',
            'width' => '400',
        ]);
    }

    public function deleteProduct($productId)
    {
        if ($this->staff->cannot('delete product')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You cannot delete this product',
                'width' => '400',
            ]);
            return;
        }
        $product = Product::findOrFail($productId);

        //check if there are orders tied to a product
        if ($product->orderItems->count() >0){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'There are orders that have this product. Please ',
                'width' => '400',
            ]);
            return;
        }

        $product->delete();

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Operation successful',
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
