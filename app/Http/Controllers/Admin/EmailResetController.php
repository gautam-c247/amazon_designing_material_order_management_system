<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailResetConfirmation;
use App\Models\{User, EmailResetToken};

/**
 * Class EmailResetController
 *
 * This controller handles email reset requests for admin users.
 * It allows users to request an email change and confirm the update via a verification link.
 */
class EmailResetController extends Controller
{
    /**
     * Show the email reset form.
     *
     * @return \Illuminate\View\View
     */
    public function showEmailResetForm()
    {
        return view('admin.profile.email-reset');
    }

    /**
     * Handle the email reset request.
     *
     * Validates the input, generates a confirmation token, and sends a reset link to the old email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitEmailReset(Request $request)
    {
        // Validate the input
        $request->validate([
            'old_email' => 'required|email|exists:users,email',
            'new_email' => 'required|email|unique:users,email',
        ]);

        // Get the user by their old email
        $user = User::where('email', $request->old_email)->first();

        // Store the new email
        $user->new_email = $request->new_email;
        $user->save();

        // Generate a unique token
        $token = Str::random(60);

        // Store the token in the database
        EmailResetToken::create([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        // Send confirmation email to the old email address
        Mail::to($request->old_email)->send(new EmailResetConfirmation($user, $token));

        return back()->with('success',__('profile.email_reset_link'));
    }

    /**
     * Confirm the email reset and update the user's email.
     *
     * Validates the token, updates the email address, and removes the reset token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmEmailReset($token)
    {
        // Retrieve the token record
        $emailResetToken = EmailResetToken::where('token', $token)->firstOrFail();
        $user = User::findOrFail($emailResetToken->user_id);

        // Update user's email
        $user->email = $user->new_email;
        $user->new_email = null; // Clear the temporary email field
        $user->save();

        // Delete the token
        $emailResetToken->delete();
        return redirect()->route('admin.dashboard')->with('success', __('profile.email_update'));
    }
}
