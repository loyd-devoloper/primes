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
        <p> Dear Mr./Ms. {{ $data->lname }},</p>
        <p>Congratulations!</p>

        <p style=" max-width: 70rem">
            We are pleased to inform you that based on the initial evaluation, we have found your qualifications to be
            substantial vis-à-vis the Civil Service Commission (CSC) approved Qualification Standards (QS) of
            <span style="font-weight: bold">{{ $job_title }}</span> position under <span
                style="font-weight: bold">{{ $place_of_assignment }}</span>. Below are the results of the initial
            evaluation conducted by the undersigned dated {{ $date }} {{ $time }}:
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
                    <td style="font-weight: bold">{{ $data->jobInfo?->job_title }}</td>
                    <td><span style="font-weight: bold">Education:
                        </span><br>{{ $data->jobInfo?->education }}</td>
                    <td>
                        <span style="font-weight: bold">Education:
                        </span><br>

                        @if ($data->eligibilityInfo?->education)
                            @foreach (json_decode($data->eligibilityInfo->education) as $education)
                                <span> {{ $education }}</span>
                                <br>
                            @endforeach
                        @endif
                    </td>
                    <td>



                        <p>


                            <span style="font-weight: bold">
                                @if ($data->eligibilityInfo?->education_status == 2)
                                    Qualified
                                @elseif ($data->eligibilityInfo?->education_status == 4)
                                    Disqualified
                                @else
                                @endif
                            </span>
                            @if ($data->eligibilityInfo?->education_status == 4)
                                {{ $data->eligibilityInfo?->education_remarks }}
                            @endif
                        </p>

                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">{{ $data->jobInfo?->plantilla_item }}</td>
                    <td><span style="font-weight: bold">Experience:
                        </span><br>{{ $data->jobInfo?->experience }}</td>
                    <td>
                        <span style="font-weight: bold">Experience:
                        </span><br>
                        @if ($data->eligibilityInfo?->experience)
                            @foreach (json_decode($data->eligibilityInfo->experience) as $experience)
                                <p> {{ $experience->details . ' - ' . $experience->years }}</p>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <p>

                            <span style="font-weight: bold">
                                @if ($data->eligibilityInfo?->experience_status == 2)
                                    Qualified
                                @elseif ($data->eligibilityInfo?->experience_status == 4)
                                Not Qualified
                                @else
                                @endif
                            </span>
                            @if ($data->eligibilityInfo?->experience_status == 4)
                                {{ $data->eligibilityInfo?->experience_remarks }}
                            @endif
                        </p>

                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold"></td>
                    <td><span style="font-weight: bold">Training:
                        </span><br>{{ $data->jobInfo?->training }}</td>
                    <td>
                        <span style="font-weight: bold">Training:
                        </span><br>
                        @if ($data->eligibilityInfo?->training)

                            @foreach (json_decode($data->eligibilityInfo->training) as $training)
                                <p> {{ $training->title . ' - ' . $training->hours }}</p>
                            @endforeach
                        @endif
                    </td>
                    <td>

                        <p>

                            <span style="font-weight: bold">
                                @if ($data->eligibilityInfo?->training_status == 2)
                                    Qualified
                                @elseif ($data->eligibilityInfo?->training_status == 4)
                                    Disqualified
                                @else
                                @endif
                            </span>
                            @if ($data->eligibilityInfo?->training_status == 4)
                                {{ $data->eligibilityInfo?->training_remarks }}
                            @endif
                        </p>

                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold"></td>
                    <td><span style="font-weight: bold">Eligibility:
                        </span><br>{{ $data->jobInfo?->eligibility }}</td>
                    <td>
                        <span style="font-weight: bold">Eligibility:
                        </span><br>
                        @if ($data->eligibilityInfo?->eligibility)

                            @foreach (json_decode($data->eligibilityInfo->eligibility) as $eligibility)
                                <p> {{ $eligibility }}</p>
                            @endforeach
                        @endif
                    </td>
                    <td>


                        <p>
                            <span style="font-weight: bold">
                                @if ($data->eligibilityInfo?->eligibility_status == 2)
                                    Qualified
                                @elseif ($data->eligibilityInfo?->eligibility_status == 4)
                                    Disqualified
                                @else
                                @endif
                            </span>
                            @if ($data->eligibilityInfo?->eligibility_status == 4)
                                {{ $data->eligibilityInfo?->eligibility_remarks }}
                            @endif
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <p style=" max-width: 70rem">
            Please be advised of your assigned application code <span
                style="font-weight: bold">{{ $data->application_code }}</span> which shall be used as you
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
