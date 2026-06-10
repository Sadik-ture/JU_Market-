<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UniversityRegistrationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(UniversityRegistrationRequest $request): RedirectResponse
    {
        // Extract university domain from email
        $emailParts = explode('@', $request->email);
        $universityDomain = $emailParts[1];

        $user = User::create([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'email' => $request->email,
            'university_domain' => $universityDomain,
            'department' => $request->department,
            'graduation_year' => $request->graduation_year,
            'id_verification_status' => '', // CHANGE THIS - was 'pending'
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
