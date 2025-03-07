<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends BaseController
{
    //show two-factor authentication form
    public function showTwoFactorForm()
    {
        if (!session()->has('two_factor_email')){
            return redirect()->route('login')->with('error','Authentication session already expired.');
        }

        return view('auth.two_factor')->with([
            'pageName' => 'Two-factor Authentication',
            'web'      =>  GeneralSetting::first(),
            'siteName' =>  GeneralSetting::first()->name,
        ]);
    }
    // Process Two-Factor Authentication (2FA)
    public function processTwoFactor(Request $request)
    {
        try {
            // Validate OTP input
            $validator = Validator::make($request->all(), [
                'otp' => ['required', 'numeric', 'digits:6']
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            // Ensure two-factor session exists
            if (!session()->has('two_factor_email')) {
                return $this->sendError('two_factor.error', ['error' => 'Authentication session already expired.']);
            }

            // Retrieve the user from session
            $email = decrypt(session('two_factor_email'));
            $user = User::where('email', $email)->first();

            if (!$user) {
                return $this->sendError('authentication.error', ['error' => 'We could not find this profile.']);
            }

            // Verify OTP using Google2FA
            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp);

            if (!$valid) {
                return $this->sendError('authentication.error', ['error' => 'Invalid token supplied.']);
            }

            // Authenticate the user and apply "Remember Me" if applicable
            Auth::login($user, session()->has('remember'));

            //assign role to user
            $user->assignRole($user->role);

            // Send login notification
            $user->sendLoginNotification($request);

            // Clear session variables related to two-factor authentication
            Session::forget(['two_factor_email', 'remember']);

            // Redirect to the intended page or default dashboard
            $redirectUrl = Session::pull('url.intended', $user->getDashboardUrl());

            return $this->sendResponse([
                'redirectTo' => $redirectUrl
            ], 'Login successful');

        } catch (\Exception $e) {
            \Log::error('Two-Factor Authentication Error: ' . $e->getMessage());

            return $this->sendError('authentication.error', ['error' => 'An unexpected error occurred. Please try again later.']);
        }
    }
    //show 2fa reset form
    public function show2FactorResetCode()
    {
        if (!session()->has('two_factor_email')){
            return redirect()->route('login')->with('error','Authentication session already expired.');
        }

        return view('auth.reset_two_factor')->with([
            'pageName' => 'Reset Two-factor Authentication',
            'web'      =>  GeneralSetting::first(),
            'siteName' =>  GeneralSetting::first()->name,
        ]);
    }
    // Process Two-Factor Authentication Reset
    public function processTwoFactorReset(Request $request)
    {
        try {
            // Determine whether the input is an email or phone number
            $input = $request->input('email-phone');
            $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
            $fieldLabel = $fieldType === 'email' ? 'Email' : 'Phone number';

            // Validate input fields
            $validator = Validator::make($request->all(), [
                'email-phone' => [
                    'required',
                    function ($attribute, $value, $fail) use ($fieldType, $fieldLabel) {
                        // Validate phone number format (10-15 digits)
                        if ($fieldType === 'phone_number' && !preg_match('/^\d{10,15}$/', $value)) {
                            $fail("The $fieldLabel must be a valid phone number.");
                        }
                    },
                    function ($attribute, $value, $fail) use ($fieldType, $fieldLabel) {
                        // Ensure the email or phone number exists in the database
                        if (!User::where($fieldType, $value)->exists()) {
                            $fail("No account found with this $fieldLabel.");
                        }
                    }
                ],
                'recovery_code' => ['required', 'string', 'max:255']
            ])->stopOnFirstFailure();

            // If validation fails, return a JSON response with error messages
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()], 422);
            }

            // Retrieve user by email or phone number
            $user = User::where($fieldType, $input)->first();

            // Validate the recovery code (must match stored recovery code)
            if (!hash_equals($user->recovery_code, trim($request->recovery_code))) {
                return $this->sendError('reset.error', ['error' => 'Invalid recovery code.']);
            }

            //Ensure user has two-factor authentication activated before trying
            if (!$user->two_factor){
                return $this->sendError('reset.error', ['error' => 'Two-factor authentication must be activated first.']);
            }

            // Start a database transaction to ensure data consistency
            DB::beginTransaction();

            // Send notification that 2FA has been disabled
            $user->sendTwoFactorDisabledNotification($request);

            // Generate a new Google 2FA secret key
            $google2fa = new Google2FA();

            // Reset two-factor authentication
            $user->update([
                'two_factor' => false,
                'google2fa_secret' => $google2fa->generateSecretKey(),
                'recovery_code' => $user->generateRecoveryCode(),
            ]);

            // Commit transaction after successful update
            DB::commit();

            return $this->sendResponse([
                'redirectTo' => route('login'),
            ], 'Two-factor authentication successfully disabled.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error for debugging
            \Log::error('Recovery Code Processing Error: ' . $e->getMessage());

            return $this->sendError('recovery_code.error', ['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }

}
