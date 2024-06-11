<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\VerifyEmail;

class AccountController extends Controller
{
    // Send a verification email to the authenticated user
    public function sendVerificationEmail(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->back()->with('message', 'Your email address is already verified.');
        }

        $user->sendEmailVerificationNotification();

        return redirect()->back()->with('message', 'Verification email sent successfully.');
    }
}