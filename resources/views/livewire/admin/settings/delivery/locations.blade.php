<div>

    @if(!$showAddForm)
        <div class="card">

            <div class="card-body">
                <div class="row mb-3">
                    <!-- Search Input -->
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Search by Name..." wire:model.live.debounce.300ms="search">
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
                    <div class="col-md-3">
                        <select class="form-select" wire:model.live="status">
                            <option value="all">All</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        @can('manage delivery zones')
                            <button wire:click.prevent="toggleShowAddLocation" class="btn btn-sm btn-primary">
                                <span wire:loading.remove> + Add Location</span>
                                <span wire:loading>Please wait...</span>
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-1">
                        @can('manage delivery zones')
                            <button class="btn btn-sm btn-danger" wire:click="deleteAllZone"><i class="ti ti-trash ti-md "></i></button>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive">
                <table class="datatables-order table border-top">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($locations as $location)
                        <tr>
                            <td></td>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->is_active?'Active':'Inactive' }}</td>
                            <td>{{ $location->created_at ? date('M d, Y H:i:s',strtotime($location->created_at)) : 'N/A' }}</td>
                            <th>
                                <a href="{{ route('admin.delivery.settings.subLocations',['id'=>$location->id]) }}"
                                   class="btn btn-primary btn-sm" ><span>Add Location</span></a>
                                <button class="btn btn-sm btn-danger" wire:click="deleteAZone({{ $location->id }})"><i class="ti ti-trash ti-md "></i></button>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-5 mx-7">
                    {{ $locations->links() }}
                </div>
            </div>
        </div>
    @endif
        @if($showAddForm)
            <div class="card">
                <div class="card-body">
                    <h6 class="text-md text-primary-light mb-16">Add New Zone</h6>

                    <form wire:submit.prevent="createZone">
                        <!-- Role Name -->
                        <div class="mb-4">
                            <label for="roleName" class="form-label">Zone Name</label>
                            <select wire:model="zoneName" id="roleName" class="form-control" multiple>
                                @foreach($states as $state)
                                    <option value="{{ $state->name }}"> {{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('zoneName') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled">
                                <span wire:loading.remove>Add Zone</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button wire:click.prevent="resetForm" class="btn btn-outline-dark btn-sm" wire:loading.attr="disabled">
                                <span wire:loading.remove>Cancel</span>
                                <span wire:loading>Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

</div>
