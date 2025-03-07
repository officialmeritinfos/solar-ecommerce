<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Rules\ReCaptcha;
use App\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;

class LoginController extends BaseController
{
    use UserTrait;

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
    public function login(Request $request)
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
                'g-recaptcha-response' => ['nullable', new ReCaptcha], // Optional reCAPTCHA validation
                'remember' => ['nullable'], // Optional "Remember Me" field
            ], [
                'g-recaptcha-response.required' => 'Recaptcha must be passed first.',
            ], [
                'g-recaptcha-response' => 'Recaptcha',
            ])->stopOnFirstFailure();

            // If validation fails, return a JSON response with error messages
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()], 422);
            }

            // Validate user credentials without logging in
            if (!Auth::validate([$fieldType => $input, 'password' => $request->password])) {
                return $this->sendError('login.error', ['error' => "Invalid $fieldLabel and password combination."]);
            }

            // Fetch the user based on email or phone number
            $user = User::where($fieldType, $input)->first();

            // Ensure the user account is active
            if (!$user->is_active) {
                return $this->sendError('login.error', ['error' => "Account is not active."]);
            }

            // Ensure the user's email is verified
            if (!$user->email_verified_at) {
                // Send an email verification notification
                Mail::to($user->email)->send(new VerifyEmail($user));

                // Store email in session for verification step
                session(['email_verify_email' => encrypt($user->email)]);

                return $this->sendResponse(
                    ['redirectTo' => route('verification.notice')],
                    'Please verify your email to proceed.'
                );
            }

            // Check if two-factor authentication (2FA) is enabled
            if ($user->two_factor) {
                // Store email and remember-me flag in session for 2FA step
                session([
                    'two_factor_email' => encrypt($user->email),
                    'remember' => $request->filled('remember'),
                ]);

                return $this->sendResponse([
                    'redirectTo' => route('two-factor')
                ], 'Please authenticate your login in the next step.');
            }

            // Login the user and persist the session based on the "remember me" checkbox
            Auth::login($user, $request->filled('remember'));

            //assign role to user
            $user->assignRole($user->role);

            // Send login attempt notification to the user
            $user->sendLoginNotification($request);

            // Get the intended URL if available, otherwise redirect to the user's dashboard
            $redirectUrl = Session::pull('url.intended', $user->getDashboardUrl());

            return $this->sendResponse([
                'redirectTo' => $redirectUrl
            ], 'Login successful');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Login Error: ' . $e->getMessage());

            // Return a generic error message to the user
            return $this->sendError('login.error', ['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
    //Logout
    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error','You need to login first');
        }
        // Logout user from web authentication
        Auth::logout();

        // Invalidate the session to prevent session reuse
        $request->session()->invalidate();

        // Regenerate the session token to prevent session fixation attacks
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success',__('You have been logged out successfully.'));
    }
}
