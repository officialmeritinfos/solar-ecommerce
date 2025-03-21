<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\HomeSlider;
use App\Models\StaffActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class HomeSliderController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = Auth::user();
    }
    //landing page
    public function showSliders()
    {
        return view('admin.settings.home_sliders.index')->with([
            'pageName' => 'Home Sliders',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'sliders'  => HomeSlider::orderBy('id', 'desc')->get(),
        ]);
    }
    //show new slider form
    public function showNewSliderForm()
    {
        return view('admin.settings.home_sliders.new')->with([
            'pageName' => 'New Home Slider',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
        ]);
    }

    //process new slider
    public function processNewSlider(Request $request)
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
                'backgroundText' => 'nullable|string|max:255',
                'linkText' => 'required|string|max:255',
                'link' => 'nullable|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,avif,jpeg,webp|max:' . ($settings->file_upload_max_size), // Ensure max file size in KB
                'description'=>['required','string'],
            ],[],[
                'title'=>'Title',
                'backgroundText'=>'Background Text',
                'linkText'=>'Link Text',
                'link'=>'Link',
                'description'=>'Description',
            ])->stopOnFirstFailure();

            // If validation fails, return a JSON response with error messages
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()], 422);
            }


            // Handle favicon upload in the `public` folder
            if ($request->hasFile('photo')) {
                // Define the favicon directory path
                $photoPath = public_path('uploads/home_sliders/');

                // Generate a unique file name
                $faviconFile = time() . '.' . $request->file('photo')->getClientOriginalExtension();

                // Move the uploaded file to the `public/favicons/` directory
                $request->file('photo')->move($photoPath, $faviconFile);

                // Save the public path of the uploaded file
                $photo = 'uploads/home_sliders/'.$faviconFile;
            }

            $slider = HomeSlider::create([
                'title' => $request->title,
                'photo' => $photo,
                'link_url' => $request->link,
                'background_text' => $request->backgroundText,
                'description' => $request->description,
                'link_text' => $request->linkText,
                'active' => true
            ]);

            //add the activity
            StaffActivityLog::create([
                'user_id' => $this->user->id,
                'ip_address' => $request->ip(),
                'action' => 'Added Home slider',
                'description' => "A Home slider was added by {$this->user->name}"
            ]);

            // Commit the database transaction
            DB::commit();

            // Prepare the response data
            $responseData = [
                'redirectTo'=>route('admin.settings.home-sliders'),
            ];

            // Return success response with updated settings
            return $this->sendResponse($responseData, 'Home Slider Successfully created.');

        }catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log the error for debugging (optional)
            \Log::error('Home slider Error: ' . $e->getMessage());

            // Return JSON error response
            return $this->sendError('An unexpected error occurred. Please try again later.', [
                'error' => $e->getMessage()
            ], 500);
        }
    }
    //show edit slider form
    public function showEditSliderForm($id)
    {
        $slider = HomeSlider::find($id);
        return view('admin.settings.home_sliders.edit')->with([
            'pageName' => 'Edit Home Slider',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'slider'   => $slider,
        ]);
    }
    //process new slider
    public function processEditSlider(Request $request, $id)
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

            //slider
            $slider = HomeSlider::findOrFail($id);

            // Validate the request data
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'backgroundText' => 'nullable|string|max:255',
                'linkText' => 'required|string|max:255',
                'link' => 'nullable|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,avif,jpeg,webp|max:' . ($settings->file_upload_max_size), // Ensure max file size in KB
                'description'=>['required','string'],
            ],[],[
                'title'=>'Title',
                'backgroundText'=>'Background Text',
                'linkText'=>'Link Text',
                'link'=>'Link',
                'description'=>'Description',
            ])->stopOnFirstFailure();

            // If validation fails, return a JSON response with error messages
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()], 422);
            }


            $photo = $slider->photo;
            // Handle favicon upload in the `public` folder
            if ($request->hasFile('photo')) {
                // Define the favicon directory path
                $photoPath = public_path('uploads/home_sliders/');

                // Generate a unique file name
                $faviconFile = time() . '.' . $request->file('photo')->getClientOriginalExtension();

                // Move the uploaded file to the `public/favicons/` directory
                $request->file('photo')->move($photoPath, $faviconFile);

                // Save the public path of the uploaded file
                $photo = 'uploads/home_sliders/'.$faviconFile;
            }

            $slider->update([
                'title' => $request->title,
                'photo' => $photo,
                'link_url' => $request->link,
                'background_text' => $request->backgroundText,
                'description' => $request->description,
                'link_text' => $request->linkText,
                'active' => true
            ]);

            //add the activity
            StaffActivityLog::create([
                'user_id' => $this->user->id,
                'ip_address' => $request->ip(),
                'action' => 'Updated Home slider',
                'description' => "A Home slider was updated by {$this->user->name}"
            ]);

            // Commit the database transaction
            DB::commit();

            // Prepare the response data
            $responseData = [
                'redirectTo'=>route('admin.settings.home-sliders'),
            ];

            // Return success response with updated settings
            return $this->sendResponse($responseData, 'Home Slider Successfully updated.');

        }catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log the error for debugging (optional)
            \Log::error('Home slider Error: ' . $e->getMessage());

            // Return JSON error response
            return $this->sendError('An unexpected error occurred. Please try again later.', [
                'error' => $e->getMessage()
            ], 500);
        }
    }
    //delete home slider
    public function deleteHomeSlider($id)
    {
        $slider = HomeSlider::findOrFail($id);

        //delete file if it exists
        if (File::exists(public_path($slider->photo))) {
            unlink(public_path($slider->photo));
        }

        $slider->delete();

        StaffActivityLog::create([
            'user_id' => $this->user->id,
            'ip_address' => request()->ip(),
            'action' => 'Deleted Home Slider',
            'description' => "A Home slider was deleted by {$this->user->name}",
            'user_agent' => request()->userAgent()
        ]);

        return back()->with('success', 'Home Slider successfully deleted.');

    }
}
