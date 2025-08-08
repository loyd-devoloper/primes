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

        .application_code{
            background-color: rgb(21, 95, 130);
            width: fit-content;
            padding: 1rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>



<div class="container">
    <p> Dear Mr./Ms. {{ $data->lname }},</p>
    <p>Good day!</p>
    <p>Your application for the <span style="font-weight: bold">{{ $job_title }}</span> in the  <span style="font-weight: bold">{{ $place_of_assignment }}</span> has been submitted.
    </p>
    <p>
        We have received you application on {{ $date }}, {{ $time }}.
    </p>
    <p>Here is your application code:</p>

    <div class="application_code">
        <p style="font-size: 1.5rem;font-weight:600;color:white">{{ $data->application_code }}</p>
    </div>
    <br>
        <p style="font-weight: 600">You can access the link below to update your application if needed:</p>
        <br>
        <a target="_blank" href="{{ $link }}">->{{ $link }}</a>
        <p style="font-weight: bold">
         Please take note that updating of application can only be done until {{ $closing_date }}. No
            additional documents shall be entertained after the deadline of submission.
        </p>
    <br>
    <p>You will receive an email for the status of your application.</p>
    <p>Thank you and God bless.</p>
    <p>Very truly yours,</p>

    <div>
        <p><span  style="font-weight: bold">HRMPSB Secretariat</span> <br>Personnel Section <br>DepEd Region IV-A CALABARZON <br>Gate 2, Karangalan Village <br>Cainta, Rizal</p>

    </div>
   </div>
</body>
</html>

