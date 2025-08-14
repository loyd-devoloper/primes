<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            color: black;
            font-weight: 400;
        }

        .table {

            border-collapse: collapse;
            max-width: 60rem;
        }

        .table>thead>tr>th {
            padding: .5rem .5rem;
            font-weight: bold;
            background-color: rgb(89, 89, 89);
            color: white;

        }

        .table>tbody>tr>td {
            padding-bottom: 1.5rem ;
            text-align: left;
            color: black;

        }
    </style>
</head>

<body>



    <div class="container">
        <p> Dear Mr./Ms. <?php echo e($data->lname); ?>,</p>
        <p>Congratulations!</p>

        <p style=" max-width: 70rem">
            We are pleased to inform you that based on the initial evaluation, we have found your qualifications to be
            substantial vis-à-vis the Civil Service Commission (CSC) approved Qualification Standards (QS) of
            <span style="font-weight: bold"><?php echo e($job_title); ?></span> position under <span
                style="font-weight: bold"><?php echo e($place_of_assignment); ?></span>. Below are the results of the initial
            evaluation conducted by the undersigned dated <?php echo e($date); ?> <?php echo e($time); ?>:
        </p>
        <table class="table" border="1">
            <thead>
                <tr>
                    <th>Position Applied for</th>
                    <th>CSC-approved QS of the Position</th>
                    <th>Your Qualifications</th>
                    <th>Remarks/Details</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td style="font-weight: bold"><?php echo e($data->jobInfo?->job_title); ?></td>
                    <td><span style="font-weight: bold">Education:
                        </span><br><?php echo e($data->jobInfo?->education); ?></td>
                    <td>
                        <span style="font-weight: bold">Education:
                        </span><br>

                        <?php if($data->eligibilityInfo?->education): ?>
                            <?php $__currentLoopData = json_decode($data->eligibilityInfo->education); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $education): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span> <?php echo e($education); ?></span>
                                <br>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </td>
                    <td>



                        <p>


                            <span style="font-weight: bold">
                                <?php if($data->eligibilityInfo?->education_status == 2): ?>
                                    Qualified
                                <?php elseif($data->eligibilityInfo?->education_status == 4): ?>
                                    Disqualified
                                <?php else: ?>
                                <?php endif; ?>
                            </span>
                            <?php if($data->eligibilityInfo?->education_status == 4): ?>
                                <?php echo e($data->eligibilityInfo?->education_remarks); ?>

                            <?php endif; ?>
                        </p>

                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold"><?php echo e($data->jobInfo?->plantilla_item); ?></td>
                    <td><span style="font-weight: bold">Experience:
                        </span><br><?php echo e($data->jobInfo?->experience); ?></td>
                    <td>
                        <span style="font-weight: bold">Experience:
                        </span><br>
                        <?php if($data->eligibilityInfo?->experience): ?>
                            <?php $__currentLoopData = json_decode($data->eligibilityInfo->experience); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $experience): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p> <?php echo e($experience->details . ' - ' . $experience->years); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <p>

                            <span style="font-weight: bold">
                                <?php if($data->eligibilityInfo?->experience_status == 2): ?>
                                    Qualified
                                <?php elseif($data->eligibilityInfo?->experience_status == 4): ?>
                                Not Qualified
                                <?php else: ?>
                                <?php endif; ?>
                            </span>
                            <?php if($data->eligibilityInfo?->experience_status == 4): ?>
                                <?php echo e($data->eligibilityInfo?->experience_remarks); ?>

                            <?php endif; ?>
                        </p>

                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold"></td>
                    <td><span style="font-weight: bold">Training:
                        </span><br><?php echo e($data->jobInfo?->training); ?></td>
                    <td>
                        <span style="font-weight: bold">Training:
                        </span><br>
                        <?php if($data->eligibilityInfo?->training): ?>

                            <?php $__currentLoopData = json_decode($data->eligibilityInfo->training); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p> <?php echo e($training->title . ' - ' . $training->hours); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </td>
                    <td>

                        <p>

                            <span style="font-weight: bold">
                                <?php if($data->eligibilityInfo?->training_status == 2): ?>
                                    Qualified
                                <?php elseif($data->eligibilityInfo?->training_status == 4): ?>
                                    Disqualified
                                <?php else: ?>
                                <?php endif; ?>
                            </span>
                            <?php if($data->eligibilityInfo?->training_status == 4): ?>
                                <?php echo e($data->eligibilityInfo?->training_remarks); ?>

                            <?php endif; ?>
                        </p>

                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold"></td>
                    <td><span style="font-weight: bold">Eligibility:
                        </span><br><?php echo e($data->jobInfo?->eligibility); ?></td>
                    <td>
                        <span style="font-weight: bold">Eligibility:
                        </span><br>
                        <?php if($data->eligibilityInfo?->eligibility): ?>

                            <?php $__currentLoopData = json_decode($data->eligibilityInfo->eligibility); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eligibility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p> <?php echo e($eligibility); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </td>
                    <td>


                        <p>
                            <span style="font-weight: bold">
                                <?php if($data->eligibilityInfo?->eligibility_status == 2): ?>
                                    Qualified
                                <?php elseif($data->eligibilityInfo?->eligibility_status == 4): ?>
                                    Disqualified
                                <?php else: ?>
                                <?php endif; ?>
                            </span>
                            <?php if($data->eligibilityInfo?->eligibility_status == 4): ?>
                                <?php echo e($data->eligibilityInfo?->eligibility_remarks); ?>

                            <?php endif; ?>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <p style=" max-width: 70rem">
            Please be advised of your assigned application code <span
                style="font-weight: bold"><?php echo e($data->application_code); ?></span> which shall be used as you
            proceed with the next stage of the selection process. You may refer to the official issuances of the
            Personnel Section for the additional announcements in this regard. For inquiries, you may communicate
            with <span style="font-weight: bold">8682-2114 Loc. 483/487 and</span> <span
                style="color:blue">hrmpsb.calabarzon@deped.gov.ph</span>.
        </p>
        <p>
            Thank you.
        </p>
        <p>
            Very truly yours,
        </p>
        <div>
            <p><span style="font-weight: bold">HRMPSB Secretariat</span> <br>Personnel Section <br>DepEd Region IV-A
                CALABARZON <br>Gate 2, Karangalan Village <br>Cainta, Rizal</p>

        </div>
    </div>
</body>

</html>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/emails/recruitment/qualified_applicant.blade.php ENDPATH**/ ?>