<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Show email verification notice
     */
    public function notice()
    {
        return view('auth.verify-email');
    }

    /**
     * Verify the user's email
     */
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Check if hash matches
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')->with('error', 'Invalid verification link.');
        }

        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('info', 'Email already verified.');
        }

        // Mark as verified
        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect()->route('dashboard')->with('success', 'Email verified successfully!');
    }

    /**
     * Resend verification email
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent!');
    }
}
