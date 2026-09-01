<?php

namespace App\Http\Controllers;

use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->merge([
            'phone_normalised' => preg_replace('/^91(?=\d{10}$)/', '',
                preg_replace('/\D+/', '', (string) $request->input('phone'))),
        ]);

        $validated = $request->validate([
            'name'             => ['required', 'string', 'min:2', 'max:120'],
            'phone_normalised' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'email'            => ['required', 'email', 'max:190'],
            'service'          => ['required', 'string', 'max:120'],
            'message'          => ['nullable', 'string', 'max:2000'],
            'source_url'       => ['nullable', 'string', 'max:255'],
        ], [
            'phone_normalised.regex' => 'Please enter a valid 10-digit mobile number.',
            'phone_normalised.required' => 'Please enter a valid 10-digit mobile number.',
        ]);

        $enquiry = Enquiry::create([
            'name'         => $validated['name'],
            'phone'        => $validated['phone_normalised'],
            'email'        => $validated['email'],
            'service'      => $validated['service'],
            'message'      => $validated['message'] ?? null,
            'source_url'   => $validated['source_url'] ?? $request->headers->get('referer'),
            'page_context' => $request->input('service'),
            'status'       => 'new',
            'ip'           => $request->ip(),
            'user_agent'   => substr((string) $request->userAgent(), 0, 255),
        ]);

        try {
            Mail::to(config('site.email'))->send(new EnquiryReceived($enquiry));
        } catch (\Throwable $e) {
            report($e);
        }

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'message' => 'Your enquiry has been recorded.']);
        }

        return back()->with('enquiry_sent', true);
    }
}
