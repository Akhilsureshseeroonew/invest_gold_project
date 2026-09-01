<?php

namespace App\Http\Controllers;

use App\Mail\JobApplicationReceived;
use App\Models\JobApplication;
use App\Models\JobOpening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CareerController extends Controller
{
    public function show(JobOpening $job)
    {
        abort_unless($job->is_open, 404);

        return view('templates.careers-show', ['job' => $job]);
    }

    public function apply(Request $request, JobOpening $job)
    {
        abort_unless($job->is_open, 404);

        $request->merge([
            'phone_normalised' => preg_replace('/^91(?=\d{10}$)/', '',
                preg_replace('/\D+/', '', (string) $request->input('phone'))),
        ]);

        $validated = $request->validate([
            'name'             => ['required', 'string', 'min:2', 'max:120'],
            'email'            => ['required', 'email', 'max:190'],
            'phone_normalised' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'cv'               => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'source_url'       => ['nullable', 'string', 'max:255'],
        ], [
            'phone_normalised.regex'    => 'Please enter a valid 10-digit mobile number.',
            'phone_normalised.required' => 'Please enter a valid 10-digit mobile number.',
            'cv.required'               => 'Please attach your CV.',
            'cv.mimes'                  => 'Your CV must be a PDF or Word document.',
            'cv.max'                    => 'Your CV must be 5 MB or smaller.',
        ]);

        $file = $request->file('cv');
        $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'cv';
        $storedName = $job->slug.'-'.$safeName.'-'.now()->format('YmdHis').'-'.Str::random(6).'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('cvs/'.$job->slug, $storedName, 'local');

        $application = JobApplication::create([
            'job_opening_id' => $job->id,
            'job_title'      => $job->title,
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone_normalised'],
            'cv_path'        => $path,
            'cv_name'        => $file->getClientOriginalName(),
            'status'         => 'new',
            'source_url'     => $validated['source_url'] ?? $request->headers->get('referer'),
            'ip'             => $request->ip(),
            'user_agent'     => substr((string) $request->userAgent(), 0, 255),
        ]);

        try {
            Mail::to(config('site.email'))->send(new JobApplicationReceived($application));
        } catch (\Throwable $e) {
            report($e);
        }

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'message' => 'Your application has been received.']);
        }

        return back()->with('application_sent', true);
    }
}
