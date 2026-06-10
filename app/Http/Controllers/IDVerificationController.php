<?php

namespace App\Http\Controllers;

use App\Mail\IDVerificationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class IDVerificationController extends Controller
{
    // NO CONSTRUCTOR NEEDED - Laravel 12 doesn't use middleware() in constructor
    // The route already has 'auth' middleware applied

    // Show ID upload form
    public function show()
    {
        return view('profile.id-verification');
    }

    // Upload ID for verification
    public function upload(Request $request)
    {
        $request->validate([
            'id_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        if ($user->id_photo_path && Storage::disk('public')->exists($user->id_photo_path)) {
            Storage::disk('public')->delete($user->id_photo_path);
        }

        $path = $request->file('id_photo')->store('student-ids', 'public');

        $user->update([
            'id_photo_path' => $path,
            'id_verification_status' => 'pending',
            'id_verification_notes' => null,
        ]);

        // Send confirmation email
        try {
            Mail::to($user->email)->send(new IDVerificationNotification($user, 'submitted'));
        } catch (\Exception $e) {
            \Log::error('Failed to send ID verification email: '.$e->getMessage());
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Student ID submitted for verification. Admin will review within 24 hours.');
    }

    // Resubmit ID (if rejected)
    public function resubmit(Request $request)
    {
        return $this->upload($request);
    }
}
