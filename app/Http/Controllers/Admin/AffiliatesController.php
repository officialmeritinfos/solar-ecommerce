<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;

class AffiliatesController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = auth()->user();
    }
    //show affiliates table
    public function showAffiliates()
    {
        return view('admin.affiliates.show')->with([
            'pageName' => 'Affiliates',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
        ]);
    }
    //show affiliates earnings
    public function affiliateEarnings()
    {
        return view('admin.affiliates.earnings')->with([
            'pageName' => 'Affiliates Earnings',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
        ]);
    }
    //show affiliates payouts
    public function affiliatesPayouts()
    {
        return view('admin.affiliates.payouts')->with([
            'pageName' => 'Affiliates Payout Requests',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
        ]);
    }
    //show affiliates details
    public function affiliatesDetails($id)
    {
        $affiliate = User::where('user_reference', $id)->firstOrFail();

        return view('admin.affiliates.details')->with([
            'pageName' => 'Affiliates Details: '.$affiliate->name,
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'affiliate'=> $affiliate,
        ]);
    }
    //affiliate earning details
    public function showAffiliateEarningDetails($id)
    {

    }
    //affiliate payout details
    public function showAffiliatePayoutRequestDetails($reference)
    {

    }
}
