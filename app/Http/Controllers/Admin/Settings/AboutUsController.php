<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\GeneralSetting;
use App\Models\StaffActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = Auth::user();
    }
    //landing page
    public function showForm()
    {
        return view('admin.settings.about_us')->with([
            'pageName' => 'About Page Setting',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'aboutUs'  => About::first(),
        ]);
    }
    //publish update
    public function update(Request $request)
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
                'title' => 'required|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,avif,jpeg,webp|max:' . ($settings->file_upload_max_size), // Ensure max file size in KB
                'content'=>['required','string'],
                'mission'=>['required','string'],
                'vision'=>['required','string'],
                'whyChooseUs'=>['required','string'],
            ],[],[
                'title'=>'Page Title',
                'whyChooseUs'=>'Why Choose Us',
            ])->stopOnFirstFailure();

            // If validation fails, return a JSON response with error messages
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()], 422);
            }


            // Handle favicon upload in the `public` folder
            if ($request->hasFile('photo')) {
                // Define the favicon directory path
                $photoPath = public_path('uploads/about_us/');

                // Generate a unique file name
                $faviconFile = time() . '.' . $request->file('photo')->getClientOriginalExtension();

                // Move the uploaded file to the `public/favicons/` directory
                $request->file('photo')->move($photoPath, $faviconFile);

                // Save the public path of the uploaded file
                $photo = 'uploads/about_us/'.$faviconFile;
            }

            $about = About::first();

            if (!$about) {
                $about = new About();
                $about->create([
                    'title' => $request->title,
                    'photo' => $photo,
                    'mission' => $request->mission,
                    'vision' => $request->vision,
                    'whyChooseUs' => $request->whyChooseUs,
                    'content' => $request->input('content')
                ]);
            }else{
                $about->update([
                    'title' => $request->title,
                    'photo' => $photo,
                    'mission' => $request->mission,
                    'vision' => $request->vision,
                    'whyChooseUs' => $request->whyChooseUs,
                    'content' => $request->input('content')
                ]);
            }

            //add the activity
            StaffActivityLog::create([
                'user_id' => $this->user->id,
                'ip_address' => $request->ip(),
                'action' => 'Updated About Us Page',
                'description' => "About us page was updated by {$this->user->name}"
            ]);

            // Commit the database transaction
            DB::commit();

            // Prepare the response data
            $responseData = [
                'redirectTo'=>url()->previous(),
            ];

            // Return success response with updated settings
            return $this->sendResponse($responseData, 'About Us Page successfully updated');

        }catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log the error for debugging (optional)
            \Log::error('About Us Page Error: ' . $e->getMessage());

            // Return JSON error response
            return $this->sendError('An unexpected error occurred. Please try again later.', [
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
