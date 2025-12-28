<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    /**
     * Subscribe a new email
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|max:255',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address is too long.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first('email'),
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Check if already subscribed
        $existing = Subscriber::where('email', $request->email)->first();

        if ($existing) {
            if ($existing->status === 'active') {
                $message = 'You are already subscribed to our newsletter!';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                    ], 409);
                }
                return back()->with('info', $message);
            }

            // Resubscribe if previously unsubscribed
            if ($existing->status === 'unsubscribed') {
                $existing->resubscribe();
                $message = 'Welcome back! You have been resubscribed to our newsletter.';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => $message,
                    ]);
                }
                return back()->with('success', $message);
            }
        }

        // Create new subscriber
        Subscriber::create([
            'email' => $request->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $message = 'Thank you for subscribing! You will receive updates about new software releases and tutorials.';
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Unsubscribe via token link
     */
    public function unsubscribe(string $token)
    {
        $subscriber = Subscriber::where('token', $token)->first();

        if (!$subscriber) {
            return view('subscriber.unsubscribe', [
                'success' => false,
                'message' => 'Invalid unsubscribe link.',
            ]);
        }

        if ($subscriber->status === 'unsubscribed') {
            return view('subscriber.unsubscribe', [
                'success' => true,
                'message' => 'You have already been unsubscribed.',
            ]);
        }

        $subscriber->unsubscribe();

        return view('subscriber.unsubscribe', [
            'success' => true,
            'message' => 'You have been successfully unsubscribed from our newsletter.',
        ]);
    }
}
