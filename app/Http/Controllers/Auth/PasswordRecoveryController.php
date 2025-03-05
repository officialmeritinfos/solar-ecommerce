<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordRecoveryController extends BaseController
{
    //show account recovery page
    public function showPasswordRecoveryForm()
    {
        return view('auth.recover_password')->with([
            'pageName' => 'Forgotten Password',
            'web'      =>  GeneralSetting::first(),
            'siteName' =>  GeneralSetting::first()->name,
        ]);
    }
    // Process Password Recovery Request (Forgot Password)
    public function processPasswordRecoveryRequest(Request $request)
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
                            $fail("The $fieldLabel must be a valid phone number");
                        }
                    },
                    function ($attribute, $value, $fail) use ($fieldType, $fieldLabel) {
                        // Ensure the email or phone number exists in the database
                        if (!User::where($fieldType, $value)->exists()) {
                            $fail("No account found with this $fieldLabel.");
                        }
                    }
                ],
            ])->stopOnFirstFailure();

            // If validation fails, return a JSON response with error messages
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()], 422);
            }

            // Retrieve user by email or phone number
            $user = User::where($fieldType, $input)->first();

            // Ensure the user has a valid email before attempting reset
            if (!$user->email) {
                return $this->sendError('error', ['error' => 'This account does not have a valid email associated with it.']);
            }

            // Attempt to send reset link (Using Laravel's built-in password reset functionality)
            $status = Password::sendResetLink(['email' => $user->email]);

            // Check if reset link was sent successfully
            if ($status !== Password::RESET_LINK_SENT) {
                return $this->sendError('error', ['error' => __('We could not send a reset link. Please check the email provided.')]);
            }

            // Store the encrypted email in session for tracking
            session([
                'password_recovery_email' => encrypt($user->email),
            ]);

            return $this->sendResponse([
                'redirectTo' => route('account-recovery.reset-notice')
            ], __('A password reset link has been sent to your email.'));

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Password Recovery Request Error: ' . $e->getMessage());

            return $this->sendError('recovery_code.error', ['error' => __('An unexpected error occurred. Please try again later.')], 500);
        }
    }

    //show reset notice to also request for password reset again
    public function showPasswordRecoveryNotice()
    {
        if (!session()->has('password_recovery_email')){
            return redirect()->route('login')->with('error','Verification session already expired.');
        }

        return view('auth.password_verify_notice')->with([
            'web'       => GeneralSetting::first(),
            'siteName'  => GeneralSetting::first()->name,
            'pageName'  => 'Request Verification Required.',
        ]);
    }
    //resend password verification
    public function resendPasswordVerification(Request $request)
    {
        $encryptedEmail = session('password_recovery_email');
        $email = decrypt($encryptedEmail);
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 401);
        }
        // Attempt to send reset link (Using Laravel's built-in password reset functionality)
        $status = Password::sendResetLink(['email' => $user->email]);

        // Check if reset link was sent successfully
        if ($status !== Password::RESET_LINK_SENT) {
            return response()->json(['message' => __('We could not send a reset link. Please check the email provided.')], 400);
        }
        return response()->json(['message' => 'Reset Link resent successfully']);
    }
    //show password reset form
    public function showPasswordResetForm(Request $request)
    {
        $email = $request->get('email');
        $token = $request->get('token');

        if (!$email || !$token) {
            return redirect()->route('login')->with('error','Email address or Token is invalid.');
        }

        return view('auth.reset_password')->with([
            'web'       => GeneralSetting::first(),
            'siteName'  => GeneralSetting::first()->name,
            'pageName'  => 'Password Reset',
            'token'     => $token,
            'email'     => $email,
        ]);
    }
    //reset password
    public function resetPassword(Request $request)
    {
        try {
            // Validate input fields
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:8|confirmed',
            ], [
                'password.confirmed' => 'Confirm Password did not match.',
            ])->stopOnFirstFailure();

            // If validation fails, return a JSON response with error messages
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()], 422);
            }

            // Attempt password reset
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) use ($request) {
                    // Update user password securely
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60)
                    ])->save();

                    // Send password change notification
                    $user->sendPasswordChangedNotification($request);
                }
            );

            // Check if password reset was successful
            if ($status !== Password::PASSWORD_RESET) {
                \Log::error('Password Reset Error: ' . __($status));
                return $this->sendError('password_reset.error', ['error' => __('An error occurred. Please try again.')], 500);
            }

            Session::forget('password_recovery_email');
            return $this->sendResponse([
                'redirectTo' => route('login')
            ], __('Your password has been successfully reset. You can now log in.'));

        } catch (\Exception $e) {
            \Log::error('Password Reset Exception: ' . $e->getMessage());

            return $this->sendError('password_reset.error', ['error' => __('An unexpected error occurred. Please try again later.')], 500);
        }
    }

}
