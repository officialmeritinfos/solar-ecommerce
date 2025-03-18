@extends('admin.layout.base')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <a href="{{ route('admin.coupons.index') }}" class="btn btn-sm btn-secondary mb-4">← Back to Coupons</a>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Coupon Details</h5>
                <span class="badge bg-{{ $coupon->is_active ? 'success' : 'secondary' }}">
                {{ $coupon->is_active ? 'Active' : 'Inactive' }}
            </span>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Code</dt>
                    <dd class="col-sm-9">{{ $coupon->code }}</dd>

                    <dt class="col-sm-3">Discount Type</dt>
                    <dd class="col-sm-9 text-capitalize">{{ $coupon->discount_type }}</dd>

                    <dt class="col-sm-3">Discount Value</dt>
                    <dd class="col-sm-9">
                        {{ $coupon->discount_type === 'percent'
                            ? $coupon->discount_value . '%'
                            : getCurrencySign() . number_format($coupon->discount_value, 2) }}
                    </dd>

                    @if ($coupon->max_discount)
                        <dt class="col-sm-3">Max Discount</dt>
                        <dd class="col-sm-9">{{ getCurrencySign() }}{{ number_format($coupon->max_discount, 2) }}</dd>
                    @endif

                    @if ($coupon->min_order_amount)
                        <dt class="col-sm-3">Minimum Order</dt>
                        <dd class="col-sm-9">{{ getCurrencySign() }}{{ number_format($coupon->min_order_amount, 2) }}</dd>
                    @endif

                    <dt class="col-sm-3">Usage Limit</dt>
                    <dd class="col-sm-9">{{ $coupon->usage_limit ?? '∞' }}</dd>

                    <dt class="col-sm-3">Per User Limit</dt>
                    <dd class="col-sm-9">{{ $coupon->usage_limit_per_user ?? '∞' }}</dd>


                    @if ($coupon->products && $coupon->is_product_specific)
                        <dt class="col-sm-3">Applies to Products</dt>
                        <dd class="col-sm-9">
                            <ul class="mb-0 ps-3">
                                @foreach ($coupon->products as $product)
                                    <li>{{ $product->name }}</li>
                                @endforeach
                            </ul>
                        </dd>
                    @endif

                    <dt class="col-sm-3">Stackable</dt>
                    <dd class="col-sm-9">{{ $coupon->is_stackable ? 'Yes' : 'No' }}</dd>

                    <dt class="col-sm-3">Start Date</dt>
                    <dd class="col-sm-9">{{ $coupon->start_date ? date('Y-m-d',strtotime($coupon->start_date)) : '—' }}</dd>

                    <dt class="col-sm-3">End Date</dt>
                    <dd class="col-sm-9">{{ $coupon->end_date ? date('Y-m-d',strtotime($coupon->end_date)) : '—' }}</dd>

                    <dt class="col-sm-3">Description</dt>
                    <dd class="col-sm-9">{{ $coupon->description ?? '—' }}</dd>

                    <dt class="col-sm-3">Created At</dt>
                    <dd class="col-sm-9">{{ $coupon->created_at->format('Y-m-d H:i') }}</dd>

                    @if ($coupon->user)
                        <dt class="col-sm-3">Added By</dt>
                        <dd class="col-sm-9">{{ $coupon->user->name }} ({{ $coupon->user->email }})</dd>
                    @endif
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <livewire:admin.coupons.details :coupon="$coupon" lazy/>
            </div>
        </div>
    </div>

@endsection
