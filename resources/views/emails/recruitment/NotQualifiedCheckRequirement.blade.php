<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <main style="padding: 2rem">



        <h5>Dear Mr. Flores :</h5>
        <h5>Please be informed that after the initial evaluation of your qualifications vis-a-vis the qualification
            standards of the position you applied for, the following is the result:
        </h5>

        {{-- table --}}
        <table border="1" style="border-collapse: collapse;max-width: 60%;border:1px solid black">
            <thead>
                <tr>
                    <th style="padding:10px;color:black">Position Applied for</th>
                    <th style="padding:10px;color:black">Attachment</th>
                    <th style="padding:10px;color:black">Remarks</th>
                </tr>
            </thead>
            <tbody>
                {{-- letter of intent --}}
                <tr>
                    <td style="padding:10px">{{ $info['position'] }}</td>
                    <td style="padding:10px">Letter of intent addressed to the Regional Director. Please include the
                        position
                        and its item number with corresponding Functional Division/Section/Unit
                    </td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->letter_of_intent_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap" >Not Qualified</strong>
                            @if (array_key_exists(
                                    'Letter of intent addressed to the Regional Director. Please include the position and its item number with corresponding Functional Division/Section/Unit',
                                    $data->comments->groupBy('filename')->toArray()))
                                <ul style="padding-left: 0px;">
                                    @foreach ($data->comments->groupBy('filename')->toArray()['Letter of intent addressed to the Regional Director. Please include the position and its item number with corresponding Functional Division/Section/Unit'] as $value)
                                        <li>{{ $value['comment'] }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </td>

                </tr>
                {{-- PDS --}}
                <tr>
                    <td style="padding:10px"></td>
                    <td style="padding:10px">Duly accomplished Personal Data Sheet(PDS) and Work Experience Sheet with
                        recent
                        passport-sized picture (CS Form No. 212, Revised 2017) which can be downloaded at
                        www.csc.gov.ph.
                    </td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->pds_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap">Not Qualified</strong>
                            @if (array_key_exists(
                                    'Duly accomplished Personal Data Sheet(PDS) and Work Experience Sheet with recent passport-sized picture (CS Form No. 212, Revised 2017) which can be downloaded at www.csc.gov.ph.',
                                    $data->comments->groupBy('filename')->toArray()))
                                <ul style="padding-left: 0px;">
                                    @foreach ($data->comments->groupBy('filename')->toArray()['Duly accomplished Personal Data Sheet(PDS) and Work Experience Sheet with recent passport-sized picture (CS Form No. 212, Revised 2017) which can be downloaded at www.csc.gov.ph.'] as $value)
                                        <li>{{ $value['comment'] }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </td>

                </tr>
                {{-- PRC --}}
                <tr>
                    <td style="padding:10px"></td>
                    <td style="padding:10px">Photocopy of valid and updated PRC License/ID (if applicable)</td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->prc_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap">Not Qualified</strong>
                            @if (array_key_exists(
                                    'Photocopy of valid and updated PRC License/ID (if applicable)',
                                    $data->comments->groupBy('filename')->toArray()))
                                       <ul style="padding-left: 0px;">
                                @foreach ($data->comments->groupBy('filename')->toArray()['Photocopy of valid and updated PRC License/ID (if applicable)'] as $value)
                                    <li>{{ $value['comment'] }}</li>
                                @endforeach
                                       </ul>
                            @endif
                        @endif
                    </td>

                </tr>
                {{-- eligibility --}}
                <tr>
                    <td style="padding:10px"></td>
                    <td style="padding:10px">Photocopy of Certificate of Eligibility/Rating (if applicable)</td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->eligibility_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap">Not Qualified</strong>
                            @if (array_key_exists(
                                    'Photocopy of Certificate of Eligibility/Rating (if applicable)',
                                    $data->comments->groupBy('filename')->toArray()))
                                  <ul style="padding-left: 0px;">
                                    @foreach ($data->comments->groupBy('filename')->toArray()['Photocopy of Certificate of Eligibility/Rating (if applicable)'] as $value)
                                        <li>{{ $value['comment'] }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </td>

                </tr>
                {{-- TOR --}}
                <tr>
                    <td style="padding:10px"></td>
                    <td style="padding:10px">Photocopy of scholastic/academic recored such as but not limited to
                        Transcript
                        of Records (TOR) and Diploma, including completion of graduate and post-graduate units/degrees
                        (if
                        applicable)</td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->tor_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap">Not Qualified</strong>
                            @if (array_key_exists(
                                    'Photocopy of scholastic/academic recored such as but not limited to Transcript of Records (TOR) and Diploma, including completion of graduate and post-graduate units/degrees (if applicable)',
                                    $data->comments->groupBy('filename')->toArray()))
                                  <ul style="padding-left: 0px;">
                                    @foreach ($data->comments->groupBy('filename')->toArray()['Photocopy of scholastic/academic recored such as but not limited to Transcript of Records (TOR) and Diploma, including completion of graduate and post-graduate units/degrees (if applicable)'] as $value)
                                        <li>{{ $value['comment'] }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </td>

                </tr>
                {{-- Training attended --}}
                <tr>
                    <td style="padding:10px"></td>
                    <td style="padding:10px">Photocopy of Certificate/s of Training attended</td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->training_attended_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap">Not Qualified</strong>
                            @if (array_key_exists(
                                    'Photocopy of Certificate/s of Training attended',
                                    $data->comments->groupBy('filename')->toArray()))
                                  <ul style="padding-left: 0px;">
                                    @foreach ($data->comments->groupBy('filename')->toArray()['Photocopy of Certificate/s of Training attended'] as $value)
                                        <li>{{ $value['comment'] }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </td>
                </tr>
                {{--  Certificate of Employment --}}
                <tr>
                    <td style="padding:10px"></td>
                    <td style="padding:10px">Photocopy of Certificate of Employment, Contract of Service, or duly signed
                        Service Record, whichever is/are applicable</td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->certificate_of_employment_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap">Not Qualified</strong>
                            @if (array_key_exists(
                                    'Photocopy of Certificate of Employment, Contract of Service, or duly signed Service Record, whichever is/are applicable',
                                    $data->comments->groupBy('filename')->toArray()))
                                  <ul style="padding-left: 0px;">
                                    @foreach ($data->comments->groupBy('filename')->toArray()['Photocopy of Certificate of Employment, Contract of Service, or duly signed Service Record, whichever is/are applicable'] as $value)
                                        <li>{{ $value['comment'] }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </td>
                </tr>
                {{--  latest appointment  --}}
                <tr>
                    <td style="padding:10px"></td>
                    <td style="padding:10px">Photocopy of latest appointment (if applicable)</td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->latest_appointment_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap">Not Qualified</strong>
                            @if (array_key_exists(
                                    'Photocopy of latest appointment (if applicable)',
                                    $data->comments->groupBy('filename')->toArray()))
                                       <ul style="padding-left: 0px;">
                                @foreach ($data->comments->groupBy('filename')->toArray()['Photocopy of latest appointment (if applicable)'] as $value)
                                    <li>{{ $value['comment'] }}</li>
                                @endforeach
                                       </ul>
                            @endif
                        @endif
                    </td>
                </tr>
                {{--  Performance Rating  --}}
                <tr>
                    <td style="padding:10px"></td>
                    <td style="padding:10px">Photocopy of the Performance Rating in the last rating period(s) covering
                        one
                        (1) year performance in the current/latest position prior to the deadline of submission(if
                        applicable)</td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->performance_rating_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap">Not Qualified</strong>
                            @if (array_key_exists(
                                    'Photocopy of the Performance Rating in the last rating period(s) covering one (1) year performance in the current/latest position prior to the deadline of submission(if applicable)',
                                    $data->comments->groupBy('filename')->toArray()))
                                       <ul style="padding-left: 0px;">
                                @foreach ($data->comments->groupBy('filename')->toArray()['Photocopy of the Performance Rating in the last rating period(s) covering one (1) year performance in the current/latest position prior to the deadline of submission(if applicable)'] as $value)
                                    <li>{{ $value['comment'] }}</li>
                                @endforeach
                                       </ul>
                            @endif
                        @endif
                    </td>
                </tr>
                {{--  cav  --}}
                <tr>
                    <td style="padding:10px"></td>
                    <td style="padding:10px">Checklist of Requirements and Omnibus Sworn Statement on the Certification
                        on
                        the Authenticity and Veracity (CAV) of the documents submitted and Data Privacy Consent Form
                        pursuant to RA No. 10173 (Data Privacy Act of 2012), using the form (Annex C) of DepEd Order No.
                        007, s. 2023, notorized by authorized official</td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->cav_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap">Not Qualified</strong>
                            @if (array_key_exists(
                                    'Checklist of Requirements and Omnibus Sworn Statement on the Certification on the Authenticity and Veracity (CAV) of the documents submitted and Data Privacy Consent Form pursuant to RA No. 10173 (Data Privacy Act of 2012), using the form (Annex C) of DepEd Order No. 007, s. 2023, notorized by authorized official',
                                    $data->comments->groupBy('filename')->toArray()))
                                       <ul style="padding-left: 0px;">
                                @foreach ($data->comments->groupBy('filename')->toArray()['Checklist of Requirements and Omnibus Sworn Statement on the Certification on the Authenticity and Veracity (CAV) of the documents submitted and Data Privacy Consent Form pursuant to RA No. 10173 (Data Privacy Act of 2012), using the form (Annex C) of DepEd Order No. 007, s. 2023, notorized by authorized official'] as $value)
                                    <li>{{ $value['comment'] }}</li>
                                @endforeach
                                       </ul>
                            @endif
                        @endif
                    </td>
                </tr>
                {{--  MOVS  --}}
                <tr>
                    <td style="padding:10px"></td>
                    <td style="padding:10px">Means of Verification (MOVS) showing Outstanding Accomplishment,
                        Application of
                        Education, and Application of Learning and Development reckoned from the date of last issurance
                        of
                        appointment.</td>

                    <td style="padding:10px; text-align: left">
                        @if ($attachment?->movs_status == 1)
                            <strong style="color:black; text-align: center">Qualified</strong>
                        @else
                            <strong style="color:black;text-align: center;white-space:nowrap">Not Qualified</strong>
                            @if (array_key_exists(
                                    'Means of Verification (MOVS) showing Outstanding Accomplishment, Application of Education, and Application of Learning and Development reckoned from the date of last issurance of appointment.',
                                    $data->comments->groupBy('filename')->toArray()))
                                       <ul style="padding-left: 0px;">
                                @foreach ($data->comments->groupBy('filename')->toArray()['Means of Verification (MOVS) showing Outstanding Accomplishment, Application of Education, and Application of Learning and Development reckoned from the date of last issurance of appointment.'] as $value)
                                    <li>{{ $value['comment'] }}</li>
                                @endforeach
                                       </ul>
                            @endif
                        @endif
                    </td>
                </tr>
            </tbody>

        </table>

        <h5> We regret to inform you that you cannot proceed to the next stage of the selection process.</h5>

        <h5>May we take this opportunity to thank you for the interest you have shown and wish you every success in your
            profession.</h5>

        <h5> Kindly acknowledge receipt of this e-mail</h5>

        <h5> Thank you and God bless.</h5>

        <h5>
            Personnel Section<br>
            DepEd Region IV-A CALABARZON<br>
            Gate 2 Karangalan Village,<br>
            Cainta, Rizal 1900 <br>
        </h5>

    </main>

</body>

</html>
