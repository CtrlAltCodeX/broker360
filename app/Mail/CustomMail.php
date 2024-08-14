<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message = "";
    protected $attachment;

    /**
     * Create a new message instance.
     */
    public function __construct(protected $data, $attachment = null)
    {
        $this->message = (string) $this->data['message'];

        $this->attachment = $attachment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        if (isset($this->data['collaboration'])) {
            $email = $this->view('emails.collaboration');
        } else {
            $email = $this->view('emails.custom')
                ->with('data', $this->message);
        }

        if ($this->attachment) {
            $email->attach($this->attachment->getPathname(), [
                'as' => $this->attachment->getClientOriginalName(),
                'mime' => $this->attachment->getMimeType(),
            ]);
        }

        return $email;
    }
}
