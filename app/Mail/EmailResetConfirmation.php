<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailResetConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        $confirmationUrl = route('email.reset.confirm', ['token' => $this->token]);

        return $this->subject('Email Reset Confirmation')
            ->view('admin.profile.email-reset-confirmation')
            ->with([
                'user' => $this->user,
                'confirmationUrl' => $confirmationUrl
            ]);
    }
}
