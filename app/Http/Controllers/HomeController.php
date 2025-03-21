<?php

namespace App\Http\Controllers;

use App\Mail\CustomMail;
use App\Models\About;
use App\Models\Faq;
use App\Models\GeneralSetting;
use App\Models\UseCaseSolution;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends BaseController
{
    //landing page
    public function index()
    {
        return view('home.home')->with([
            'pageName' => "Solar and Renewable Energy Services & Products",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'faqs'     => Faq::take(5)->get(),
        ]);
    }
    //about
    public function aboutPage()
    {
        return view('home.about')->with([
            'pageName' => "About ".GeneralSetting::first()->name,
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'about'    => About::where('id',1)->first(),
        ]);
    }
    //solutions
    public function solutions()
    {
        return view('home.solutions')->with([
            'pageName' => "Solutions",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'solutions'=> UseCaseSolution::get()
        ]);
    }
    //solutions detail
    public function solutionDetail($id)
    {
        $solution = UseCaseSolution::findOrFail($id);

        return view('home.solution_details')->with([
            'pageName' => "{$solution->title}",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'solution' => $solution,
        ]);
    }
    //FAQs
    public function faqs()
    {
        return view('home.faqs')->with([
            'pageName' => "Frequently Asked Questions",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
        ]);
    }
    //contact us page
    public function contactUs()
    {
        return view('home.contact')->with([
            'pageName' => "Contact Us",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
        ]);
    }
    //process form submission
    public function processFormSubmission(Request $request)
    {
        // Step 1: Validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string',
            'g-recaptcha-response' => ['nullable', new ReCaptcha],
        ], [
            'g-recaptcha-response.required'=>'Recaptcha must be passed first.',
        ],[
            'g-recaptcha-response' => 'Recaptcha',
        ])->stopOnFirstFailure();

        // Step 2: If validation fails, return a JSON response with error messages
        if ($validator->fails()) {
            return $this->sendError('validation.error', ['error' => $validator->errors()->all()],422);
        }

        try {
            $content = "
    <div style=\"font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; padding: 20px;\">
        <h2 style=\"color: #3490dc;\">📩 New Contact Form Submission</h2>
        <p style=\"font-size: 16px; line-height: 1.6;\">
            You've just received a new message via the contact form. Below are the details:
        </p>

        <table cellpadding=\"10\" cellspacing=\"0\" border=\"0\" style=\"font-size: 15px;\">
            <tr>
                <td><strong>👤 Name:</strong></td>
                <td>{$request->input('name')}</td>
            </tr>
            <tr>
                <td><strong>📧 Email:</strong></td>
                <td>{$request->input('email')}</td>
            </tr>
            <tr>
                <td><strong>📝 Subject:</strong></td>
                <td>{$request->input('subject')}</td>
            </tr>
            <tr>
                <td><strong>💬 Message:</strong></td>
                <td style=\"white-space: pre-wrap;\">".nl2br(e($request->input('message')))."</td>
            </tr>
        </table>

        <p style=\"margin-top: 30px; font-size: 15px;\">
            Kindly respond to this inquiry as soon as possible. <br/>
            Thank you! 🙏
        </p>

        <hr style=\"margin: 30px 0; border: none; border-top: 1px solid #eee;\">
        <p style=\"font-size: 13px; color: #888;\">
            This is an automated message from your website's contact form.
        </p>
    </div>
";


            Mail::to('recipient@example.com')->send(new CustomMail($request->subject,$content));

            return $this->sendResponse([
                'redirectTo'=>url()->previous(),
            ],'Mail sent successfully');
        }catch (\Exception $e){
            logger($e->getMessage());

            return $this->sendError('error',['error'=>$e->getMessage()],500);
        }

    }
}
