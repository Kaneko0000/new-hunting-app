<?php

namespace App\Mail;

use App\Models\Hunter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewHunterNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $hunter;

    public function __construct()
    {
        $this->hunter = $hunter;
    }

    public function build()
    {
        return $this->subject('新しいハンターが登録されました')
                    ->view('emails.new_hunter_notification')
                    ->with(['hunter' => $this->hunter])
                    ->attach(storage_path('app/public/' . $this->hunter->license_image));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Hunter Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
