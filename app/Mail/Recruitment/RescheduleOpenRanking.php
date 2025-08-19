<?php

namespace App\Mail\Recruitment;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class RescheduleOpenRanking extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data = [];
    protected $job_title = '';
    protected $place_of_assignment = '';
   public $date = '';
    public function __construct($data,$date)
    {
        $this->data = $data;
        $this->date = $date;
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
            subject: "RECHEDULING OF ASSESSMENT AND OPEN RANKING FOR THE $title POSITION IN THE $place_of_assignment",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.recruitment.reschedule_open_ranking',
            with:[
                'data' => $this->data,
                'job_title' => $this->job_title,
                'place_of_assignment' => $this->place_of_assignment,
                'time' =>$this->date,
                'date' => $this->date,
                'venue' => $this->data['jobOtherInformation']['venue'],
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
