@assets
    <style>
        /* body {
                padding: 2rem 6em;
            } */

        .removeDefault {

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
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .tableTh {
            background: #d9d9d9;
            padding: .3rem;
            font-size: 10px;
            border: 1px solid black;
        }

        .tableTd {
            text-align: center;
            padding: .3rem;
            font-size: 10px;
            border: 1px solid black;
        }

        .tableTdBold {
            text-align: center;
            font-weight: bold;
            padding: .3rem;
            font-size: 10px;
            border: 1px solid black;
        }

        .tableTdLimit {
            text-align: left;
            padding: .1rem;
            font-size: 10px;
            border: 1px solid black;
        }

        .page-break-inside {
            /* page-break-after: always; */
            /* page-break-inside: avoid; */
        }

        .page-break {
            page-break-after: always;

        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        @page {
            size: a4 portrait;
        }

    </style>
@endassets
<div x-data="skillDisplay" >
    <button x-on:click="generateMe">click me</button>
    <button x-on:click="printDiv">printDiv</button>

    <section id="my-node">
        <main  style="border: 2px solid black; padding: 1rem" class="appearance-none">
            <p class="defaultBold">INDIVIDUAL EVALUATION SHEET (IES) - GENERAL SERVICES</p>

            <p class="removeDefault">Name of Applicant: ________________________</p>
            <p class="removeDefault">Position Applied For : __________________</p>
            <p class="removeDefault">Office : __________________________________</p>
            <p class="removeDefault">Contact Number : ________________________</p>
            <p class="removeDefault">Job Group/SG-Level : __________________________</p>

            <table class="tables ">



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

                    <tr>
                        <td style="padding: .3rem; font-size:10px;border: 1px solid black">Education</td>
                        <td class="tableTdBold">5</td>
                        <td class="tableTd"></td>
                        <td class="tableTd"></td>
                        <td class="tableTd"></td>
                    </tr>
                    <tr>
                        <td style="padding: .3rem; font-size:10px;border: 1px solid black">Training</td>
                        <td class="tableTdBold">5</td>
                        <td class="tableTd"></td>
                        <td class="tableTd"></td>
                        <td class="tableTd"></td>
                    </tr>
                    <tr>
                        <td style="padding: .3rem; font-size:10px;border: 1px solid black">Experience</td>
                        <td class="tableTdBold">20</td>
                        <td class="tableTd"></td>
                        <td class="tableTd"></td>
                        <td class="tableTd"></td>
                    </tr>
                    <tr>
                        <td style="padding: .3rem; font-size:10px;border: 1px solid black">Performance</td>
                        <td class="tableTdBold">10</td>
                        <td class="tableTd"></td>
                        <td class="tableTd"></td>
                        <td class="tableTd"></td>
                    </tr>
                    <tr>
                        <td style="padding: .3rem; font-size:10px;border: 1px solid black">Outstanding
                            accomplishments</td>
                        <td class="tableTdBold" rowspan="8">5</td>
                        <td class="tableTdLimit">
                            <strong>a.1 Citation or Commendation. This apply only to applicants for Gen. Services Positions.
                            </strong>
                            <br>
                            <strong>Rubrics:</strong>
                            <br>
                            <strong>Number of Citations:</strong>
                            <br>

                            Three (3) or more citations - 4 points
                            <br>
                            Two (2) letters of citation - 3 points
                            <br>
                            One (1) letter of citation - 2 points

                        </td>
                        <td class="tableTd"></td>
                        <td class="tableTd" rowspan="8"></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="padding: .3rem; font-size:10px;border: 1px solid black">a. Awards and
                            Recognition</td>
                        <td class="tableTdLimit">
                            <strong>a.2. Academic or Inter-school Awards.</strong>
                            <br>

                            This shall apply only to applicants with no or less than one (1) year work experience (e.g.
                            fresh graduates).
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
                            At least three (3) academic or inter-school awards or TOSP Award or Top 10 in Board/CS
                            Eligbility
                            Examination - 4 points
                            <br>
                            At least two (2) academic or inter-school awards - 3 points
                            <br>
                            At least one (1) academic or inter-school award - 2 points
                        </td>
                        <td class="tableTd"></td>

                    </tr>
                    {{-- a --}}
                    <tr>

                        <td class="tableTdLimit">
                            <strong>a.3. Outstanding Employee Award.</strong>
                            <br>

                            This shall apply to applicants with previous work experience, or those applying to positions
                            with experience requirement.
                            <br>
                            <strong>Means of Verification: </strong>
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
                        <td class="tableTd"></td>

                    </tr>
                    <tr>

                        <td class="tableTdLimit">
                            For multiple awards received from the same award giving body and/or award category that are
                            conducted in series or progressive manner, only the highest-level award shall be considered.
                            Similarly, only the highest award shall be given points in cases where applicants submit
                            multiple awards from different award giving bodies.
                            <br>
                            <br>
                            An applicant to a General Services position who has presented Letter/s of Citation/Commendation
                            and/or Outstanding Employee Award, shall be given points based on either Category a. 1 or
                            Category a.3., whichever is higher.
                        </td>


                        <td class="tableTd"></td>



                    </tr>
                    {{-- b --}}
                    <tr>
                        <td style="padding: .3rem; font-size:10px;border: 1px solid black">b. Research and
                            Innovation</td>

                        <td class="tableTdLimit">
                            <strong>Means of verification:</strong>
                            <br>
                            A. Proposal duly approved by the Head of Office or the designated Research Committee per DO No.
                            16, s. 2017
                            <br>
                            B. Accomplishment Report verified by the Head of Office
                            <br>
                            C. Certification of utilization of the innovation or research, within the school/office duly
                            signed by the
                            Head of Office
                            <br>
                            D. Certification of adoption of the innovation or research by another school/office duly signed
                            by the Head
                            of Office
                            <br>
                            E. Proof of citation by other researchers (whose study/ research is likewise approved by
                            authorized body) of
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
                            For collaborative research studies/innovation, the total points shall be divided by the number
                            of
                            authors/researchers indicated in the copyright page.
                        </td>

                        <td class="tableTd"></td>

                    </tr>
                    {{-- c --}}
                    <tr>
                        <td style="padding: .3rem; font-size:10px;border: 1px solid black">c. Subject Matter
                            Expert/Membership in
                            National TWGs or
                            Committees
                            (3 pts.)</td>

                        <td class="tableTdLimit">
                            This shall apply to applicants who have been chosen and requested to use their technical
                            knowledge, skills,
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
                        <td class="tableTd"></td>

                    </tr>
                    {{-- d --}}
                    <tr>
                        <td style="padding: .3rem; font-size:10px;border: 1px solid black">d. Resource
                            Speakership/
                            Learning facilitation
                            (2 pts.)</td>

                        <td class="tableTdLimit">
                            This shall apply to applicants who have been requested and invited to share their knowledge and
                            expertise on
                            specific subject matter/s. This may include applicants who served as a Resource Speaker,
                            Resource Person,
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
                        <td class="tableTd"></td>

                    </tr>
                    {{-- e --}}
                    <tr>
                        <td style="padding: .3rem; font-size:10px;border: 1px solid black"> e. NEAP <br> Accredited
                            Learning<br> Facilitator (2 pts.)</td>

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
                        <td class="tableTd"></td>

                    </tr>



            </table>

        </main>
    </section>

</div>
@script
    <script>
        Alpine.data('skillDisplay', (datas) => ({
            generateMe() {
                // window.jsPDF = window.jspdf.jsPDF;

                // var node = document.getElementById('my-node');
                // var printContents = node.innerHTML;
                // var originalContents = document.body.innerHTML;

                // document.body.innerHTML = printContents;

                // window.print();

                // document.body.innerHTML = originalContents;
                // var img = document.getElementById('imageFront');
                html2pdf(document.getElementById('my-node'), {
                    margin: 20,
                    filename: `dsasdsad.pdf`,
                    // image: {
                    //     type: 'png',
                    //     quality: 1
                    // },
                    html2canvas: {
                        scale: 5
                    },
                    // jsPDF:        { unit: 'px', format: [639,1015], orientation: 'portrait' }
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait',
                        // Add a larger margin to prevent text from being cut off

                    },


                });


            },
             printDiv() {
            let divContents = document.getElementById("my-node").innerHTML;
            let printWindow = window.open('', '');
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                <head>
                    <title>Print Div Content</title>
                    <style>
        /* body {
                padding: 2rem 6em;
            } */

        .removeDefault {

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
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .tableTh {
            background: #d9d9d9;
            padding: .3rem;
            font-size: 10px;
            border: 1px solid black;
        }

        .tableTd {
            text-align: center;
            padding: .3rem;
            font-size: 10px;
            border: 1px solid black;
        }

        .tableTdBold {
            text-align: center;
            font-weight: bold;
            padding: .3rem;
            font-size: 10px;
            border: 1px solid black;
        }

        .tableTdLimit {
            text-align: left;
            padding: .1rem;
            font-size: 10px;
            border: 1px solid black;
        }

        .page-break-inside {
            /* page-break-after: always; */
            /* page-break-inside: avoid; */
        }

        .page-break {
            page-break-after: always;

        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        @page {
            size: a4 portrait;
        }

    </style>
                </head>
                <body>

                    ${divContents}
                </body>
                </html>
            `);

            printWindow.print();
            printWindow.document.close();
        },
            init() {
                // this.generateMe()
            }
        }))
    </script>
@endscript
