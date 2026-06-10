<?php

namespace App\Http\Controllers;

use App\Mail\IDVerificationNotification;
use Illuminate\Support\Facades\Mail;

class TestMailController extends Controller
{
    public function test()
    {
        $user = auth()->user();

        try {
            Mail::to($user->email)->send(new IDVerificationNotification($user, 'approved'));

            return 'Email sent successfully to '.$user->email;
        } catch (\Exception $e) {
            return 'Error: '.$e->getMessage();
        }
    }
}
