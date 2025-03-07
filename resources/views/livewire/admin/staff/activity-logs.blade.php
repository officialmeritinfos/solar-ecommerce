<div>
    <div class="card">

        <div class="card-body">
            <div class="row mb-3">
                <!-- Search Input -->
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search by Action and description..." wire:model.live.debounce.300ms="search">
                </div>

                <!-- Select Posts Per Page -->
                <div class="col-md-3">
                    <select class="form-select" wire:model.live.debounce.300ms="perPage">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                    </select>
                </div>


                <!-- Filter by Author -->
                <div class="col-md-3">
                    <select class="form-select" wire:model.live.debounce.300ms="staff">
                        <option value="">All Staff</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">

                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive">
            <table class="datatables-order table border-top">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Action</th>
                    <th>Category</th>
                    <th>Staff</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->description??'N/A' }}</td>
                        <td>{{ $log->user->name }}</td>
                        <td>{{ $log->created_at ? date('M d, Y H:i:s',strtotime($log->created_at)) : 'N/A' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-5 mx-7">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
