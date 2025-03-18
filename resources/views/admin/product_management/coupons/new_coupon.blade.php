@extends('admin.layout.base')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">Create New Coupon</h4>

                <form id="createCouponForm" action="{{ route('admin.coupons.create.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="code" class="form-label">Coupon Code <span class="text-danger">*</span></label>
                            <input type="text" id="code" name="code" class="form-control" required placeholder="e.g. SUMMER2025">
                        </div>

                        <div class="col-md-6">
                            <label for="discount_type" class="form-label">Discount Type</label>
                            <select id="discount_type" name="discount_type" class="form-select">
                                <option value="fixed">Fixed Amount</option>
                                <option value="percent" selected>Percentage</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="discount_value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" id="discount_value" name="discount_value" class="form-control" required placeholder="e.g. 1000 or 10%">
                        </div>

                        <div class="col-md-6">
                            <label for="max_discount" class="form-label">Max Discount (For % type)</label>
                            <input type="number" step="0.01" id="max_discount" name="max_discount" class="form-control" placeholder="e.g. 5000">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="min_order_amount" class="form-label">Min Order Amount</label>
                            <input type="number" step="0.01" id="min_order_amount" name="min_order_amount" class="form-control" placeholder="e.g. 2000">
                        </div>

                        <div class="col-md-6">
                            <label for="usage_limit" class="form-label">Total Usage Limit</label>
                            <input type="number" id="usage_limit" name="usage_limit" class="form-control" placeholder="e.g. 100">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="usage_limit_per_user" class="form-label">Limit Per User</label>
                            <input type="number" id="usage_limit_per_user" name="usage_limit_per_user" class="form-control" placeholder="e.g. 1">
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="datetime-local" id="start_date" name="start_date" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="datetime-local" id="end_date" name="end_date" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input type="checkbox" id="is_active" name="is_active" class="form-check-input" checked>
                                <label for="is_active" class="form-check-label">Active</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input type="checkbox" id="is_stackable" name="is_stackable" class="form-check-input">
                                <label for="is_stackable" class="form-check-label">Stackable</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input type="checkbox" id="is_product_specific" name="is_product_specific" class="form-check-input">
                                <label for="is_product_specific" class="form-check-label">Product Specific</label>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div id="product-select-wrapper" class="mb-3" style="display: none;">
                                <label for="products" class="form-label">Select Products</label>
                                <select name="products[]" id="products" class="form-select" multiple>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</small>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3 mt-5">
                        <label for="description" class="form-label">Description (optional)</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Write something about this coupon..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary submit">Save Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('dashboard/requests/admin/add_coupon.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#is_product_specific').on('change', function () {
                    if ($(this).is(':checked')) {
                        $('#product-select-wrapper').slideDown();
                    } else {
                        $('#product-select-wrapper').slideUp();
                        $('#products').val(null); // Clear selected products
                    }
                });
            });
        </script>
    @endpush
@endsection
