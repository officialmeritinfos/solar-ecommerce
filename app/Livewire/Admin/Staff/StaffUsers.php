<?php

namespace App\Livewire\Admin\Staff;

use App\Models\GeneralSetting;
use App\Models\StaffActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class StaffUsers extends Component
{
    use  LivewireAlert, WithPagination,WithFileUploads;

    public $mainStaff;
    public $web;
    #[Url]
    public $search='';
    #[Url]
    public $status = 'all';
    #[Url]
    public $role;
    #[Url]
    public $show = 10;
    public $showAddStaff;
    public $showEditStaff;

    public $showStaffDetails;

    public $name;
    public $email;
    public $staffRole;
    public $password;
    public $password_confirmation;
    public $staffStatus;
    public $editingId;

    protected $listeners = [
        'deleteStaff'
    ];

    public function mount()
    {
        $this->mainStaff = Auth::user();
        $this->web = GeneralSetting::find(1);
    }

    public function render()
    {
        $staffs = User::query()
            ->when($this->search, function($query) {
                $query->where('email', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->status != 'all', function($query) {
                $query->where('is_active', $this->status);
            })
            ->when($this->role,function ($query){
                $query->where('role',$this->role);
            })->when($this->mainStaff->role!='superadmin', function ($query) {
                $query->whereNot('role','superadmin');
                $query->whereNot('role','admin');
            })->latest()->paginate($this->show);

        return view('livewire.admin.staff.staff-users',[
            'staffs'       => $staffs,
            'roles'        =>Role::where('guard_name','web')->get()
        ]);
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
    public function toggleShowAddStaff()
    {
        $this->showAddStaff = true;
    }
    public function toggleShowEditStaff($id)
    {
        //check if the logged in staff can edit staff
        $staff = User::where('id',$id)->where('is_admin',true) ->first();
        if (empty($staff)){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Staff not found',
                'width' => '400'
            ]);
            return;
        }
        if (!$this->mainStaff->can('update staff details')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this staff.',
                'width' => '400',
            ]);
            return;
        }

        if ($staff->role=='superadmin' && !$this->mainStaff->can('update admin details')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this superadmin level',
                'width' => '400',
            ]);
            return;
        }

        if ($staff->role=='admin' && !$this->mainStaff->can('update admin details')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this admin level',
                'width' => '400',
            ]);
            return;
        }

        $this->name = $staff->name;
        $this->email = $staff->email;
        $this->staffRole = $staff->role;
        $this->staffStatus = $staff->status;
        $this->editingId = $staff->id;

        $this->showEditStaff = true;
    }
    public function toggleShowStaffDetail($id)
    {
        $this->showStaffDetails = true;
    }

    public function resetForm()
    {
        $this->showAddStaff =false;
        $this->showEditStaff = false;
        $this->showStaffDetails = false;

        $this->reset([
            'name','email','editingId','password','password_confirmation','staffRole','staffStatus'
        ]);
    }
    public function submitNewStaff(Request $request)
    {
        $this->validate([
            'name'        =>['required','string','max:150'],
            'email'       =>['required','email','unique:users,email'],
            'staffRole'   =>['required','string','max:100',Rule::exists('roles','name')->where('guard_name','web')],
            'password'    =>['required','string','confirmed','min:8'],
            'password_confirmation'    =>['required','string','min:8'],
        ]);
        if (!$this->mainStaff->can('create staff')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to add this staff.',
                'width' => '400',
            ]);
            return;
        }
        DB::beginTransaction();
        try {
            $staff = User::create([
                'name'=>$this->name,
                'email' => $this->email,'password' =>!empty($this->password)?bcrypt($this->password):'123456789',
                'role' => $this->staffRole,
                'is_staff' => true, 'is_active' => true,'is_admin' => true
            ]);

            if (!empty($staff)){

                //create staff action
                StaffActivityLog::create([
                    'action' => 'create staff',
                    'user_id' => auth()->user()->id,
                    'description' => auth()->user()->name.' created a new staff',
                    'ip_address' => request()->ip(),
                ]);

                //send a welcome mail to the merchant
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Staff created successfully.',
                    'width' => '400'
                ]);
                DB::commit();

                $this->resetForm();
                return;
            }

        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while onboarding the staff.',
                'width' => '400',
            ]);
            Log::error('Error onboarding staff: ' . $exception->getMessage());
        }
    }
    public function submitUpdate()
    {
        $this->validate([
            'name'        =>['required','string','max:150'],
            'email'       =>['required','email',Rule::unique('users','email')->ignore($this->editingId)],
            'staffRole'   =>['required','string','max:100',Rule::exists('roles','name')->where('guard_name','web')],
            'staffStatus' =>['required','numeric','in:1,0']
        ]);

        $staff = User::where('id',$this->editingId)->first();
        if (empty($staff)){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Staff not found',
                'width' => '400'
            ]);
            return;
        }
        if (!$this->mainStaff->can('update staff details')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this staff.',
                'width' => '400',
            ]);
            return;
        }

        if ($staff->role=='superadmin' && !$this->mainStaff->can('update admin details')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to edit this admin level',
                'width' => '400',
            ]);
            return;
        }
        DB::beginTransaction();
        try {
            $updated = User::where('id',$this->editingId)->update([
                'name'=>$this->name,'email' => $this->email,'is_active' => $this->staffStatus,
                'role' => $this->staffRole
            ]);

            if ($updated){
                //create staff action
                StaffActivityLog::create([
                    'action' => 'update staff',
                    'user_id' => auth()->user()->id,
                    'description' => auth()->user()->name.' updated a staff details',
                    'ip_address' => request()->ip(),
                ]);
                //send a welcome mail to the merchant
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Staff updated successfully.',
                    'width' => '400'
                ]);
                DB::commit();
                $this->resetForm();
                return;
            }

        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while updating the staff.',
                'width' => '400',
            ]);
            Log::error('Error updating staff: ' . $exception->getMessage());
        }
    }

    //delete staff
    public function deleteAStaff($id)
    {
        try {

            $staff = User::findOrFail($id);

            //prevent updating the name for superadmin
            if ($staff->role=='superadmin' ){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'You cannot delete a superadmin',
                    'width' => '400',
                ]);
                return;
            }

            //open a dialog to confirm action
            $this->alert('warning', '', [
                'text' => 'Do you want to delete ' . $staff->name,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Yes',
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancel',
                'onConfirmed' => 'deleteStaff',
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
    public function deleteStaff($data)
    {
        try {
            $roleId = $data['id'] ?? null;
            // Find the role by its ID
            $staff = User::findOrFail($roleId);

            // Delete the staff
            $staff->delete();

            //record activity
            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Deleted  role',
                'description' => auth()->user()->name . ' has deleted ' . $staff->name,
                'ip_address' => request()->ip()
            ]);
            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Staff successfully deleted',
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
