<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = Auth::user();
    }

    //landing page
    public function landingPage()
    {
        return view('admin.dashboard')->with([
            'pageName' => 'Administration Dashboard',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user
        ]);
    }
}
