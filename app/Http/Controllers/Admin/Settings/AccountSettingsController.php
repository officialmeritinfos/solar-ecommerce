<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\TwoFAActivatedMailable;
use App\Models\GeneralSetting;
use App\Models\StaffActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FAQRCode\Google2FA;

class AccountSettingsController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = Auth::user();
    }

    //account settings
    public function showAccountSettingsForm()
    {
        return view('admin.settings.account.account_settings')->with([
            'pageName' => 'Account Settings',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user
        ]);
    }

    //account security settings
    public function showAccountSecurityPage()
    {
        $QR_Image = '';

        //set the authenticator setup
        if (!$this->user->two_factor){
            $google2fa = new Google2FA();

            // Generate Secret Key if not set
            if (!Auth::user()->google2fa_secret) {
                Auth::user()->google2fa_secret = $google2fa->generateSecretKey();
                Auth::user()->save();
            }

            // Generate the QR Code
            $QR_Image = $google2fa->getQRCodeInline(
                config('app.name'), // site name
                $this->user->email, //admin email
                $this->user->google2fa_secret //2fa code
            );
        }

        //current session
        $currentSession = session()->getId();



        return view('admin.settings.account.security')->with([
            'pageName' => 'Account Security Settings',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'QR_Image' => $QR_Image,
            'currentSession' => $currentSession,
            'sessions' => $sessions = DB::table('sessions')
                ->where('user_id', $this->user->id)
                ->orderByRaw("CASE WHEN id = ? THEN 0 ELSE 1 END, last_activity DESC", [$currentSession])
                ->paginate(10),
        ]);
    }

    //Setup two-factor authentication
    public function completeTwoFactorAuthenticationSetup(Request $request)
    {
        try {
            // Validate OTP input
            $validator = Validator::make($request->all(), [
                'otp' => ['required', 'numeric', 'digits:6']
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            // Ensure two-factor was not setup already
            if ($this->user->two_factor){
                return $this->sendError('two_factor.error', ['error' => 'You have already setup your two-factor authentication']);
            }

            //start db transaction
            DB::beginTransaction();

            // Verify OTP using Google2FA
            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($this->user->google2fa_secret, $request->otp);

            if (!$valid) {
                return $this->sendError('two_factor.error', ['error' => 'Invalid token supplied.']);
            }

            //update the two factor
            $this->user->update([
                'two_factor' => true,
                'recovery_code' => $this->user->generateRecoveryCode(30)
            ]);

            // Send notification about this
            Mail::to($this->user->email)->send(new TwoFAActivatedMailable($this->user));

            //Create a record of this activity
            StaffActivityLog::create([
                'user_id' => $this->user->id,
                'action' => 'Two-factor authentication',
                'description' => "Two-factor authentication for {$this->user->email}",
                'ip' => $request->ip(),
            ]);

            DB::commit();

            return $this->sendResponse([
                'redirectTo' => url()->previous(),
            ], 'Two-factor authentication completed successfully.');

        }catch (\Exception $e) {
            //Rollback transaction if error occurs
            DB::rollBack();

            \Log::error('Two-Factor Setup Error: ' . $e->getMessage());

            return $this->sendError('authentication.error', ['error' => 'An unexpected error occurred. Please try again later.']);
        }
    }

    /**
     * Verify user password and return the recovery phrase.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecoveryCode(Request $request)
    {
        // Validate input
        $request->validate([
            'password' => 'required|string',
        ]);
        // Get authenticated user
        $user = Auth::user();

        //verify two-factor authentication code
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($this->user->google2fa_secret, $request->password);

        // Verify password
        if (!$valid) {
            return response()->json(['message' => 'Incorrect OTP.'], 401);
        }

        // Return recovery phrase
        return response()->json([
            'recovery_phrase' => $user->recovery_code,
            'message' => 'Recovery phrase retrieved successfully.',
        ]);
    }
    //Update password
    public function updatePassword(Request $request)
    {
        try {
            // Validate OTP input
            $validator = Validator::make($request->all(), [
                'otp' => ['required', 'numeric', 'digits:6'],
                'currentPassword'=>['required', 'string','current_password:web'],
                'newPassword' => ['required', 'string', 'min:8', 'confirmed'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            // Ensure two-factor is setup already
            if (!$this->user->two_factor) {
                return $this->sendError('two_factor.error', ['error' => 'You must activate two-factor authentication first.']);
            }

            //start db transaction
            DB::beginTransaction();

            // Verify OTP using Google2FA
            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($this->user->google2fa_secret, $request->otp);

            if (!$valid) {
                return $this->sendError('two_factor.error', ['error' => 'Invalid token supplied.']);
            }

            //update the two factor
            $this->user->update([
                'password' => Hash::make($request->newPassword),
            ]);

            //send password change notification
            $this->user->sendPasswordChangedNotification($request);

            //logout other sessions if activate
            if ($request->has('logout_sessions')){
                Auth::logoutOtherDevices($request->newPassword);
            }

            //commit to db
            DB::commit();

            //send response
            return $this->sendResponse([
                'redirectTo' => url()->previous(),
            ],'Password updated successfully.');

        }catch (\Exception $e) {
            //Rollback transaction if error occurs
            DB::rollBack();

            \Log::error('Password update Error: ' . $e->getMessage());

            return $this->sendError('password.error', ['error' => 'An unexpected error occurred. Please try again later.']);
        }
    }
}
