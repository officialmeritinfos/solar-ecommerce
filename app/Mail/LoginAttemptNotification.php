<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginAttemptNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ipAddress;
    public $location;
    public $device;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $ipAddress, $location, $device)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
        $this->location = $location;
        $this->device = $device;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Login Attempt on Your Account',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.login_notification_mail',
            with: [
                'name' => $this->user->name,
                'ipAddress' => $this->ipAddress,
                'location' => $this->location,
                'device' => $this->device,
                'dateTime' => now()->format('F j, Y, g:i A'),
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
