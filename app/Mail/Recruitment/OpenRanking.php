<?php

namespace App\Mail\Recruitment;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class OpenRanking extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data = [];
    protected $job_title = '';
    protected $place_of_assignment = '';
    public function __construct($data)
    {
        $this->data = $data;
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
            subject: "NOTICE OF CONDUCT OF ASSESSMENT AND OPEN RANKING FOR THE $title POSITION IN THE $place_of_assignment",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails/recruitment/open_ranking',
            with:[
                'data' => $this->data,
                'job_title' => $this->job_title,
                'place_of_assignment' => $this->place_of_assignment,
                'time' =>Carbon::parse($this->data['jobOtherInformation']['open_ranking'])->format('h:i:s A'),
                'date' => Carbon::parse($this->data['jobOtherInformation']['open_ranking'])->format('Y-m-d'),
                'venue' => $this->data['jobOtherInformation']['venue'],
            ]
        );
    }

//    /**
//     * Get the attachments for the message.
//     *
//     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
//     */
//    public function attachments(): array
//    {
//        return [
////            Attachment::fromPath(public_path()."/excel/CAR - Copy.xlsx")
//            ,
//        ];
//    }
}
