<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //landing page
    public function showLoginForm()
    {
        return view('auth.login')->with([
            'pageName' => 'Account Login',
            'web'      =>  GeneralSetting::first(),
            'siteName' =>  GeneralSetting::first()->name,
        ]);
    }
    //process login
    public function login(Request $request){

    }
    //show account recovery page
    public function accountRecovery()
    {
        
    }
}
