<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = Auth::user();
    }
    //manage staff users
    public function showStaffLists()
    {
        return view('admin.staff.staff')->with([
            'pageName' => 'Staff Lists',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user
        ]);
    }

    //roles and permissions
    public function showRolesAndPermissions()
    {
        return view('admin.staff.roles_permissions')->with([
            'pageName' => 'Roles & Permissions',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user
        ]);
    }

    //activity logs
    public function showActivityLogs()
    {
        return view('admin.staff.activities')->with([
            'pageName' => 'Staff Activity Logs',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user
        ]);
    }
}
