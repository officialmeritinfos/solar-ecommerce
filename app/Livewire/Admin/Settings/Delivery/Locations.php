<?php

namespace App\Livewire\Admin\Settings\Delivery;

use App\Models\DeliveryLocation;
use App\Models\StaffActivityLog;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Locations extends Component
{
    use WithPagination,LivewireAlert;

    public $perPage = 10;
    public $status = 'all';
    public $search = '';

    public $showAddForm = false;
    public $locationId;

    public $staff;

    public $zoneName =[];

    protected $listeners = [
        'deleteZone'
    ];

    public function mount()
    {
        $this->staff = Auth::user();
    }

    public function render()
    {

        $locations = DeliveryLocation::with('subLocations')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->when($this->status!='all', function ($query) {
                $query->where('status', $this->status);
            })->orderBy('name')->paginate($this->perPage);

        return view('livewire.admin.settings.delivery.locations',[
            'states'        => State::where('country_code','NG')->orderBy('name')->get(),
            'locations'     => $locations,
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
    }
    public function createZone()
    {

        $this->validate([
            'zoneName' => 'required|unique:delivery_locations,name',
        ],[
            'unique'=>'Selected :attribute already exists in the system'
        ],[
            'zoneName'=>'Zone'
        ]);

        DB::beginTransaction();

        try {
            // Create the zone
            foreach ($this->zoneName as $item) {
               $delivery =  DeliveryLocation::createOrFirst(['name' => $item, 'is_active' => true]);
            }

            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Added a new delivery location',
                'description' => "{$this->staff->name}  has added a new delivery location",
                'ip_address' => request()->ip()
            ]);

            DB::commit();
            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Delivery location added successfully',
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
        $this->zoneName = '';
        $this->showAddForm = false;
    }
    //delete zone
    public function deleteAZone($id)
    {
        try {

            $zone = DeliveryLocation::findOrFail($id);

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
            Log::info('An error occurred while trying to delete a zone: '.$exception->getMessage());
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while deleting zone',
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
            $zone = DeliveryLocation::with('subLocations')->find($roleId);

            if (!$zone){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Zone not found',
                    'width' => '400',
                ]);
                return;
            }

            //check if zone has sublocations
            if ($zone->subLocations->count() > 0) {
                $zone->subLocations()->delete();
            }
            // Delete the zone
            $zone->delete();

            //record activity
            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Deleted Delivery Zone',
                'description' => auth()->user()->name . ' has deleted ' . $zone->name,
                'ip_address' => request()->ip()
            ]);
            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Delivery Zone has been deleted successfully',
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
    //delete all zone
    public function deleteAllZone()
    {
        //check staff can manage zones
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
        $zones = DeliveryLocation::with('subLocations')->get();
        if ($zones->count() > 0) {
            foreach ($zones as $zone) {
                //check if zone has subLocations
                if ($zone->subLocations->count() > 0) {
                    $zone->subLocations()->delete();
                }
                // Delete the zone
                $zone->delete();

            }
            //record activity
            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Deleted all Delivery Zone',
                'description' => auth()->user()->name . ' has deleted all delivery zones',
                'ip_address' => request()->ip()
            ]);
            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Delivery Zone has been deleted successfully',
                'width' => '400',
            ]);
        }
    }
}
