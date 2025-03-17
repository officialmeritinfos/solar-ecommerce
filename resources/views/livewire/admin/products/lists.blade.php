<div>
    <!-- Filters & Search -->
    <div class="row mb-4">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Search products..." wire:model.live.debounce.300ms="search">
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live.debounce.300ms="category">
                <option value="all">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live.debounce.300ms="status">
                <option value="all">All Status</option>
                <option value="draft">Draft</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="archived">Archived</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live.debounce.300ms="perPage">
                <option value="10">10 per page</option>
                <option value="20">20 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.product.create') }}"  class="btn btn-sm btn-primary">
                <span wire:loading.remove> + Add Product</span>
                <span wire:loading>Please wait...</span>
            </a>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td>
                                <del> {{ getCurrencySign() }} {{ number_format($product->price, 2) }}</del>
                                {{ getCurrencySign() }}{{ number_format($product->sale_price, 2) }}
                            </td>
                            <td>
                                    <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                            </td>
                            <td>
                                @if($product->featured)
                                    <span class="badge bg-primary">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.product.details', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-primary" wire:click="toggleFeatured({{ $product->id }})">
                                    <i class="fa {{ $product->featured ? 'fa-star' : 'fa-star-o' }}"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" wire:click="toggleActivation({{ $product->id }})">
                                    <i class="fas fa-toggle-{{ $product->status == 'active' ? 'on' : 'off' }}"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" wire:click="deleteProduct({{ $product->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
