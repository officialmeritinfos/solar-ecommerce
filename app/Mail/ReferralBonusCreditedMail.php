<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReferralBonusCreditedMail extends Mailable
{
    use Queueable, SerializesModels;
    public User $affiliate;
    public float $amount;
    public mixed $note;

    /**
     * Create a new message instance.
     */
    public function __construct(User $affiliate,float $amount, $note = null)
    {
        $this->affiliate = $affiliate;
        $this->amount = $amount;
        $this->note = $note;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Referral Bonus Credited to Your Account',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.referral_bonus_credited',
            with: [
                'affiliate' => $this->affiliate,
                'amount' => $this->amount,
                'note' => $this->note,
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
