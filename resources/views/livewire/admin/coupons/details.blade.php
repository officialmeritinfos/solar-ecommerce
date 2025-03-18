<div>
    <h5 class="mb-3">Coupon Usage Logs</h5>

    <!-- Filters -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" wire:model.debounce.500ms="ip" class="form-control" placeholder="Search IP">
        </div>
        <div class="col-md-3">
            <input type="text" wire:model="userId" class="form-control" placeholder="User ID">
        </div>
        <div class="col-md-3">
            <input type="text" wire:model="orderId" class="form-control" placeholder="Order ID">
        </div>
        <div class="col-md-3 d-flex gap-2">
            <input type="date" wire:model="startDate" class="form-control" placeholder="From">
            <input type="date" wire:model="endDate" class="form-control" placeholder="To">
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Order</th>
                <th>Discount</th>
                <th>IP Address</th>
                <th>User Agent</th>
                <th>Used At</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($usages as $index => $usage)
                <tr>
                    <td>{{ $loop->iteration + ($usages->currentPage() - 1) * $usages->perPage() }}</td>
                    <td>{{ $usage->user?->name ?? '—' }} (ID: {{ $usage->user->user_reference ?? 'N/A' }})</td>
                    <td>{{ $usage->order?->order_reference ?? '—' }}</td>
                    <td>{{ getCurrencySign() }}{{ number_format($usage->discount_applied, 2) }}</td>
                    <td>{{ $usage->ip_address ?? '—' }}</td>
                    <td class="text-break" style="max-width: 300px;">{{ Str::limit($usage->user_agent, 100) }}</td>
                    <td>{{ \Carbon\Carbon::parse($usage->used_at)->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No usage records found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $usages->links() }}
    </div>
</div>
