<?php

namespace App\Mail\Recruitment;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationLetter extends Mailable
{
    use Queueable, SerializesModels;

    public $record = [];
    public $position = '';
    public $place_of_assignment = '';
    public $file = '';
    /**
     * Create a new message instance.
     */
    public function __construct($record)
    {
        $this->record = $record;
       $this->position =$record?->jobInfo?->job_title;
       $this->place_of_assignment = $record?->jobInfo?->place_of_assignment;
       $this->file = $record?->batchInfo?->notification_letter;

    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "NOTIFICATION LETTER ON THE COMPLIANCE OF REQUIREMENTS FOR APPOINTMENT, $this->position - $this->place_of_assignment",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.recruitment.notification_letter',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromStorage("public/$this->file")
        ];
    }
}
