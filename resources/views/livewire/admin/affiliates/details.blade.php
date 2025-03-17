<div>
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-6">
                <div class="card-body pt-12">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img
                                class="img-fluid rounded mb-4 lightboxed"
                                src="{{ $affiliate->photo??'https://ui-avatars.com/api/?rounded=true&name='.$affiliate->name }}"
                                height="120"
                                width="120"
                                alt="User avatar" />
                            <div class="user-info text-center">
                                <h5>{{ $affiliate->name }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-6 gap-0 gap-md-3 gap-lg-4">
                        <div class="d-flex align-items-center me-5 gap-4">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="ti ti-checkbox ti-lg"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ getCurrencySign() }}{{ number_format($affiliate->balance,2) }}</h5>
                                <span>Referral Balance</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="ti ti-briefcase ti-lg"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ numberOfReferrals($affiliate->id) }}</h5>
                                <span>Total Referrals</span>
                            </div>
                        </div>
                    </div>
                    @if(!$showAddRefBonusForm && !$showSuspendForm && !$showSubtractRefBonusForm && !$showActivateForm)
                        <h5 class="pb-4 border-bottom mb-4">Details</h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-6">
                                <li class="mb-2">
                                    <span class="h6">Name:</span>
                                    <span>{{ $affiliate->name }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="h6">Email:</span>
                                    <span>{{ $affiliate->email }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="h6">Phone:</span>
                                    <span>{{ $affiliate->phone }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="h6">Status:</span>
                                    <span>
                                    @switch($affiliate->is_active)
                                            @case(1)
                                                <span
                                                    class="bg-success badge">Active</span>
                                                @break

                                            @default
                                                <span
                                                    class="bg-danger badge">Inactive</span>
                                                @break
                                        @endswitch
                                </span>
                                </li>
                                <li class="mb-2">
                                    <span class="h6">ID:</span>
                                    <span>{{ $affiliate->user_reference }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="h6">Two-factor Status:</span>
                                    <span>
                                    @switch($affiliate->two_factor)
                                            @case(1)
                                                <span
                                                    class="bg-success badge">Active</span>
                                                @break

                                            @default
                                                <span
                                                    class="bg-danger badge">Inactive</span>
                                                @break
                                        @endswitch
                                </span>
                                </li>

                            </ul>

                            <div class="d-flex justify-content-center mt-5">
                                <button
                                    wire:click.prevent="toggleAddRefBonusForm"
                                    class="btn btn-primary me-4"
                                    data-bs-target="#editUser"
                                    data-bs-toggle="modal"
                                >Top-up Referral Balance</button
                                >
                                <button
                                    wire:click.prevent="toggleSubtractRefBonusForm"
                                    class="btn btn-info me-4"
                                    data-bs-target="#editUser"
                                    data-bs-toggle="modal"
                                >Subtract Referral Balance</button
                                >
                                @if($affiliate->is_active)
                                    <button wire:click.prevent="toggleSusspendForm" class="btn btn-label-danger suspend-user">Suspend</button>
                                @else
                                    <button wire:click.prevent="toggleActivateForm" class="btn btn-label-success suspend-user">Activate</button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /User Card -->
            <!-- Add Forms Here -->
            <div class="mt-5">
                @if($showAddRefBonusForm)
                    <!-- Top-up Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Top-up Referral Balance</h6>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="topUpBalance">
                                <div class="mb-3">
                                    <label for="topUpAmount" class="form-label">Amount</label>
                                    <input type="number" step="0.01" id="topUpAmount" class="form-control" wire:model.defer="amount">
                                    @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="topUpNote" class="form-label">OTP</label>
                                    <input id="topUpNote" class="form-control" wire:model.defer="otp" minlength="6" maxlength="6"/>
                                    @error('otp')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <span wire:loading.remove>Top-up </span>
                                        <span wire:loading>Please wait...</span>
                                    </button>
                                    <button
                                        type="reset"
                                        class="btn btn-label-secondary"
                                        wire:click.prevent="resetForm"
                                        aria-label="Close">
                                        <span wire:loading.remove>Cancel </span>
                                        <span wire:loading>Please wait...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                @if($showSubtractRefBonusForm)
                        <!-- Subtract Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Subtract from Referral Balance</h6>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="subtractBalance">
                                <div class="mb-3">
                                    <label for="subtractAmount" class="form-label">Amount</label>
                                    <input type="number" step="0.01" id="subtractAmount" class="form-control" wire:model.defer="amount" required>
                                    @error('amount')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="subtractNote" class="form-label">OTP</label>
                                    <input id="subtractNote" class="form-control" wire:model.defer="otp" minlength="6" maxlength="6 "/>
                                    @error('otp')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <span wire:loading.remove> Subtract</span>
                                        <span wire:loading>Please wait...</span>
                                    </button>
                                    <button
                                        type="reset"
                                        class="btn btn-label-secondary"
                                        wire:click.prevent="resetForm"
                                        aria-label="Close">
                                        <span wire:loading.remove> Cancel</span>
                                        <span wire:loading>Please wait...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                @if($showSuspendForm)<!-- Suspend Affiliate Form -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Suspend Affiliate</h6>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="suspendAffiliate">
                                <div class="mb-3">
                                    <label for="suspendReason" class="form-label">OTP</label>
                                    <input id="suspendReason" class="form-control" wire:model.defer="otp" required maxlength="6" minlength="6"/>
                                    @error('otp')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-label-danger">
                                        <span wire:loading.remove>Suspend </span>
                                        <span wire:loading>Please wait...</span>
                                    </button>
                                    <button
                                        type="reset"
                                        class="btn btn-label-secondary"
                                        wire:click.prevent="resetForm"
                                        aria-label="Close">
                                        <span wire:loading.remove>Cancel </span>
                                        <span wire:loading>Please wait...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif


                @if($showActivateForm)<!-- Activate Affiliate Form -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Activate Affiliate</h6>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="activateAffiliate">
                                <div class="mb-3">
                                    <label for="suspendReason" class="form-label">OTP</label>
                                    <input id="suspendReason" class="form-control" wire:model.defer="otp" required maxlength="6" minlength="6"/>
                                    @error('otp')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-label-warning">
                                        <span wire:loading.remove>Activate </span>
                                        <span wire:loading>Please wait...</span>
                                    </button>
                                    <button
                                        type="reset"
                                        class="btn btn-label-secondary"
                                        wire:click.prevent="resetForm"
                                        aria-label="Close">
                                        <span wire:loading.remove>Cancel </span>
                                        <span wire:loading>Please wait...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!--/ User Sidebar -->
        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 order-0 order-md-1">
            <!-- Project table -->
            <div class="card mb-6">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <h5 class="mb-0">Earning</h5>
                        </div>
                        <!-- Select Posts Per Page -->
                        <div class="col-md-3">
                            <select class="form-select" wire:model.live="earningPerPage">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                        </div>


                        <!-- Filter by Status -->
                        <div class="col-md-3">
                            <select class="form-select" wire:model.live="earningStatus">
                                <option value="all">All</option>
                                <option value="1">Completed</option>
                                <option value="2">Pending</option>
                                <option value="3">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-sm btn-primary">
                                <span wire:loading.remove> </span>
                                <span wire:loading>Please wait...</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="datatables-projects table border-top">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Amount</th>
                            <th>Referred Customer</th>
                            <th>Commission Rate</th>
                            <th class="w-px-200">Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($earnings as $earning)
                            <tr>
                                <td> {{ getCurrencySign() }} {{ $earning->amount }}</td>
                                <td> {{ $earning->referredUser->name }} </td>
                                <td> {{ $earning->commission_rate }}% </td>
                                <td>
                                    @switch($earning->status)
                                        @case(1)
                                            <span class="badge bg-success">Completed</span>
                                        @break
                                        @case(2)
                                            <span class="badge bg-primary">Pending</span>
                                        @break
                                        @default
                                            <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    {{ $earning->created_at->format('d-M-Y h:i') }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.affiliates.earnings.detail',['id'=>$earning->id]) }}"><i class="fa fa-arrow-circle-right"></i> </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $earnings->links() }}
                    </div>
                </div>
            </div>
            <!-- /Project table -->

            <!-- Project table -->
            <div class="card mb-6">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <h5 class="mb-0">Payouts</h5>
                        </div>
                        <!-- Select Posts Per Page -->
                        <div class="col-md-3">
                            <select class="form-select" wire:model.live="payoutPerPage">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                        </div>


                        <!-- Filter by Status -->
                        <div class="col-md-3">
                            <select class="form-select" wire:model.live="payoutStatus">
                                <option value="all">All</option>
                                <option value="1">Completed</option>
                                <option value="2">Pending</option>
                                <option value="4">Processing</option>
                                <option value="3">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button  class="btn btn-sm btn-primary">
                                <span wire:loading.remove> </span>
                                <span wire:loading>Please wait...</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="datatables-projects table border-top">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Payout Method</th>
                            <th class="w-px-200">Status</th>
                            <th>Date Requested</th>
                            <th>Processed At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payouts as $payout)
                            <tr>
                                <td></td>
                                <td>{{ $payout->reference }}</td>
                                <td> {{ getCurrencySign() }} {{ $payout->amount }}</td>
                                <td> {{ $payout->payoutMethod->method }} </td>
                                <td>
                                    @switch($payout->status)
                                        @case(1)
                                            <span class="badge bg-success">Completed</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-primary">Pending</span>
                                            @break
                                        @case(4)
                                            <span class="badge bg-primary">Processing</span>
                                            @break
                                        @default
                                            <span class="badge bg-danger">Cancelled</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    {{ $payout->created_at->format('d-M-Y h:i') }}
                                </td>
                                <td>
                                    {{ $payout->processed_at }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.affiliates.payouts.detail',['id'=>$earning->id]) }}"><i class="fa fa-arrow-circle-right"></i> </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{ $payouts->links() }}
                    </div>
                </div>
            </div>
            <!-- /Project table -->
            <!-- Project table -->
            <div class="card mb-6">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <h5 class="mb-0">Referrals</h5>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="datatables-projects table border-top">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th class="w-px-200">Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($referrals as $referral)
                            <tr>
                                <td></td>
                                <td>{{ $referral->name }}</td>
                                <td> {{ $referral->email }} </td>
                                <td>
                                    @switch($referral->is_active)
                                        @case(1)
                                            <span class="badge bg-success">Active</span>
                                            @break
                                        @default
                                            <span class="badge bg-danger">Inactive</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    {{ $referral->created_at->format('d-M-Y h:i') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $referrals->links() }}
                    </div>
                </div>
            </div>
            <!-- /Project table -->

            <!-- Project table -->
            <div class="card mb-6">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <h5 class="mb-0">Payout Methods</h5>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="datatables-projects table border-top">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Details</th>
                            <th class="w-px-200">Default</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payout_methods as $method)
                            <tr>
                                <td></td>
                                <td>{{ $method->method }}</td>
                                <td>
                                    @if (is_array($method->details) && count($method->details))
                                        @foreach ($method->details as $key => $value)
                                            <div>
                                                <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No details available</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($method->is_default)
                                        @case(1)
                                            <span class="badge bg-success">Default</span>
                                            @break
                                        @default
                                            <span class="badge bg-primary">Not Default</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    {{ $method->created_at->format('d-M-Y h:i') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $payout_methods->links() }}
                    </div>
                </div>
            </div>
            <!-- /Project table -->
        </div>
    </div>
</div>
