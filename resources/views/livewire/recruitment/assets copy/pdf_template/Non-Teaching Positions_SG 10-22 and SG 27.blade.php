<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
        /* body {
            padding: 1rem 4rem;
        } */
        html {
            margin: 4rem 6rem
        }

        .removeDefault {
            line-height: .2rem;
            font-family: "Bookman Old Style", serif;
            font-size: 10px;
        }

        .defaultBold {

            font-family: "Bookman Old Style", serif;
            font-size: 10px;
            font-weight: bold;
            padding-bottom: 1rem;
        }

        .tables {
            border-collapse: collapse;
            min-width: 100%;
            border: 1px solid black;
        }

        .tableTh {
            background: #d9d9d9;
            padding: .3rem;
            font-size: 10px;
        }

        .tableTd {
            text-align: center;
            padding: .3rem;
            font-size: 10px;
        }

        .tableTdBold {
            text-align: center;
            font-weight: bold;
            padding: .3rem;
            font-size: 10px;
        }

        .tableTdLimit {
            text-align: left;
            padding: .1rem;
            font-size: 10px;
        }

        .page-break-inside {
            /* page-break-after: always; */
            /* page-break-inside: avoid; */
        }

        .page-break {
            page-break-after: always;

        }

        @page {
            size: a4 portrait;
        }
    </style>
</head>

