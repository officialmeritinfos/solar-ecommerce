<?php

namespace App\Livewire\Admin\Affiliates;

use App\Mail\ReferralBonusCreditedMail;
use App\Models\AffiliateEarning;
use App\Models\AffiliatePayout;
use App\Models\AffiliatePayoutMethod;
use App\Models\StaffActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Details extends Component
{
    use WithPagination,LivewireAlert;


    public $affiliate;
    public $staff;
    public $otp;
    public $showSuspendForm = false;
    public $showActivateForm = false;

    #[Url]
    public $earningStatus='all';
    #[Url]
    public $payoutStatus='all';

    #[Url]
    public $earningPerPage=10;
    #[Url]
    public $payoutPerPage=10;

    public $amount=0;

    public $showAddRefBonusForm = false;

    public $showSubtractRefBonusForm = false;

    public function mount(User $affiliate)
    {
        $this->affiliate = $affiliate;
        $this->staff = auth()->user();
    }

    public function render()
    {
        return view('livewire.admin.affiliates.details',[
            'earnings' => AffiliateEarning::where('affiliate_id', $this->affiliate->id)->when($this->earningStatus!='all', function ($query) {
                $query->where('status', $this->earningStatus);
            })->latest()->paginate($this->earningPerPage,'*','earnings'),
            'payouts'  => AffiliatePayout::where('affiliate_id', $this->affiliate->id)->when($this->payoutStatus!='all', function ($query) {
                $query->where('status', $this->payoutStatus);
            })->latest()->paginate($this->payoutPerPage,'*','payouts'),
            'referrals' => User::where('referred_by',$this->affiliate->id)->paginate(10,'*','referrals'),
            'payout_methods' => AffiliatePayoutMethod::where('user_id',$this->affiliate->id)->latest()->paginate(10,'*','payoutMethods'),
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
    //show add referral bonus form
    public function toggleAddRefBonusForm()
    {
        $this->showAddRefBonusForm = true;
        $this->showSuspendForm = false;
        $this->showSubtractRefBonusForm = false;
        $this->showActivateForm=false;
    }
    //show subtract referral bonus form
    public function toggleSubtractRefBonusForm()
    {
        $this->showAddRefBonusForm = false;
        $this->showSuspendForm = false;
        $this->showSubtractRefBonusForm = true;
        $this->showActivateForm=false;
    }
    public function toggleSusspendForm()
    {
        $this->showAddRefBonusForm = false;
        $this->showSuspendForm = true;
        $this->showSubtractRefBonusForm = false;
        $this->showActivateForm=false;
    }
    public function toggleActivateForm()
    {
        $this->showAddRefBonusForm = false;
        $this->showSuspendForm = false;
        $this->showSubtractRefBonusForm = false;
        $this->showActivateForm=true;
    }

    public function resetForm()
    {
        $this->showAddRefBonusForm = false;
        $this->showSuspendForm = false;
        $this->showSubtractRefBonusForm = false;
        $this->showActivateForm=false;
        $this->reset('amount','otp');
    }

    public function topUpBalance()
    {
        $this->validate([
            'otp' => 'required|numeric|digits:6',
            'amount' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            $affiliate = $this->affiliate;
            //ensure the staff has permission
            if ($this->staff->cannot('approve affiliate commissions')){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'You do not have the permission for this action.',
                    'width' => '400',
                ]);
                return;
            }

            //Verify OTP
            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($this->staff->google2fa_secret, $this->otp);

            if (!$valid) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Invalid OTP Token',
                    'width' => '400',
                ]);
                return;
            }

            //we will update the affiliate's balance and send mail
            $affiliate->update([
                'balance' => $affiliate->balance + $this->amount,
            ]);

            //record this to log
            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Top-up affiliate balance',
                'user_agent' => request()->userAgent(),
                'description' => auth()->user()->name.' Top Up affiliate balance - '.$this->affiliate->name,
            ]);

            //Send mail
            Mail::to($affiliate->email)->send(new ReferralBonusCreditedMail($affiliate,$this->amount));

            DB::commit();
            //Send response
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' =>'Referral Balance successfully topped up',
                'width' => '400',
            ]);
            //reset form
            $this->resetForm();
            return;
        }catch (\Exception $exception){
            DB::rollBack();
            logger($exception->getMessage());
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => $exception->getMessage(),
                'width' => '400',
            ]);
            return;
        }
    }

    public function subtractBalance()
    {
        $this->validate([
            'otp' => 'required|numeric|digits:6',
            'amount' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            $affiliate = $this->affiliate;
            //ensure the staff has permission
            if ($this->staff->cannot('reject affiliate commissions')){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'You do not have the permission for this action.',
                    'width' => '400',
                ]);
                return;
            }

            //Verify OTP
            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($this->staff->google2fa_secret, $this->otp);

            if (!$valid) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Invalid OTP Token',
                    'width' => '400',
                ]);
                return;
            }

            //check that the affiliate balance is not equal to zero
            if ($affiliate->balance==0){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Affiliate Balance is equal to zero ',
                    'width' => '400',
                ]);
                return;
            }

            //check that the amount is not greater than the affiliate account balance
            if ($affiliate->balance < $this->amount){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Amount cannot be greater than Affiliate balance',
                    'width' => '400',
                ]);
                return;
            }

            //we will update the affiliate's balance and send mail
            $affiliate->update([
                'balance' => $affiliate->balance - $this->amount,
            ]);

            //record in log
            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Subtract affiliate balance',
                'user_agent' => request()->userAgent(),
                'description' => auth()->user()->name.' Subtracted affiliate balance - '.$this->affiliate->name,
            ]);

            DB::commit();
            //Send response
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' =>'Affiliate Balance successfully subtracted',
                'width' => '400',
            ]);
            //reset form
            $this->resetForm();
            return;
        }catch (\Exception $exception){
            DB::rollBack();
            logger($exception->getMessage());
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => $exception->getMessage(),
                'width' => '400',
            ]);
            return;
        }
    }

    public function suspendAffiliate()
    {
        $this->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        DB::beginTransaction();
        try {
            $affiliate = $this->affiliate;
            //ensure the staff has permission
            if ($this->staff->cannot('update affiliates details')){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'You do not have the permission for this action.',
                    'width' => '400',
                ]);
                return;
            }

            //Verify OTP
            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($this->staff->google2fa_secret, $this->otp);

            if (!$valid) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Invalid OTP Token',
                    'width' => '400',
                ]);
                return;
            }

            //we will update the affiliate's balance and send mail
            $affiliate->update([
                'is_active' => false,
            ]);

            //record in log
            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Suspended Affiliate',
                'description' => auth()->user()->name.' suspended affiliate '.$affiliate->name,
                'user_agent' => request()->userAgent()
            ]);

            DB::commit();
            //Send response
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' =>'Affiliate Successfully suspended',
                'width' => '400',
            ]);
            //reset form
            $this->resetForm();
            return;
        }catch (\Exception $exception){
            DB::rollBack();
            logger($exception->getMessage());
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => $exception->getMessage(),
                'width' => '400',
            ]);
            return;
        }
    }

    public function activateAffiliate()
    {
        $this->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        DB::beginTransaction();
        try {
            $affiliate = $this->affiliate;
            //ensure the staff has permission
            if ($this->staff->cannot('update affiliates details')){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'You do not have the permission for this action.',
                    'width' => '400',
                ]);
                return;
            }

            //Verify OTP
            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($this->staff->google2fa_secret, $this->otp);

            if (!$valid) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Invalid OTP Token',
                    'width' => '400',
                ]);
                return;
            }

            //we will update the affiliate's balance and send mail
            $affiliate->update([
                'is_active' => true,
            ]);

            //create record
            StaffActivityLog::create([
                'user_agent' => request()->userAgent(),
                'description' => auth()->user()->name.' activated affiliate '.$this->affiliate->name,
                'action' => 'Activated affiliate',
                'user_id' => auth()->user()->id
            ]);

            DB::commit();
            //Send response
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' =>'Affiliate Successfully activated',
                'width' => '400',
            ]);
            //reset form
            $this->resetForm();
            return;
        }catch (\Exception $exception){
            DB::rollBack();
            logger($exception->getMessage());
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => $exception->getMessage(),
                'width' => '400',
            ]);
            return;
        }
    }
}
