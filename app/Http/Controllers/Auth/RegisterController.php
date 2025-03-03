<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            // Step 5: Create new user record in the database
            User::create([
                'name' => trim($request->input('name')),
                'email' => strtolower($request->input('email')),
                'phone_number' => trim($request->input('phone')),
                'password' => Hash::make($request->input('password')),
            ]);
            // Step 6: Assign default roles/permissions if needed (Optional)
            // $user->assignRole('customer');

            // Step 7: Commit the transaction if everything is successful
            DB::commit();

            // Step 8: Return success response with user details
            return $this->sendResponse(
                ['redirectTo' => route('login')],
                'Account has been created successfully.',
            );

        } catch (\Exception $e) {
            // Step 9: Rollback transaction to prevent partial data insertion in case of error
            DB::rollBack();

            // Step 10: Log the error (Optional, if you have logging enabled)
            \Log::error('User Registration Failed: ' . $e->getMessage());

            // Step 11: Return a failure response with the error message
            return $this->sendError('registration.error',['error' => $e->getMessage()],500);
        }
    }
    //sign up with Google - to be done in upgrade
    public function GoogleSignIn(Request $request)
    {

    }
}
