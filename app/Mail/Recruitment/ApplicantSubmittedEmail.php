<?php

namespace App\Mail\Recruitment;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicantSubmittedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data = [];
    public $link = "";
    protected $job_title = '';
    protected $closing_date = '';
    protected $place_of_assignment = '';
    public function __construct($data,$link)
    {
        $this->link = $link;
        $this->data = $data;
        $this->closing_date = $data['jobInfo']['batchInfo']['closing_date'];
        $this->job_title = $this->data['jobInfo']['job_title'];
        $this->place_of_assignment = $this->data['jobInfo']['place_of_assignment'];

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $title = Str::upper($this->job_title);
        $place_of_assignment = Str::upper($this->place_of_assignment);
        return new Envelope(
            subject: "APPLICATION FOR THE $title POSITION IN THE $place_of_assignment",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.recruitment.applicationSubmitedEmail',
            with:[
                'data' => $this->data,
                'job_title' => $this->job_title,
                'closing_date' =>Carbon::parse($this->closing_date)->format('M d ,Y, \a\t h:i:s A'),
                'place_of_assignment' => $this->place_of_assignment,
                'time' =>Carbon::parse($this->data['created_at'])->format('h:i:s A'),
                'date' => Carbon::parse($this->data['created_at'])->format('Y-m-d'),
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
