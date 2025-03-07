<div>
    <h4 class="mb-1">Roles List</h4>

    <div class="d-flex justify-content-between">
        <p class="mb-6">
            A role provided access to predefined menus and features so that depending on <br />
            assigned role an administrator can have access to what user needs.
        </p>
    </div>

    @if(!$showAssignPermission && !$showAddRole)
        <div class="d-flex justify-content-between">
            <div class="card-body text-sm-end text-center ps-sm-0">
                <button wire:click.prevent="addNewRole"
                        class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">
                    Add New Role
                </button>
                <div wire:loading wire:target="search,perPage,addNewRole, addNewPermission,deleteARole"
                     class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <!-- Role cards -->
        <div class="row g-6 justify-content-center">
            @foreach($roles as $role)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-normal mb-0 text-body"> Total {{ $role->permissions->count() }} Permissions</h6>
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    <li
                                        data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        title="Vinnie Mostowy"
                                        class="avatar pull-up">
                                        <img class="rounded-circle" src="{{ asset('dashboard/img/avatars/5.png') }}" alt="Avatar" />
                                    </li>
                                    <li
                                        data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        title="Allen Rieske"
                                        class="avatar pull-up">
                                        <img class="rounded-circle" src="{{ asset('dashboard/img/avatars/12.png') }}" alt="Avatar" />
                                    </li>
                                    <li
                                        data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        title="Julee Rossignol"
                                        class="avatar pull-up">
                                        <img class="rounded-circle" src="{{ asset('dashboard/img/avatars/6.png') }}" alt="Avatar" />
                                    </li>
                                    <li
                                        data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        title="Kaith D'souza"
                                        class="avatar pull-up">
                                        <img class="rounded-circle" src="{{ asset('dashboard/img/avatars/3.png') }}" alt="Avatar" />
                                    </li>
                                </ul>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="role-heading">
                                    <h5 class="mb-1">{{ ucfirst($role->name) }}</h5>
                                    <button
                                        wire:click.prevent="editRole({{ $role->id }})"
                                        class="btn btn-primary btn-sm"
                                    ><span>Edit Permission</span></button
                                    >
                                </div>
                                <a wire:click="deleteARole({{ $role->id }})"><i class="ti ti-trash ti-md text-heading text-danger"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 mx-7">
            {{ $roles->links() }}
        </div>
    @endif

    @if($showAddRole)
        <div class="card">
            <div class="card-body">
                <h6 class="text-md text-primary-light mb-16">Add New Role</h6>

                <form wire:submit.prevent="createRole">
                    <!-- Role Name -->
                    <div class="mb-4">
                        <label for="roleName" class="form-label">Role Name</label>
                        <input type="text" wire:model="newRoleName" id="roleName" class="form-control " placeholder="Enter Role Name">
                        @error('newRoleName') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Permissions -->
                    <div class="mb-4">
                        <label for="permissions" class="form-label">Assign Permissions</label>
                        <div class="permissions-list">
                            <div class="mb-4">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($permissions as $permission)
                                        <div class="form-check p-2 bg-cream-dark rounded border d-flex align-items-center gap-2" style="min-width: 200px;">
                                            <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}"
                                                   wire:model="selectedPermissions" value="{{ $permission->name }}">
                                            <label class="form-check-label mb-0" for="permission-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @error('selectedPermissions') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled">
                            <span wire:loading.remove>Add Role</span>
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

    @if($showAssignPermission)
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-md text-primary-light mb-16">Edit Role</h6>

                        <form wire:submit.prevent="updatePermissions">
                            <!-- Role Name -->
                            <div class="mb-3">
                                <label for="roleName" class="form-label">Role Name</label>
                                <input type="text" wire:model="newRoleName" id="roleName" class="form-control radius-8" placeholder="Enter Role Name">
                                @error('newRoleName') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Permissions -->
                            <div class="mb-3">
                                <label for="permissions" class="form-label">Assign Permissions</label>
                                <div class="permissions-list">
                                    <div class="mb-4">
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($permissions as $permission)
                                                <div class="form-check p-2 bg-cream-dark text-white rounded border d-flex align-items-center gap-2" style="min-width: 200px;">
                                                    <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}"
                                                           wire:model="selectedPermissions" value="{{ $permission->name }}"
                                                           @if(in_array($permission->name, $selectedPermissions)) checked @endif>
                                                    <label class="form-check-label mb-0" for="permission-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @error('selectedPermissions') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Update</span>
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
            </div>
        </div>
    @endif
</div>