<body>
    <main style="border: 2px solid black; padding: 1rem" class="appearance-none">
        <p class="removeDefault" style="text-align: right;padding-right: 1rem">Annex G</p>
        <p class="defaultBold">INDIVIDUAL EVALUATION SHEET (IES) - SG 10-22 AND SG 27 - NON-TEACHING POSITIONS</p>

        <p class="removeDefault">Name of Applicant: <span
                style="text-decoration: underline;font-weight: bold">{{ $name }}</span></p>
        <p class="removeDefault">Position Applied For : <span
                style="text-decoration: underline;font-weight: bold">{{ $position }}</span></p>
        <p class="removeDefault">Office : <span
                style="text-decoration: underline;font-weight: bold">{{ $place_of_assignment }}</span></p>
        <p class="removeDefault">Contact Number : <span
                style="text-decoration: underline;font-weight: bold">{{ $contact_number }}</span></p>
        <p class="removeDefault">Job Group/SG-Level : <span
                style="text-decoration: underline;font-weight: bold">{{ $sg_level }}</span></p>

        <table border="1" class="tables ">



            <tr>

                <th class="tableTh" rowspan="2" style="text-align: center">Criteria</th>
                <th class="tableTh" rowspan="2" style="text-align: center">Weight Allocation</th>
                <th class="tableTh" colspan="3" style="text-align: center">Applicant's Actual Qualification</th>
            </tr>
            <tr>
                <th class="tableTh">Details of Applicant's Qualification (Relevant documents submitted additional
                    requirements, notes of HRMPSB Members)</th>
                <th class="tableTh">Computation</th>
                <th class="tableTh" style="white-space: nowrap">Actual Score</th>
            </tr>

            {{-- education --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">Education</td>
                <td class="tableTdBold">5</td>
                <td class="tableTd">{{ $education['remarks'] }}</td>
                <td class="tableTd">{{ $education['computation'] }}</td>
                <td class="tableTd">{{ $education['total'] }}</td>
            </tr>
            {{-- training --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">Training</td>
                <td class="tableTdBold">10</td>
                <td class="tableTd">{{ $training['remarks'] }}</td>
                <td class="tableTd">{{ $training['computation'] }}</td>
                <td class="tableTd">{{ $training['total'] }}</td>
            </tr>
            {{-- experience --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">Experience</td>
                <td class="tableTdBold">15</td>
                <td class="tableTd">{{ $experience['remarks'] }}</td>
                <td class="tableTd">{{ $experience['computation'] }}</td>
                <td class="tableTd">{{ $experience['total'] }}</td>
            </tr>

            {{-- performance --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">Performance</td>
                <td class="tableTdBold">20</td>
                <td class="tableTd">{{ $performance['remarks'] }}</td>
                <td class="tableTd">{{ $performance['computation'] }}</td>
                <td class="tableTd">{{ $performance['total'] }}</td>
            </tr>
            {{-- a 1 --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">Outstanding
                    accomplishments</td>
                <td class="tableTdBold" style="border: none">10</td>
                <td class="tableTdLimit">

                    <strong>a.2. Academic or Inter-school Awards.</strong>
                    <br>

                    This shall apply only to applicants with no or less than one (1) year work experience (e.g. fresh
                    graduates).
                    <br>
                    <strong>Means of Verification: </strong>
                    <br>

                    A. Academic or inter-school award; or
                    <br>
                    B. Ten Outstanding Students of the Philippines (TOSP) Award; or
                    <br>
                    C. Certification or any document that the applicant belongs to the Top 10 in the Board or Civil
                    Service
                    Eligbility Examination.
                    <br>


                    <strong>Rubrics:</strong>
                    <br>
                    <strong>Number of Awards:</strong>
                    <br>
                    At least three (3) academic or inter-school awards or TOSP Award or Top 10 in Board/CS Eligbility
                    Examination - 4 points
                    <br>
                    At least two (2) academic or inter-school awards - 3 points
                    <br>
                    At least one (1) academic or inter-school award - 2 points


                </td>
                <td class="tableTd">{!! $outstanding['remarks_a'] !!}</td>
                <td class="tableTd" style="border: none">{{ $outstanding['total'] }}</td>
            </tr>
            {{-- a 2 --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black;border-bottom:none">a. Awards and
                    Recognition</td>
                <td class="tableTd" style="border: none"></td>
                <td class="tableTdLimit">


                    <strong>a.3. Outstanding Employee Award. </strong>
                    <br>

                    This shall apply to applicants with previous work experience, or those applying to positions with
                    experience
                    requirement.
                    <br>
                    <strong>Means of verification:</strong>
                    <br>

                    A. Any issuance, memorandum or document showing the Criteria for the Search; and
                    <br>
                    B. Certificate of Recognition/ Merit.
                    <br>


                    <strong>Rubrics:</strong>
                    <br>
                    <strong>Applicants from external institution</strong>
                    <br>
                    Organizational Level Search or Higher - 4 points
                    <br>
                    Local Office Search - 2 points
                    <br>
                    <strong>Applicants from central office</strong>
                    <br>
                    National Level Search or Higher - 4 points
                    <br>
                    Central Office Search - 2 points
                    <br>
                    <strong>Applicants from regional office</strong>
                    <br>
                    National Level Search or Higher - 4 points
                    <br>
                    Regional Office Search - 2 points
                    <br>
                    <strong>Applicants from schools division office</strong>
                    <br>
                    Regional Level Search or Higher - 4 points
                    <br>
                    Division/ Provincial/City Level Search - 2 points
                    <br>
                    <strong>Applicants from schools</strong>
                    <br>
                    Division Level Search or Higher - 4 points
                    <br>
                    School/Municipality/District Level Search - 2 points




                </td>
                <td class="tableTd">{!! $outstanding['remarks2_a'] !!}</td>
                <td class="tableTd" style="border: none"></td>
            </tr>
            {{-- a --}}
            <tr>
                <td class="tableTd" style="border: none"></td>
                <td class="tableTd" style="border-top: none;border-bottom: none"></td>
                <td class="tableTdLimit">
                    For multiple awards received from the same award giving body and/or award category that are
                    conducted in
                    series or progressive manner, only the highest-level award shall be considered. Similarly, only the
                    highest
                    award shall be given points in cases where applicants submit multiple awards from different award
                    giving
                    bodies.
                    <br>
                    <br>
                    An applicant to a General Services position who has presented Letter/s of Citation/Commendation
                    and/or
                    Outstanding Employee Award, shall be given points based on either Category a. 1 or Category a.3.,
                    whichever
                    is higher.
                </td>
                <td class="tableTd"></td>
                <td class="tableTd" style="border: none"></td>
            </tr>

            {{-- b --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">b. Research and
                    Innovation</td>
                <td class="tableTd" style="border: none"></td>
                <td class="tableTdLimit">
                    <strong>Means of verification:</strong>
                    <br>
                    A. Proposal duly approved by the Head of Office or the designated Research Committee per DO No. 16,
                    s. 2017
                    <br>
                    B. Accomplishment Report verified by the Head of Office
                    <br>
                    C. Certification of utilization of the innovation or research, within the school/office duly signed
                    by the
                    Head of Office
                    <br>
                    D. Certification of adoption of the innovation or research by another school/office duly signed by
                    the Head
                    of Office
                    <br>
                    E. Proof of citation by other researchers (whose study/ research is likewise approved by authorized
                    body) of
                    the concept/s developed in the research.
                    <br>
                    <strong>Rubrics:</strong>
                    <br>
                    <strong>MOVs submitted</strong>
                    <br>
                    A, B, C & D - 4 points
                    <br>
                    A, B, C & E - 4 points
                    <br>
                    Only A, B & C - 3 points
                    <br>
                    Only A & B - 2 points
                    <br>
                    Only A - 1 point
                    <br>
                    <br>
                    For collaborative research studies/innovation, the total points shall be divided by the number of
                    authors/researchers indicated in the copyright page.
                </td>
                <td class="tableTd">{!! $outstanding['remarks_b'] !!}</td>
                <td class="tableTd" style="border: none"></td>

            </tr>
            {{-- c --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">c. Subject Matter
                    Expert/Membership in
                    National TWGs or
                    Committees
                    (3 pts.)</td>
                <td class="tableTd" style="border: none"></td>
                <td class="tableTdLimit">
                    This shall apply to applicants who have been chosen and requested to use their technical knowledge,
                    skills,
                    and experience to develop an output, or work towards an outcome in the national level. This may
                    include but
                    not limited to the development and/or validation of framework, models, policies, and learning
                    materials.
                    Subject matter expertise or membership in NTWGs or Committees must, however, be relevant to the
                    position
                    being applied for in order to be given points.
                    <br>
                    <strong>Means of verification:</strong>
                    <br>
                    A. Issuance or Memorandum showing the membership in NTWG or Committee;
                    <br>
                    B. Certificate of Participation or Attendance; and
                    <br>
                    C. Output/Adoption by the organization/DepEd.
                    <br>
                    <strong>Rubrics:</strong>
                    <br>
                    MOVs Submitted
                    <br>
                    ALL MOVS - 3 points
                    <br>
                    Only A & B - 2 points
                </td>
                <td class="tableTd">{!! $outstanding['remarks_c'] !!}</td>
                <td class="tableTd" style="border: none"></td>
            </tr>
            {{-- d --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">d. Resource
                    Speakership/
                    Learning facilitation
                    (2 pts.)</td>
                <td class="tableTd" style="border: none"></td>
                <td class="tableTdLimit" style="border-top: none;border-bottom: none">
                    This shall apply to applicants who have been requested and invited to share their knowledge and
                    expertise on
                    specific subject matter/s. This may include applicants who served as a Resource Speaker, Resource
                    Person,
                    Trainer, and/or Learning Facilitator in seminars,
                    training programs, conferences,
                    convention, congress, forums, learning action cells (LAC) sessions, etc.
                    <br>
                    <strong>Means of verification (All listed MOVs shall be submitted):</strong>
                    <br>
                    A. Issuance/Memorandum/ Invitation/Training Matrix;
                    <br>
                    B. Certificate of Recognition/ Merit/Commendation/ Appreciation;
                    <br>
                    C. Slide deck/s used and/or Session guide/s.
                    <br>
                    <strong>Rubrics:</strong>
                    <strong>Applicants from external institution</strong>
                    <br>
                    Organizational Level Speakership or Higher - 2 points
                    <br>
                    Local Office Level Speakership - 1 point
                    <br>
                    <strong>Applicants from central office</strong>
                    <br>
                    National Level Speakership or Higher-2 points
                    <br>
                    Central Office Level Speakership- 1 point
                    <br>
                    <strong>Applicants from regional office</strong>
                    <br>
                    National Level Speakership or Higher - 2 points
                    <br>
                    Regional Office Speakership - 1 point
                    <br>
                    <strong>Applicants from schools division office</strong>
                    <br>
                    Regional Level Speakership or Higher - 2 points
                    <br>
                    Division/Provincial/City Level Speakership - 1 point
                    <br>
                    <strong>Applicants from schools</strong>
                    <br>
                    Division Level Speakership or Higher - 2 points
                    <br>
                    School/Municipality/District Speakership - 1 point
                </td>
                <td class="tableTd">{!! $outstanding['remarks_d'] !!}</td>
                <td class="tableTd" style="border: none"></td>
            </tr>
            {{-- e --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black"> e. NEAP <br> Accredited
                    Learning<br> Facilitator (2 pts.)</td>
                <td class="tableTd" style="border-top: none;border-bottom: none"></td>
                <td class="tableTdLimit">
                    This shall apply to applicants who have been given accreditation as Learning Facilitator by the
                    National
                    Educator Academy of the Philippines (NEAP).
                    <br>
                    <strong>Means of verification:</strong>
                    <br>
                    A. Certificate of Recognition as Learning Facilitator issued by NEAP Regional Office
                    <br>
                    B. Certificate of Recognition as Learning Facilitator issued by NEAP Central Office


                    <br>
                    <strong>Rubrics:</strong>
                    <br>
                    Accredited National Assessor - 2 points
                    <br>
                    Accredited National Trainer - 1.5 points
                    <br>
                    Accredited Regional Trainer - 1 point
                </td>
                <td class="tableTd">{!! $outstanding['remarks_e'] !!}</td>
                <td class="tableTd" style="border: none"></td>
            </tr>
            {{-- Application of Education  --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black"> Application of Education</td>
                <td class="tableTd" style="border-bottom: none">10</td>
                <td class="tableTdLimit">
                    <strong> Application of education</strong> is the contribution made by an applicant to their
                    workplace as a
                    result of their learnings from higher education units or degree/s earned, such as but not limited to
                    applied
                    concepts, processes, and skills that are relevant to the position to be filled. Points shall be
                    given to an
                    applicant who has successfully applied the learnings gained from said higher education units or
                    degree/s
                    earned. The application of education must have led to significant positive results in the
                    applicant's
                    current or previous work.
                </td>
                <td class="tableTd"></td>
                <td class="tableTd" style="border-bottom: none">{{ $application_of_education }}</td>
            </tr>
            {{--  a. Positions with experience requirement  --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">a. Positions with <br> experience
                    requirement</td>
                <td class="tableTd" style="border-top: none;border-bottom: none"></td>
                <td class="tableTdLimit">
                    <strong> a. Positions with experience requirement.</strong> <br>
                    Application of education is the contributions made by the applicant to their workplace as a result
                    of their
                    learnings from their education degrees or units earned, such as but not limited to applied concepts,
                    processes, and skills that are relevant to the position to be filled.
                    <br>
                    <br>
                    Higher premium shall be given to an application of education or intervention made by the applicant
                    that is
                    relevant and applicable to the position to be filled.
                    <br>
                    <br>
                    <strong>Relevant intervention</strong> is described as the intervention that is directly applicable
                    to the
                    functional unit where the position applied for is lodged.
                    An intervention is described to be applicable if it can be used in the operations of the functional
                    unit
                    based on its office mandates in the official DepEd Office Functions or Office Orders for the
                    creation of the
                    functional unit based on the creation of the functional unit.
                    <br>
                    <br>
                    <strong>Means of verification:</strong>
                    <br>
                    A. Action Plan approved by the Head of Office
                    <br>
                    C. Certification of the utilization/ adoption signed by the Head of Office
                    <br>
                    <strong>Rubrics:</strong>
                    <br>
                    <strong>MOVs submitted:</strong>
                    <br>
                    All MOVs - Relevant (10pts); Not Relevant (5pts)
                    Only A & B - Relevant (7pts) ; Not Relevant (3pts)
                    Only A - Relevant (5pts); Not Relevant (1pt)
                </td>
                <td class="tableTd">{!! $application_of_education_remarks !!}</td>
                <td class="tableTd" style="border: none"></td>
            </tr>
            {{--  b. Positions with <br> no experience requirement  --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">b. Positions with <br> no experience
                    requirement</td>
                <td class="tableTd" style="border-top: none;border-bottom: none"></td>
                <td class="tableTdLimit">
                    <strong>b. Positions with no experience requirement. </strong> <br>
                    Applicants to positions that do not require previous work experience must submit the GWA in the
                    highest
                    academic/grade level earned as evidenced by Transcript of Records/ Certificate of
                    GWA/Diploma/Special Order
                    from the Commission on Higher Education (CHED) or other certifications. The HRMPSB must develop a
                    system
                    that transmutes the GWA to a percentage scale. Computation of points for Application of Education
                    shall be
                    as follows:
                    x = GWA transmuted to percentage scale
                    WA = Weight Allocation for Application of Education
                    (10 points for other grouos of positions/salary grades
                    <br>
                    <br>
                    Higher premium shall be given to an application of education or intervention made by the applicant
                    that is
                    relevant and applicable to the position to be filled.
                    <br>
                    <br>
                    <strong>Relevant intervention</strong> is described as the intervention that is directly applicable
                    to the
                    functional unit where the position applied for is lodged.
                    An intervention is described to be applicable if it can be used in the operations of the functional
                    unit
                    based on its office mandates in the official DepEd Office Functions or Office Orders for the
                    creation of the
                    functional unit based on the creation of the functional unit.

                    <br>
                    <br>
                    <strong>Means of verification:</strong>
                    <br>
                    A. Action Plan approved by the Head of Office
                    <br>
                    C. Certification of the utilization/ adoption signed by the Head of Office
                    <br>
                    <strong>Rubrics:</strong>
                    <br>
                    <strong>MOVs submitted:</strong>
                    <br>
                    All MOVs - Relevant (10pts); Not Relevant (5pts)
                    Only A & B - Relevant (7pts) ; Not Relevant (3pts)
                    Only A - Relevant (5pts); Not Relevant (1pt)
                </td>
                <td class="tableTd"></td>
                <td class="tableTd" style="border: none"></td>
            </tr>
            {{--  Application of Learning and Development --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black">Application of <br> Learning <br>and
                    Development</td>
                <td class="tableTd" style="border-bottom: none">10</td>
                <td class="tableTdLimit">
                    A. Certificate of Training or Certification on any applicable L&D intervention acquired that is
                    aligned with
                    the IDP; for external, a certification from HR stating that the L&D intervention is aligned with the
                    core
                    tasks of the applicant in their current or previous position
                    <br>
                    <br>

                    B. Action Plan/Re-entry Action Plan (REAP)/Job Embedded learning(JEL)/impact project the
                    leranings
                    from the L&D intervention done/attended duly approved by the Head Office;
                    <br>
                    <br>
                    C. Accomplishment Report together with a Gen. Certification that the L&D intervention was
                    used/
                    adopted by the office at the local level;
                    <br>
                    <br>
                    D. Accomplishment Report together with Gen. Certification tha the L&D intervention was used/
                    adopted
                    by a different office at the local/ higher level.
                    <br>
                    <br>
                    <strong> Rubrics:</strong>
                    <br>
                    All MOVs - Relevant (10pts); Not Relevant (5pts)
                    <br>
                    Only A, B & C - Relevant (7 pts); No Relevant (3pts)
                    <br>
                    Only A & B - Relevant (5pts); Not Relevant (1pt)
                </td>
                <td class="tableTd">{{ $l_and_d_remarks }}</td>
                <td class="tableTd" style="border-bottom: none">{{ $l_and_d }}</td>
            </tr>
            {{-- Potential (Written,Test, BEI, Work Sample Test --}}
            <tr>
                <td style="padding: .3rem; font-size:10px;border: 1px solid black"> Potential (Written, <br> Test, BEI,
                    Work <br>Sample Test</td>
                <td class="tableTd">20</td>
                <td class="tableTdLimit">

                    WE = 5pts
                    <br>
                    S/WST = 10pts
                    <br>
                    BEI = 5pts
                </td>
                <td class="tableTd"></td>
                <td class="tableTd">{{ $outstanding['potential_total'] }}</td>
            </tr>
            <tr>
                <td class="tableTh" style="padding: .3rem; font-size:10px;border: 1px solid black;text-align:center">
                    <strong>Total</strong>
                </td>
                <td class="tableTh" style="text-align:center"><strong>100</strong></td>
                <td class="tableTh">

                </td>
                <td class="tableTh"></td>
                <td class="tableTh"></td>
            </tr>
        </table>
        <br>
        <br>
        <p class="removeDefault">I hereby attest to the conduct of the application and assessment process in accordance
            with the</p>
        <p class="removeDefault">applicable guidelines; and acknowledge, upon discussion with the Human Resource Merit
            Promotion</p>
        <p class="removeDefault">and Selection Board (HRMPSB), the results of the comparative assessment and the points
            given</p>
        <p class="removeDefault">to me based on my qualifications and submitted documentary requirements for the <span
                style="text-decoration: underline; font-weight: bold">{{ $position }}</span></p>
        <p class="removeDefault">under <span
                style="text-decoration: underline; font-weight: bold">{{ $place_of_assignment }}</span>.</p>
        <br>
        <br>
        <p class="removeDefault">Furthermore, I hereby affix my signature in the Form to attest to the objective and
            judicious conduct</p>
        <p class="removeDefault">of the HRMPSB evaluation through Open Ranking System.</p>
        <br>

        <div>
            <div style="width: fit-content;margin-left: auto ">
                <p class="removeDefault" style="text-align:right">_______<span
                        style="text-decoration: underline; font-weight: bold">{{ $name }}</span>_______</p>
                <p class="removeDefault" style="text-align:right">Name and Signature of Applicant
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <p class="removeDefault" style="text-align:right">
                    Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </p>
            </div>
        </div>
        <br>
        <p class="removeDefault">Attested:</p>
        <br>
        <div>
            <div style="width: fit-content;">
                <p class="removeDefault" style="text-align:left">____________________________________</p>
                <p class="removeDefault" style="text-align:left"><strong>LOIDA N. NIDEA</strong> </p>
                <p class="removeDefault" style="text-align:left">Assistant Regional Director</p>
                <p class="removeDefault" style="text-align:left">HRMPSB, Chairperson</p>
            </div>
        </div>


    </main>
</body>

</html>
