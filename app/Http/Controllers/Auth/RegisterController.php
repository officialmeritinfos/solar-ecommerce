<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;

class RegisterController extends BaseController
{
    //landing page
    public function showRegistrationForm()
    {
        return view('auth.register')->with([
            'pageName' => 'Register Account',
            'web'      =>  GeneralSetting::first(),
            'siteName' =>  GeneralSetting::first()->name,
        ]);
    }
    //process registration
    public function register(Request $request){

        //check that registration is activated
        if (!GeneralSetting::first()->customer_registration && !GeneralSetting::first()->affiliate_registration){
            return $this->sendError('validation.error', ['error' => 'Registration is not allowed'],422);
        }

        // Step 1: Validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone_number',
            'password' => 'required|min:6|confirmed',
            'terms' => 'accepted',
            'g-recaptcha-response' => ['nullable', new ReCaptcha],
        ], [
            'terms.accepted' => 'You must accept the privacy policy and terms before registering.',
            'g-recaptcha-response.required'=>'Recaptcha must be passed first.',
        ],[
            'g-recaptcha-response' => 'Recaptcha',
        ])->stopOnFirstFailure();

        // Step 2: If validation fails, return a JSON response with error messages
        if ($validator->fails()) {
            return $this->sendError('validation.error', ['error' => $validator->errors()->all()],422);
        }

        // Step 3: Start database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            $google2fa = app('pragmarx.google2fa');
            // Step 5: Create new user record in the database
            $user = User::create([
                'name' => trim($request->input('name')),
                'email' => strtolower($request->input('email')),
                'phone_number' => trim($request->input('phone')),
                'password' => Hash::make($request->input('password')),
                'google2fa_secret' =>$google2fa->generateSecretKey(),
            ]);
            // Send an email verification
            Mail::to($user->email)->send(new VerifyEmail($user));

            //set session
            session([
                'email_verify_email'=>encrypt($user->email),
            ]);

            // Step 7: Commit the transaction if everything is successful
            DB::commit();

            // Step 8: Return success response with user details
            return $this->sendResponse(
                ['redirectTo' => route('verification.notice')],
                'Account has been created successfully.',
            );

        } catch (\Exception $e) {
            // Step 9: Rollback transaction to prevent partial data insertion in case of error
            DB::rollBack();

            // Step 10: Log the error (Optional, if you have logging enabled)
            \Log::error('User Registration Failed: ' . $e->getMessage());

            // Step 11: Return a failure response with the error message
            return $this->sendError('registration.error',['error' => "An error occurred. We are rectifying this now."],500);
        }
    }
    //Verification notice
    public function showVerificationNotice()
    {
        if (!GeneralSetting::first()->customer_registration && !GeneralSetting::first()->affiliate_registration){
            abort(403,'Registration is not allowed');
        }
        if (!session()->has('email_verify_email')){
            return redirect()->route('login')->with('error','Verification session already expired.');
        }

        return view('auth.verification_notice')->with([
            'web'       => GeneralSetting::first(),
            'siteName'  => GeneralSetting::first()->name,
            'pageName'  => 'Email Verification Required.',
        ]);
    }
    public function resend(Request $request)
    {
        $encryptedEmail = session('email_verify_email');
        $email = decrypt($encryptedEmail);
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 401);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email already verified'], 400);
        }
        Mail::to($user->email)->send(new VerifyEmail($user));
        return response()->json(['message' => 'Verification email resent successfully']);
    }
    //verify email
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        //if user has been verified already, return to login with error
        if ($user->email_verified_at){
            return redirect()->to(route('login'))->with('error', 'Email already verified!');
        }

        // Ensure hash matches
        if (! hash_equals(sha1($user->email), $hash)) {
            abort(403, 'Invalid verification link.');
        }

        session()->remove('email_verify_email');
        $request->session()->invalidate();
        $request->session()->regenerate();

        // Mark email as verified
        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->save();
        }
        return redirect()->to(route('login'))->with('success', 'Email verified successfully!');
    }
    //sign up with Google - to be done in upgrade
    public function GoogleSignIn(Request $request)
    {

    }
}
