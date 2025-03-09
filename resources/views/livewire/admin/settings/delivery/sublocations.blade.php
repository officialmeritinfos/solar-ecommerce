<div>

    @if(!$showAddForm && !$showEditForm)
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

                    <div class="col-md-3">
                        @can('manage delivery zones')
                            <button wire:click.prevent="toggleShowAddLocation" class="btn btn-sm btn-primary">
                                <span wire:loading.remove> + Add Sub-Location</span>
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
                        <th></th>
                        <th>Parent</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($sublocations as $sublocation)
                        <tr>
                            <td></td>
                            <td>{{ $sublocation->mainLocation->name }}</td>
                            <td>{{ $sublocation->name }}</td>
                            <td>{{ $sublocation->delivery_price }}</td>
                            <td>{{ $sublocation->is_active?'Active':'Inactive' }}</td>
                            <td>{{ $sublocation->created_at ? date('M d, Y H:i:s',strtotime($sublocation->created_at)) : 'N/A' }}</td>
                            <th>
                                <button wire:click.prevent="editSubLocation({{ $sublocation->id }})"
                                   class="btn btn-primary btn-sm" ><span>Edit Location</span></button>
                                <button class="btn btn-sm btn-danger" wire:click="deleteAZone({{ $sublocation->id }})"><i class="ti ti-trash ti-md "></i></button>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-5 mx-7">
                    {{ $sublocations->links() }}
                </div>
            </div>
        </div>
    @endif
    @if($showAddForm)
        <div class="card">
            <div class="card-body">
                <h6 class="text-md text-primary-light mb-16">Add New Zone Sub-location</h6>

                <form wire:submit.prevent="createZone">
                    <!-- Zone Name -->
                    <div class="mb-4">
                        <label for="roleName" class="form-label">Zone</label>
                        <input wire:model="name" id="roleName" class="form-control" />
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="roleName" class="form-label">Price</label>
                        <input type="number" step="0.01" wire:model="price" id="roleName" class="form-control" />
                        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled">
                            <span wire:loading.remove>Proceed</span>
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
        @if($showEditForm)
            <div class="card">
                <div class="card-body">
                    <h6 class="text-md text-primary-light mb-16">Edit Zone Sub-location</h6>

                    <form wire:submit.prevent="updateZone">
                        <!-- Zone Name -->
                        <div class="mb-4">
                            <label for="roleName" class="form-label">Zone</label>
                            <input wire:model="name" id="roleName" class="form-control" />
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="roleName" class="form-label">Price</label>
                            <input type="number" step="0.01" wire:model="price" id="roleName" class="form-control" />
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled">
                                <span wire:loading.remove>Proceed</span>
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
