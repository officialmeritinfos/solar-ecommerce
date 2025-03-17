<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\StaffActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class GeneralSettingsController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = Auth::user();
    }
    //landing page
    public function showGeneralSettings()
    {
        return view('admin.settings.general_settings')->with([
            'pageName' => 'General Settings',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'currencies'=>Country::where('status', 1)->groupBy('currency')->orderBy('currency')->get(),
        ]);
    }
    //update general Settings
    public function updateGeneralSettings(Request $request)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            // Fetch the first row of General Settings
            $settings = GeneralSetting::first();

            // If settings are not found, return an error response
            if (!$settings) {
                return $this->sendError('general.settings.error', [
                    'error'=>"General settings not found."
                ], 404);
            }
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phoneNumber' => 'nullable|string|max:20',
                'registrationNumber' => 'nullable|string|max:100',
                'maxFileUploadSize' => 'required|integer|min:1|max:' . (getServerLimitInKB()/1024), // Convert to MB
                'favicon' => 'nullable|image|mimes:jpeg,png,ico,jpeg|max:' . ($settings->file_upload_max_size), // Ensure max file size in KB
                'address' => 'nullable|string|max:500',
                'affiliate_bonus' => 'required|numeric|max:100',
                'oem_registration' => 'sometimes|boolean',
                'engineer_registration' => 'sometimes|boolean',
                'customer_registration' => 'sometimes|boolean',
                'affiliate_registration' => 'sometimes|boolean',
                'online_checkout' => 'sometimes|boolean',
                'maintenance_mode' => 'sometimes|boolean',
                'onlinePayout' => 'sometimes|boolean',
                'autoReferral' => 'sometimes|boolean',
                'password'=>['required','string', 'min:8','current_password:web'],
                'otp'=>['required','numeric','digits:6'],
                'currency'=>['required','string', 'exists:countries,currency']
            ],[],[
                'otp'=>'Two-factor authentication otp',
            ])->stopOnFirstFailure();

            // If validation fails, return a JSON response with error messages
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()], 422);
            }

            //verify two-factor authentication code
            $google2fa = app('pragmarx.google2fa');

            $valid = $google2fa->verifyKey($this->user->google2fa_secret, $request->otp);

            if (!$valid) {
                return $this->sendError('authentication.error', ['error' => 'Invalid token supplied.']);
            }

            // Update text-based fields
            $settings->name = $request->input('name');
            $settings->support_email = $request->input('email');
            $settings->support_phone = $request->input('phoneNumber');
            $settings->registration_number = $request->input('registrationNumber');
            $settings->file_upload_max_size = $request->input('maxFileUploadSize') * 1024; // Convert MB to KB
            $settings->address = $request->input('address');
            $settings->currency = $request->input('currency');
            $settings->affiliate_bonus = $request->input('affiliate_bonus');

            // Handle favicon upload in the `public` folder
            if ($request->hasFile('favicon')) {
                // Define the favicon directory path
                $faviconPath = public_path();

                // Delete old favicon if exists
                if ($settings->favicon && File::exists(public_path($settings->favicon))) {
                    File::delete(public_path($settings->favicon));
                }

                // Generate a unique file name
                $faviconFile = time() . '.' . $request->file('favicon')->getClientOriginalExtension();

                // Move the uploaded file to the `public/favicons/` directory
                $request->file('favicon')->move($faviconPath, $faviconFile);

                // Save the public path of the uploaded file
                $settings->favicon = $faviconFile;
            }

            // Handle boolean toggle fields
            $settings->oem_registration = $request->has('oem_registration') ? 1 : 0;
            $settings->engineer_registration = $request->has('engineer_registration') ? 1 : 0;
            $settings->customer_registration = $request->has('customer_registration') ? 1 : 0;
            $settings->affiliate_registration = $request->has('affiliate_registration') ? 1 : 0;
            $settings->online_checkout = $request->has('online_checkout') ? 1 : 0;
            $settings->maintenance_mode = $request->has('maintenance_mode') ? 1 : 0;
            $settings->autoReferral = $request->has('autoReferral')?1:0;
            $settings->onlinePayout = $request->has('onlinePayout')?1:0;

            // Save the updated settings
            $settings->save();

            //add the activity
            StaffActivityLog::create([
                'user_id' => $this->user->id,
                'ip_address' => $request->ip(),
                'action' => 'Updated general settings',
                'description' => "General settings updated by {$this->user->name}"
            ]);

            // Commit the database transaction
            DB::commit();

            // Prepare the response data
            $responseData = [
                'redirectTo'=>url()->previous(),
            ];

            // Return success response with updated settings
            return $this->sendResponse($responseData, 'General settings updated successfully.');

        }catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log the error for debugging (optional)
            \Log::error('General Settings Update Error: ' . $e->getMessage());

            // Return JSON error response
            return $this->sendError('An unexpected error occurred. Please try again later.', [], 500);
        }
    }
    //upload logo
    public function uploadLogo(Request $request)
    {
        try {
            $settings = GeneralSetting::first();

            // Validate the uploaded file
            $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg,ico,svg|max:' . ($settings->file_upload_max_size),
            ]);

            // Handle the file upload
            if ($request->hasFile('logo')) {

                // Define the logo directory path
                $logoPath = public_path();

                // Delete old logo if exists
                if ($settings->logo && File::exists(public_path($settings->logo))) {
                    File::delete(public_path($settings->logo));
                }

                // Generate a unique file name
                $logoFile = time() . '.' . $request->file('logo')->getClientOriginalExtension();

                // Move the uploaded file to the `public` directory
                $request->file('logo')->move($logoPath, $logoFile);

                // Save the public path of the uploaded file
                $settings->logo = $logoFile;
                $settings->save();

                $filePath = asset($logoFile); // Get public URL

                return response()->json([
                    'error' => 'ok',
                    'data' => ['logo_url' => $filePath],
                    'message' => 'Logo uploaded successfully.',
                ]);
            }

            return response()->json(['error' => 'upload.error', 'message' => 'No file uploaded.'], 400);
        } catch (\Exception $e) {
            \Log::error('Logo Upload Error: ' . $e->getMessage());

            return response()->json([
                'error' => 'upload.error',
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }
}
