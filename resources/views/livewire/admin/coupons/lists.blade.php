<div>
    <div class="d-flex align-items-center mb-3">
        <div class="row mb-3 g-2">
            <div class=" col-md-3">
                <input type="text" class="form-control" placeholder="Search coupon..." wire:model.live.debounce.500ms="search">

            </div>
            <div class=" col-md-3">
                <select class="form-select"  wire:model.live.debounce.500ms="status">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class=" col-md-3">
                <select class="form-select"  wire:model.live.debounce.500ms="perPage">
                    <option>5</option>
                    <option>10</option>
                    <option>15</option>
                    <option>20</option>
                    <option>50</option>
                    <option>75</option>
                    <option>100</option>
                    <option>200</option>
                </select>
            </div>

            <div class="col-md-3">
                @can('create coupon')
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus-circle me-1"></i>
                        Create New Coupon
                    </a>
                    <button class="btn btn-sm btn-primary">
                        <span wire:loading.remove></span>
                        <span wire:loading>Please wait...</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>
    <!-- Bulk Actions -->
    @if (count($selected) > 0)
        <div class="mb-3">
            <div class="d-flex gap-2">
                <button wire:click="bulkActivate" class="btn btn-sm btn-success">Activate Selected</button>
                <button wire:click="bulkDeactivate" class="btn btn-sm btn-warning">Deactivate Selected</button>
                <button wire:click="bulkDelete" class="btn btn-sm btn-danger">Delete Selected</button>
            </div>
        </div>
    @endif

    <div class="table-responsive">

        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
            <tr>
                <th>
                    <input type="checkbox" wire:model.live.debounce.300ms="selectAll" wire:click="$set('selected', {{ json_encode($coupons->pluck('id')) }})">
                </th>
                <th>#</th>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min Order</th>
                <th>Usage Limit</th>
                <th>Status</th>
                <th>Valid From</th>
                <th>Valid To</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($coupons as $index => $coupon)
                <tr>
                    <td>
                        <input type="checkbox" wire:model.live.debounce.300ms="selected" value="{{ $coupon->id }}">
                    </td>
                    <td>{{ $loop->iteration + ($coupons->currentPage() - 1) * $coupons->perPage() }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-semibold">{{ $coupon->code }}</span>
                            <button class="btn btn-sm btn-outline-secondary copy-btn" data-code="{{ $coupon->code }}" title="Copy code">
                                <i class="fa fa-clipboard"></i>
                            </button>
                        </div>
                    </td>
                    <td>{{ ucfirst($coupon->discount_type) }}</td>
                    <td>
                        {{ $coupon->discount_type === 'percent' ? $coupon->discount_value . '%' : getCurrencySign() . number_format($coupon->discount_value, 2) }}
                    </td>
                    <td>{{ $coupon->min_order_amount ? getCurrencySign() . number_format($coupon->min_order_amount, 2) : '—' }}</td>
                    <td>
                        {{ $coupon->usage_limit ?? '∞' }}
                    </td>
                    <td>
                            <span class="badge bg-{{ $coupon->is_active ? 'success' : 'secondary' }}">
                                {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                            </span>
                    </td>
                    <td>{{ $coupon->start_date ? date('Y-m-d',strtotime($coupon->start_date)) : '—' }}</td>
                    <td>{{ $coupon->end_date ? date('Y-m-d',strtotime($coupon->end_date)) : '—' }}</td>
                    <td>{{ $coupon->created_at->format('Y-m-d') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.coupons.details',$coupon->id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                            @if (!$coupon->is_active)
                                <button class="btn btn-sm btn-success" wire:click="activate({{ $coupon->id }})" title="Activate">
                                    <i class="fa fa-check-circle"></i>
                                </button>
                            @else
                                <button class="btn btn-sm btn-warning" wire:click="deactivate({{ $coupon->id }})" title="Deactivate">
                                    <i class="fa fa-xmark-circle"></i>
                                </button>
                            @endif

                            <button class="btn btn-sm btn-danger" wire:click="deleteConfirm({{ $coupon->id }})" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">No coupons found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $coupons->links() }}
    </div>
</div>

