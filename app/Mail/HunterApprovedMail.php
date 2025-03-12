<?php

namespace App\Mail;

use App\Models\Hunter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HunterApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $hunter; // ✅ クラス内でプロパティを定義

    public function __construct(Hunter $hunter)
    {
        $this->hunter = $hunter;
    }

    public function build()
    {
        return $this->subject('【狩猟アプリ】登録が承認されました')
                    ->view('emails.hunter_approved') // 承認時のメールテンプレート
                    ->with(['hunter' => $this->hunter]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hunter Approved Notification',
        );
    }
    
    public function content(): Content
    {
        return new Content(
            view: 'emails.hunter_approved',
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
