<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TwoFAActivatedMailable extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $disable2FALink;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        // Generate Signed URL for Disabling 2FA (Expires in 30 Days)
        $this->disable2FALink = URL::signedRoute('2fa.disable', [
            'user' => $user->id
        ], Carbon::now()->addYears(5));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Two-Factor Authentication Enabled',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.2fa-activated',
            with: [
                'user' => $this->user,
                'disable2FALink' => $this->disable2FALink,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
