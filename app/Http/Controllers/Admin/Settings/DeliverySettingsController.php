<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\DeliveryLocation;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliverySettingsController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = Auth::user();
    }
    //landing page
    public function showLocation()
    {
        return view('admin.settings.delivery.index')->with([
            'pageName' => 'Delivery location Settings',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user
        ]);
    }
    //landing page
    public function showSubLocation($locationId)
    {
        $location = DeliveryLocation::findOrFail($locationId);

        return view('admin.settings.delivery.sub_locations')->with([
            'pageName' => "{$location->name} Delivery Sub-locations Settings",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'location' => $location
        ]);
    }
}
