<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%')
                ->orWhere('student_id', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('university')) {
            $query->where('university_domain', $request->university);
        }

        $users = $query->latest()->paginate(20);
        $universities = User::distinct()->pluck('university_domain');

        return view('admin.users', compact('users', 'universities'));
    }

    public function toggleSuspend(User $user)
    {
        // Prevent admin from suspending themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot suspend yourself.');
        }

        $user->update(['is_suspended' => ! $user->is_suspended]);
        $status = $user->is_suspended ? 'suspended' : 'activated';

        return back()->with('success', "User {$status} successfully.");
    }

    public function verifySeller(User $user)
    {
        $user->update(['is_verified_seller' => true]);

        return back()->with('success', 'Seller verified successfully.');
    }

    public function makeAdmin(User $user)
    {
        // Prevent making yourself admin again
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You are already an admin.');
        }

        $user->update(['is_admin' => true]);

        return back()->with('success', 'Admin privileges granted.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    // Add these methods

    // Show pending ID verifications
    public function pendingVerifications()
    {
        $users = User::where('id_verification_status', 'pending')
            ->whereNotNull('id_photo_path')
            ->latest()
            ->paginate(20);

        return view('admin.pending-ids', compact('users'));
    }

    // Approve ID verification
    public function approveId(User $user)
    {
        $user->update([
            'id_verification_status' => 'approved',
            'id_verified_at' => now(),
            'is_verified_seller' => true, // Auto-verify as seller too
        ]);

        // Send email notification (we'll add this later)

        return back()->with('success', 'Student ID approved. User is now verified.');
    }

    // Reject ID verification
    public function rejectId(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $user->update([
            'id_verification_status' => 'rejected',
            'id_verification_notes' => $request->reason,
        ]);

        return back()->with('success', 'ID verification rejected. User notified.');
    }
}
