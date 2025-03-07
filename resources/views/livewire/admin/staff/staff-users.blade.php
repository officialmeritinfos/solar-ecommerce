<div>
    @if(!$showAddStaff && !$showEditStaff && !$showStaffDetails)
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
                        <select class="form-select" wire:model.live="show">
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
                                <span wire:loading.remove> + Onboard Staff</span>
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
                        <th scope="col">Role</th>
                        <th scope="col">Data Added</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($staffs as $index=>$staff)
                        <tr>
                            <td>
                                <div class="form-check style-check d-flex align-items-center">
                                    {{ $staffs->firstItem() + $index }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $staff->photo??'https://ui-avatars.com/api/?rounded=true&name='.$staff->name }}"
                                         alt="" class="w-40-px h-40-px rounded-circle object-fit-cover lightboxed">
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1"> {{ $staff->name }}</h6>
                                </div>
                            </td>
                            <td>{{ $staff->email }}</td>
                            <td>
                                {{ucwords(str_replace('-',' ',$staff->role))}}
                            </td>
                            <td>{{ date('F d, Y h:i:s', strtotime($staff->created_at)) }}</td>
                            <td>
                                @switch($staff->is_active)
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
                                @can('update staff details')
                                    <a wire:click="toggleShowEditStaff({{ $staff->id }})"><i class="ti ti-edit ti-md text-heading text-danger"></i></a>
                                @endcan
                                @if($staff->role !='superadmin')
                                    @can('update staff details')
                                        <a wire:click="deleteAStaff({{ $staff->id }})"><i class="ti ti-trash ti-md text-heading text-danger"></i></a>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-5 mx-7">
                    {{ $staffs->links() }}
                </div>
            </div>
        </div>
    @endif
        @if($showAddStaff)
            <div class="card">
                <div class="card-body">
                    <h6 class="text-md text-primary-light mb-16">Onboard New Staff</h6>

                    <form wire:submit.prevent="submitNewStaff" class="row">

                        <div class="mb-2">
                            <label for="name"
                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Full Name <span
                                    class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror"
                                   id="name" wire:model.blur="name" placeholder="Enter Full Name">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-2 col-md-6">
                            <label for="email"
                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span
                                    class="text-danger-600">*</span></label>
                            <input type="email"
                                   class="form-control radius-8 @error('email') is-invalid @enderror" id="email"
                                   wire:model.blur="email" placeholder="Enter email address">
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-2 col-md-6">
                            <label for="fiat"
                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Role
                                <span class="text-danger-600">*</span> </label>
                            <select
                                class="form-control radius-8 form-select @error('staffRole') is-invalid @enderror"
                                id="fiat" wire:model.blur="staffRole">
                                <option value="">Select an option</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucwords(str_replace('-',' ',$role->name)) }} </option>
                                @endforeach
                            </select>
                            @error('staffRole') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-2 col-md-6">
                            <label for="password_confirmation"
                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Password
                                <span class="text-danger-600">*</span></label>
                            <input type="password"
                                   class="form-control radius-8 @error('password') is-invalid @enderror"
                                   id="password_confirmation" wire:model.blur="password"
                                   placeholder="Enter Password">
                            @error('password') <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2 col-md-6">
                            <label for="password"
                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Password Confirmation<span
                                    class="text-danger-600">*</span></label>
                            <input type="password"
                                   class="form-control radius-8 @error('password_confirmation') is-invalid @enderror"
                                   id="password" wire:model.blur="password_confirmation" placeholder="Repeat Password">
                            @error('password_confirmation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Proceed</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button wire:click.prevent="resetForm" class="btn btn-outline-light" wire:loading.attr="disabled">
                                <span wire:loading.remove>Cancel</span>
                                <span wire:loading>Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        @if($showEditStaff)
            <div class="card">
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-md text-primary-light mb-16">Edit {{$name}}</h6>

                            <form wire:submit.prevent="submitUpdate" class="row">

                                <div class="mb-2">
                                    <label for="name"
                                           class="form-label fw-semibold text-primary-light text-sm mb-8">Full Name <span
                                            class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror"
                                           id="name" wire:model.blur="name" placeholder="Enter Full Name">
                                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-2 col-md-6">
                                    <label for="email"
                                           class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span
                                            class="text-danger-600">*</span></label>
                                    <input type="email"
                                           class="form-control radius-8 @error('email') is-invalid @enderror" id="email"
                                           wire:model.blur="email" placeholder="Enter email address">
                                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-2 col-md-6">
                                    <label for="fiat"
                                           class="form-label fw-semibold text-primary-light text-sm mb-8">Role
                                        <span class="text-danger-600">*</span> </label>
                                    <select
                                        class="form-control radius-8 form-select @error('staffRole') is-invalid @enderror"
                                        id="fiat" wire:model.blur="staffRole">
                                        <option value="">Select an option</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ ucwords(str_replace('-',' ',$role->name)) }} </option>
                                        @endforeach
                                    </select>
                                    @error('staffRole') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-2 col-md-">
                                    <label for="fiat"
                                           class="form-label fw-semibold text-primary-light text-sm mb-8">Status
                                        <span class="text-danger-600">*</span> </label>
                                    <select
                                        class="form-control radius-8 form-select @error('staffStatus') is-invalid @enderror"
                                        id="fiat" wire:model.blur="staffStatus">
                                        <option value="">Select an option</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @error('staffStatus') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Proceed</span>
                                        <span wire:loading>Processing...</span>
                                    </button>
                                    <button wire:click.prevent="resetForm" class="btn btn-outline-light" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Cancel</span>
                                        <span wire:loading>Processing...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
</div>
