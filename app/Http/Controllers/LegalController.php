<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class LegalController extends BaseController
{
    //terms and conditions
    public function terms()
    {
        return view('home.legal.terms')->with([
            'pageName' => "Terms & Conditions",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
        ]);
    }

    //Privacy policy
    public function privacy()
    {
        return view('home.legal.privacy')->with([
            'pageName' => "Privacy Policy",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
        ]);
    }

    //refund policy
    public function refund()
    {
        return view('home.legal.refund')->with([
            'pageName' => "Return & Refund Policy",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
        ]);
    }

    //shipping
    public function shipping()
    {
        return view('home.legal.shipping')->with([
            'pageName' => "Shipping Policy",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
        ]);
    }

    //engineer terms
    public function engineerTerms()
    {
        return view('home.legal.engineer')->with([
            'pageName' => "Field Support Engineer Terms",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
        ]);
    }

}
