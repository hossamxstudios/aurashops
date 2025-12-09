<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ClientPasswordResetController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function showLinkRequestForm()
    {
        return view('website.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email address',
        ]);

        $status = Password::broker('clients')->sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('success', 'Password reset link has been sent to your email')
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Unable to send password reset link']);
    }
}
