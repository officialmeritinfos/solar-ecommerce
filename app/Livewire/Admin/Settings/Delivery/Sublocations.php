<?php

namespace App\Livewire\Admin\Settings\Delivery;

use App\Models\DeliveryLocation;
use App\Models\DeliverySubLocation;
use App\Models\StaffActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Sublocations extends Component
{
    use WithPagination,LivewireAlert;

    public $perPage = 10;
    public $status = 'all';
    public $search = '';

    public $showAddForm = false;
    public $showEditForm = false;
    public $location;

    public $staff;

    public $name;
    public $price;
    public $editingId;

    protected $listeners = [
        'deleteZone'
    ];

    public function mount(DeliveryLocation $location)
    {
        $this->location = $location;
        $this->staff = Auth::user();
    }


    public function render()
    {
        $sublocations = DeliverySubLocation::where('delivery_location_id', $this->location->id) // Removed space
        ->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->when($this->status != 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.admin.settings.delivery.sublocations', [
            'sublocations' => $sublocations
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
    public function toggleShowAddLocation()
    {
        if (!$this->staff->can('manage delivery zones')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to manage delivery zones',
                'width' => '400',
            ]);
            return;
        }

        $this->showAddForm = true;
        $this->showEditForm = false;
    }

    public function createZone()
    {
        $this->validate([
            'name' => ['required','string','max:255',Rule::unique('delivery_sub_locations','name')->where('delivery_location_id',$this->location->id)],
            'price' => ['required','numeric']
        ],[
            'unique'=>'Selected :attribute already exists in the system'
        ],[
            'name'=>'Sub-location'
        ]);

        DB::beginTransaction();

        try {
            // Create the zone
            $delivery =  DeliverySubLocation::createOrFirst([
                'name' => $this->name, 'is_active' => true,
                'delivery_price' => $this->price,'delivery_location_id' => $this->location->id
            ]);

            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Added a new delivery sub-location',
                'description' => "{$this->staff->name}  has added a new delivery sub-location {$this->name} to Zone {$this->location->name}",
                'ip_address' => request()->ip()
            ]);

            DB::commit();
            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Delivery sub-location added successfully',
                'width' => '400',
            ]);

            // Reset the form and refresh data
            $this->resetForm();
        }catch (\Exception $exception){
            logger($exception);

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
    public function resetForm()
    {
        $this->name = '';
        $this->price=0;
        $this->showAddForm = false;
        $this->showEditForm=false;
    }

    public function editSubLocation($id)
    {
        //prevent unauthorized actions
        if (!$this->staff->can('manage delivery zones')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have the permission to manage delivery zones',
                'width' => '400',
            ]);
            return;
        }

        $subLocation = DeliverySubLocation::findOrFail($id);

        $this->editingId = $subLocation->id;
        $this->name = $subLocation->name;
        $this->price = $subLocation->delivery_price;

        $this->showEditForm = true;
    }
    public function updateZone()
    {
        $this->validate([
            'name' => ['required','string','max:255',Rule::unique('delivery_sub_locations','name')
                ->where('delivery_location_id',$this->location->id)->ignore($this->editingId)],
            'price' => ['required','numeric']
        ],[
            'unique'=>'Selected :attribute already exists in the system'
        ],[
            'name'=>'Sub-location'
        ]);

        DB::beginTransaction();

        try {
            // Create the zone
            $delivery =  DeliverySubLocation::where('id', $this->editingId)->update([
                'name' => $this->name, 'is_active' => true,
                'delivery_price' => $this->price
            ]);

            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'updated a new delivery sub-location',
                'description' => "{$this->staff->name}  has added a updated delivery sub-location in Zone {$this->location->name}",
                'ip_address' => request()->ip()
            ]);

            DB::commit();
            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Delivery sub-location updated successfully',
                'width' => '400',
            ]);

            // Reset the form and refresh data
            $this->resetForm();

        }catch (\Exception $exception){
            logger($exception);

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
    //delete zone
    public function deleteAZone($id)
    {
        try {

            $zone = DeliverySubLocation::findOrFail($id);

            //prevent unauthorized actions
            if (!$this->staff->can('manage delivery zones')){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'You do not have the permission to manage delivery sub-location',
                    'width' => '400',
                ]);
                return;
            }

            //open a dialog to confirm action
            $this->alert('warning', '', [
                'text' => 'Do you want to delete ' . $zone->name,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Yes',
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancel',
                'onConfirmed' => 'deleteZone',
                'data' => [
                    'id' => $id
                ],
                'timer' => null
            ]);
        } catch (\Exception $exception) {
            Log::info('An error occurred while trying to delete a zone sub-location: '.$exception->getMessage());
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while deleting sub-location',
                'width' => '400',
            ]);
            return;
        }
    }
    //confirmed delete zone
    public function deleteZone($data)
    {
        try {
            $roleId = $data['id'] ?? null;
            // Find the zone by its ID
            $zone = DeliverySubLocation::find($roleId);

            if (!$zone){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Sub-location not found',
                    'width' => '400',
                ]);
                return;
            }

            // Delete the zone
            $zone->delete();

            //record activity
            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Deleted Delivery Sub-location Zone',
                'description' => auth()->user()->name . ' has deleted sub-location: ' . $zone->name,
                'ip_address' => request()->ip()
            ]);
            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Delivery Sub Zone has been deleted successfully',
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
