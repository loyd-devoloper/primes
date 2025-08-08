<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        *{
            color: black;
            font-weight: 400;
        }

        .container{
           max-width: 60rem;
        }
    </style>
</head>
<body>



<div class="container">
    <p>Dear Applicants,</p>
    <p>Good day!</p>
    <p>Your application for the <span style="font-weight: bold">{{ $job_title }}</span> in the  <span style="font-weight: bold">{{ $place_of_assignment }}</span> has been submitted.
    </p>
    <p>
        Please be informed that the Human Resource Merit Promotion and Selection Board
        (HRMPSB) shall convene with the applicants for the <span style="font-weight: bold">{{ $job_title }}</span> position <span style="font-weight: bold">{{ $data->jobInfo?->plantilla_item }}</span> in the <span style="font-weight: bold">{{ $place_of_assignment }}</span>, this Office, on <span style="font-weight: bold">{{ \Carbon\Carbon::parse($data->jobOtherInformation?->open_ranking)->format('M d, Y') }}</span> from <span style="font-weight: bold">{{ \Carbon\Carbon::parse($data->jobOtherInformation?->open_ranking)->format('h:i:s A') }}</span> onwards at the
        <span style="font-weight: bold">{{$venue}}</span>.
    </p>
    <p>Relative to this, please report at the Office (a face-to-face activity) on the abovementioned
        schedule for the Assessment and Open Ranking of applicants for the <span style="font-weight: bold">{{ $job_title }}</span>
        position.</p>
    <p>Kindly acknowledge this e-mail as confirmation of your attendance.</p>
    <p>Non-participation in the scheduled activity shall mean disqualification.</p>


    <br>
    <p  style="font-weight: bold">REMINDER: Please bring the original copies of your submitted application documents
        for validation of its authenticity and veracity. Additional document/s will not be
        accepted by the Board during the assessment proper.</p>
    <p>Thank you and God bless.</p>


    <div>
        <p><span  style="font-weight: bold">HRMPSB Secretariat</span> <br>Personnel Section <br>DepEd Region IV-A CALABARZON <br>Gate 2, Karangalan Village <br>Cainta, Rizal</p>

    </div>
   </div>
</body>
</html>

