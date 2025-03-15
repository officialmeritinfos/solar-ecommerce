<div>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <!-- Search Input -->
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search by Action and description..."
                           wire:model.live.debounce.300ms="search">
                </div>

                <!-- Select Posts Per Page -->
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="perPage">
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
                    <select class="form-select" wire:model.live="status">
                        <option value="all">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    @can('create staff')
                        <button wire:click.prevent="toggleShowAddStaff" class="btn btn-sm btn-primary">
                            <span wire:loading.remove> </span>
                            <span wire:loading>Please wait...</span>
                        </button>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive">
            <table class="datatables-order table border-top">
                <thead>
                <tr>
                    <th scope="col">
                        S.L
                    </th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Data Joined</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($affiliates as $index=>$affiliate)
                    <tr>
                        <td>
                            <div class="form-check style-check d-flex align-items-center">
                                {{ $affiliates->firstItem() + $index }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $affiliate->photo??'https://ui-avatars.com/api/?rounded=true&name='.$affiliate->name }}"
                                     alt="" class="w-40-px h-40-px rounded-circle object-fit-cover lightboxed">

                                <h6 class="text-md mb-0 fw-medium flex-grow-1"> {{ $affiliate->name }}</h6>
                            </div>
                        </td>
                        <td>{{ $affiliate->email }}</td>
                        <td>{{ $affiliate->phone_number??'N/A' }}</td>
                        <td>
                            {{ getCurrencySign() }}{{ $affiliate->balance }}
                        </td>
                        <td>{{ date('F d, Y h:i:s', strtotime($affiliate->created_at)) }}</td>
                        <td>
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
                        </td>
                        <td>
                            @can('update affiliates details')
                                <a  href="{{ route('admin.affiliates.detail',['id'=>$affiliate->user_reference]) }}"><i class="ti ti-eye ti-md text-heading"></i></a>
                            @endcan
                            @if($affiliate->role !='superadmin')
                                @can('delete affiliates')
                                    <a wire:click="deleteAUser({{ $affiliate->id }})"><i class="ti ti-trash ti-md text-heading text-danger"></i></a>
                                @endcan
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-5 mx-7">
                {{ $affiliates->links() }}
            </div>
        </div>
    </div>
</div>
