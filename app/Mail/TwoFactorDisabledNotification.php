<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorDisabledNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ipAddress;
    public $location;
    public $device;
    public $dateTime;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $ipAddress, $location, $device, $dateTime)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
        $this->location = $location;
        $this->device = $device;
        $this->dateTime = $dateTime;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Two-Factor Authentication Disabled',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.disabled_two_factor_mail',
            with: [
                'name' => $this->user->name,
                'ipAddress' => $this->ipAddress,
                'location' => $this->location,
                'device' => $this->device,
                'dateTime' => $this->dateTime,
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
