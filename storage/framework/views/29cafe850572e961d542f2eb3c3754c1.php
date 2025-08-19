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
    <p>
        Please be informed that the Human Resource Merit Promotion and Selection Board
        (HRMPSB) shall convene with the applicants for the <span style="font-weight: bold"><?php echo e($job_title); ?></span> position <span style="font-weight: bold"><?php echo e($data->jobInfo?->plantilla_item); ?></span> in the <span style="font-weight: bold"><?php echo e($place_of_assignment); ?></span>, this Office, on <span style="font-weight: bold"><?php echo e(\Carbon\Carbon::parse($date)->format('M d, Y')); ?></span> from <span style="font-weight: bold"><?php echo e(\Carbon\Carbon::parse($time)->format('h:i:s A')); ?></span> onwards at the
        <span style="font-weight: bold"><?php echo e($venue); ?></span>.
    </p>
    <p>Relative to this, please report at the Office (a face-to-face activity) on the abovementioned
        schedule for the Assessment and Open Ranking of applicants for the <span style="font-weight: bold"><?php echo e($job_title); ?></span>
        position.</p>
    <p style="font-weight: 600">Kindly take note on the following:</p>
    <ul style="color: red">
                 <li style="list-style-type: lower-alpha;font-weight: 600">
                     Non-participation in the scheduled activity shall mean disqualification.
                </li>
                <li style="list-style-type: lower-alpha;font-weight: 600">
                    Please bring the original copies of your submitted application documents for
                    validation of its authenticity and veracity. Additional document/s will not be accepted
                    by the Board during the assessment proper.
                </li>
    </ul>
    <br>
    <p  style="font-weight: 600; font-style: italic">This is an automatically generated email. To acknowledge and confirm your attendance on this activity, please email hrmpsb.calabarzon@deped.gov.ph.</p>

    <br>
    <p>Thank you.</p>
    <div>
        <p><span  style="font-weight: bold">HRMPSB Secretariat</span> <br><span  style="font-weight: bold"> Personnel Section</span> <br><span style="font-weight: bold">DepEd Region IV-A CALABARZON</span> <br>Gate 2, Karangalan Village <br>Cainta, Rizal</p>

    </div>
   </div>
</body>
</html>

<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/emails/recruitment/open_ranking.blade.php ENDPATH**/ ?>