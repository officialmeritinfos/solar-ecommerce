<?php

namespace App\Livewire\Admin\Staff;

use App\Models\StaffActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissions extends Component
{
    use  WithPagination, LivewireAlert;

    #[Url]
    public $perPage = 10;
    #[Url]
    public $search='';

    public $showAddRole = false;
    public $showAssignPermission = false;

    public $selectedRoleId;

    public $selectedPermissions = [];
    public $newRoleName;

    public $staff;

    protected $listeners = [
        'deleteRole'
    ];

    public function mount(){
        $this->staff = auth()->user();
    }



    public function render()
    {

        $query = Role::with('permissions');

        if ($this->search){
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $roles = $query->orderBy('id','desc')->paginate($this->perPage);

        return view('livewire.admin.staff.roles-permissions',[
            'roles' => $roles,
            'permissions' => Permission::get()
        ]);
    }
    public function addNewRole()
    {
        $this->showAddRole = true;
        $this->showAssignPermission = false;
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
        <svg width="100%" height="100%" viewBox="0 0 500 200" preserveAspectRatio="none">
            <defs>
                <linearGradient id="table-skeleton-gradient">
                    <stop offset="0%" stop-color="#f0f0f0">
                        <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="50%" stop-color="#e0e0e0">
                        <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="100%" stop-color="#f0f0f0">
                        <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                </linearGradient>
            </defs>

            <!-- Table Header -->
            <rect x="10" y="10" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="10" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 1 -->
            <rect x="10" y="40" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="40" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 2 -->
            <rect x="10" y="70" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="70" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 3 -->
            <rect x="10" y="100" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="100" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
        </svg>

        </div>
        HTML;
    }
    public function createRole()
    {
        $this->validate([
            'newRoleName' => 'required|unique:roles,name',
            'selectedPermissions' => 'required|array|min:1',
            'selectedPermissions.*' => 'exists:permissions,name',
        ]);
        DB::beginTransaction();
        try {
            // Create the role
            $role = Role::create(['name' => $this->newRoleName, 'guard_name' => 'web']);
            // Assign permissions to the role
            if (!empty($this->selectedPermissions)) {
                $role->syncPermissions($this->selectedPermissions);
            }

            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Added a new role',
                'description' => auth()->user()->name . ' has created a new role.',
                'ip_address' => request()->ip()
            ]);

            DB::commit();
            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Role and permissions added successfully',
                'width' => '400',
            ]);

            // Reset the form and refresh data
            $this->resetForm();
        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred: '.$exception->getMessage(),
                'width' => '400',
            ]);
        }
    }

    public function updatePermissions()
    {
        // Fetch the role based on the selectedRoleId
        $role = Role::find($this->selectedRoleId);

        // Check if the role exists
        if (!$role) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Role not found',
                'width' => '400',
            ]);
            return;
        }

        // Ensure the staff has permission to update roles
        if (!$this->staff || !$this->staff->can('manage staff roles & permissions')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to assign roles',
                'width' => '400',
            ]);
            return;
        }

        //prevent updating the name for superadmin
        if ($role->name != $this->newRoleName && ($role->name=='superadmin' || $role->name=='admin')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Updating the superadmin and admin role name is not permitted.',
                'width' => '400',
            ]);
            return;
        }

        // Synchronize permissions with the selected ones
        if (!empty($this->selectedPermissions)) {
            $role->syncPermissions($this->selectedPermissions);
        }



        // Update the role name if it has changed
        if ($role->name !== $this->newRoleName) {
            $oldRoleName = $role->name; // Store the old name for reference
            $role->name = $this->newRoleName;
            $role->save();

            // Update the role name for staff members with the old role
            $staffWithFormerRoles = User::where('role', $oldRoleName)->get();
            foreach ($staffWithFormerRoles as $staffWithFormerRole) {
                $staffWithFormerRole->update(['role' => $this->newRoleName]);
                $staffWithFormerRole->syncRoles($role);
            }
        }

        StaffActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Edited  role',
            'description' => auth()->user()->name . ' has edit a role.',
            'ip_address' => request()->ip()
        ]);

        // Display success message
        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Permissions updated successfully',
            'width' => '400',
        ]);

        // Reset the form inputs
        $this->resetForm();
    }

    public function editRole($roleId)
    {
        $role = Role::with('permissions')->find($roleId);
        if (!$role){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Role not found',
                'width' => '400'
            ]);
            return;
        }

        if (!$this->staff->can('manage staff roles & permissions')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to assign roles',
                'width' => '400',
            ]);
            return;
        }

        $this->selectedRoleId = $role->id;
        $this->newRoleName = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->showAddRole=false;
        $this->showAssignPermission = true;

        return;
    }


    public function resetForm()
    {
        $this->selectedRoleId = null;
        $this->newRoleName = '';
        $this->selectedPermissions = [];
        $this->showAssignPermission = false;
        $this->showAddRole = false;
    }

    //delete role
    public function deleteARole($id)
    {
        try {

            $role = Role::findOrFail($id);

            //prevent updating the name for superadmin
            if ($role->name=='superadmin' || $role->name=='admin'){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'You cannot delete the admin nor the superadmin role.',
                    'width' => '400',
                ]);
                return;
            }

            //open a dialog to confirm action
            $this->alert('warning', '', [
                'text' => 'Do you want to delete ' . $role->name,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Yes',
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancel',
                'onConfirmed' => 'deleteRole',
                'data' => [
                    'id' => $id
                ],
                'timer' => null
            ]);
        } catch (\Exception $exception) {
            Log::info('An error occurred while trying to delete an ad');
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while creating an ad for merchant.s',
                'width' => '400',
            ]);
            return;
        }
    }
    //confirmed delete role
    public function deleteRole($data)
    {
        try {
            $roleId = $data['id'] ?? null;
            // Find the role by its ID
            $role = Role::findOrFail($roleId);

            // Detach all permissions assigned to the role
            $role->permissions()->detach();

            // Delete the role
            $role->delete();

            //record activity
            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Deleted  role',
                'description' => auth()->user()->name . ' has deleted ' . $role->name,
                'ip_address' => request()->ip()
            ]);
            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Role and its permissions have been deleted successfully',
                'width' => '400',
            ]);
        } catch (\Exception $e) {
            // Handle errors gracefully
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred: ' . $e->getMessage(),
                'width' => '400',
            ]);
        }
    }
}
