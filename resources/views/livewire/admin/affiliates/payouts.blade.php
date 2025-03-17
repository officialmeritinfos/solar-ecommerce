<div>
    <div class="card mb-6">
        <div class="card-header">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search by Name or amount"
                           wire:model.live.debounce.300ms="search">
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
</div>
