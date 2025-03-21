<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = Auth::user();
    }
    //list Faqs
    public function showFaqs()
    {
        return view('admin.settings.faqs.index')->with([
            'pageName' => 'Frequently Asked Questions Settings',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
        ]);
    }
}
