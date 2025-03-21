<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\StaffActivityLog;
use App\Models\UseCaseSolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SolutionsController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = Auth::user();
    }
    //landing page
    public function showSliders()
    {
        return view('admin.settings.solutions.index')->with([
            'pageName' => 'Solutions',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'solutions'  => UseCaseSolution::orderBy('id', 'desc')->get(),
        ]);
    }
    //show new solution form
    public function showNewSolutionForm()
    {
        return view('admin.settings.solutions.new')->with([
            'pageName' => 'New Solution',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
        ]);
    }

    //process new solution
    public function processNewSolution(Request $request)
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
                'contents'=>['required','string'],
            ],[],[
                'title'=>'Title',
                'contents'=>'Content',
            ])->stopOnFirstFailure();

            // If validation fails, return a JSON response with error messages
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()], 422);
            }


            // Handle favicon upload in the `public` folder
            if ($request->hasFile('photo')) {
                // Define the favicon directory path
                $photoPath = public_path('uploads/solutions/');

                // Generate a unique file name
                $faviconFile = time() . '.' . $request->file('photo')->getClientOriginalExtension();

                // Move the uploaded file to the `public/favicons/` directory
                $request->file('photo')->move($photoPath, $faviconFile);

                // Save the public path of the uploaded file
                $photo = 'uploads/solutions/'.$faviconFile;
            }

            $slider = UseCaseSolution::create([
                'title' => $request->title,
                'photo' => $photo,
                'contents' => $request->contents,
                'status' => true
            ]);

            //add the activity
            StaffActivityLog::create([
                'user_id' => $this->user->id,
                'ip_address' => $request->ip(),
                'action' => 'Added Solutions',
                'description' => "A Solution was added by {$this->user->name}"
            ]);

            // Commit the database transaction
            DB::commit();

            // Prepare the response data
            $responseData = [
                'redirectTo'=>route('admin.settings.solutions'),
            ];

            // Return success response with updated settings
            return $this->sendResponse($responseData, 'Solution Successfully created.');

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
    //show edit  form
    public function showEditForm($id)
    {
        $solution = UseCaseSolution::find($id);
        return view('admin.settings.solutions.edit')->with([
            'pageName' => 'Edit Solution',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'solution'   => $solution,
        ]);
    }
    //process edit
    public function processEditForm(Request $request, $id)
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

            //solution
            $solution = UseCaseSolution::findOrFail($id);

            // Validate the request data
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,avif,jpeg,webp|max:' . ($settings->file_upload_max_size), // Ensure max file size in KB
                'contents'=>['required','string'],
            ],[],[
                'title'=>'Title',
                'contents'=>'Contents',
            ])->stopOnFirstFailure();

            // If validation fails, return a JSON response with error messages
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()], 422);
            }


            $photo = $solution->photo;
            // Handle favicon upload in the `public` folder
            if ($request->hasFile('photo')) {
                // Define the favicon directory path
                $photoPath = public_path('uploads/solutions/');

                // Generate a unique file name
                $faviconFile = time() . '.' . $request->file('photo')->getClientOriginalExtension();

                // Move the uploaded file to the `public/favicons/` directory
                $request->file('photo')->move($photoPath, $faviconFile);

                // Save the public path of the uploaded file
                $photo = 'uploads/solutions/'.$faviconFile;
            }

            $solution->update([
                'title' => $request->title,
                'photo' => $photo,
                'status' => true,
                'contents' => $request->contents,
            ]);

            //add the activity
            StaffActivityLog::create([
                'user_id' => $this->user->id,
                'ip_address' => $request->ip(),
                'action' => 'Updated Solution',
                'description' => "A Solution Usecase was updated by {$this->user->name}"
            ]);

            // Commit the database transaction
            DB::commit();

            // Prepare the response data
            $responseData = [
                'redirectTo'=>route('admin.settings.solutions'),
            ];

            // Return success response with updated settings
            return $this->sendResponse($responseData, 'Solution Successfully updated.');

        }catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log the error for debugging (optional)
            \Log::error('Solution Error: ' . $e->getMessage());

            // Return JSON error response
            return $this->sendError('An unexpected error occurred. Please try again later.', [
                'error' => $e->getMessage()
            ], 500);
        }
    }
    //delete
    public function deleteSolution($id)
    {
        $solution = UseCaseSolution::findOrFail($id);

        //delete file if it exists
        if (File::exists(public_path($solution->photo))) {
            unlink(public_path($solution->photo));
        }

        $solution->delete();

        StaffActivityLog::create([
            'user_id' => $this->user->id,
            'ip_address' => request()->ip(),
            'action' => 'Deleted Solution',
            'description' => "A Solution was deleted by {$this->user->name}",
            'user_agent' => request()->userAgent()
        ]);

        return back()->with('success', 'Solution successfully deleted.');

    }
}
