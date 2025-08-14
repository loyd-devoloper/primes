{{-- Outstanding accomplishments --}}
<tr class="border-b border-gray-600 dark:border-gray-700">
    <th
        class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
        Outstanding <br> accomplishments
    </th>
    <td class="px-6 py-4">
        {{ $this->outstandingAccomplishmentWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category) }}
    </td>
    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800 text-black ">



    </td>
    <td class="px-6 py-4">

    </td>
    <td class="px-6 py-4">

        <input type="number" disabled="true" oninput="this.value = this.value.slice(0, 2)" required
            class="!w-[5rem] cursor-not-allowed" x-model="outstanding" />

    </td>
</tr>
{{-- a. Awards and Recognition --}}
<tr class="border-b border-gray-600 dark:border-gray-700">
    <th
        class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
        a. Awards <br>and Recognition
    </th>
    <td class="px-6 py-4">

    </td>
    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800 text-black " x-data="{ open: false }">
         <strong>a.1 Citation or Commendation. This apply only to applicants for Gen. Services Positions. </strong>
        <br>
        <button class="text-blue-500 hover:underline" type="button" x-on:click="open = !open"
            x-text="open ? 'hide details' : 'show details'"></button>

        <p class="max-w-[12rem] " x-show="open" x-transition>
            {{-- <strong>a.1 Citation or Commendation. This apply only to applicants for Gen. Services Positions. </strong> --}}
            <br>
            <strong>Rubrics:</strong>
            <br>
            <strong>Number of Citations:</strong>
            <br>


        <table class="border-collapse border border-black text-[.7rem]" x-show="open" x-transition>
            <tr>
                <td class="border border-black  ">Three (3) or more citations</td>
                <td class="border border-black ">4 points</td>


            </tr>
            <tr>
                <td class="border border-black  ">Two (2) letters of citation</td>
                <td class="border border-black ">3 points</td>

            </tr>
            <tr>
                <td class="border border-black  ">One (1) letter of citation</td>
                <td class="border border-black ">2 points</td>
            </tr>

        </table>


        </p>
        <br>


        <div class="grid">
            <label>Remarks</label>
            <textarea x-model="outstanding_remarks.outstanding_a_remarks" class="!w-52 "></textarea>
        </div>



    </td>
    <td class="px-6 py-4 ">

        <input type="number" oninput="this.value = this.value.slice(0, 2)" required class="!w-[5rem]"
            x-model="outstanding_attr.outstanding_a" />


    </td>
    <td class="px-6 py-4">



    </td>
</tr>
{{-- a.2 Awards and Recognition --}}
<tr class="border-b border-gray-600 dark:border-gray-700">
    <th
        class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">

    </th>
    <td class="px-6 py-4">

    </td>
    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800 text-black " x-data="{ open: false }">
        <strong>a.2. Academic or Inter-school Awards</strong>
        <br>
        <button class="text-blue-500 hover:underline" type="button" x-on:click="open = !open"
            x-text="open ? 'hide details' : 'show details'"></button>

        <p class="max-w-[12rem] " x-show="open" x-transition>
            {{-- <strong>a.2. Academic or Inter-school Awards.</strong> --}}
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
            C. Certification or any document that the applicant belongs to the Top 10 in the Board or Civil Service
            Eligbility Examination.
            <br>


            <strong>Rubrics:</strong>
            <br>
            <strong>Number of Awards:</strong>


        <table class="border-collapse border border-black text-[.7rem]" x-show="open" x-transition>
            <tr>
                <td class="border border-black  ">At least three (3) academic or inter-school awards or TOSP Award or
                    Top 10 in Board/CS Eligbility
                    Examination</td>
                <td class="border border-black ">4 points</td>


            </tr>
            <tr>
                <td class="border border-black  ">At least two (2) academic or inter-school awards</td>
                <td class="border border-black ">3 points</td>

            </tr>
            <tr>
                <td class="border border-black  ">At least one (1) academic or inter-school award</td>
                <td class="border border-black ">2 points</td>
            </tr>

        </table>
        <br />
        </p>




        <div class="grid">
            <label>Remarks</label>
            <textarea x-model="outstanding_remarks.outstanding2_a_remarks" class="!w-52 "></textarea>
        </div>


    </td>
    <td class="px-6 py-4 ">

        <input type="number" oninput="this.value = this.value.slice(0, 2)" required class="!w-[5rem]"
            x-model="outstanding_attr.outstanding2_a" />


    </td>
    <td class="px-6 py-4">



    </td>
</tr>
{{-- a.3. Awards and Recognition --}}
<tr class="border-b border-gray-600 dark:border-gray-700">
    <th
        class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">

    </th>
    <td class="px-6 py-4">

    </td>
    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800 text-black " x-data="{ open: false }">


         <strong>a.3. Outstanding Employee Award.</strong>
        <br>
        <button class="text-blue-500 hover:underline" type="button" x-on:click="open = !open"
            x-text="open ? 'hide details' : 'show details'"></button>

        <p class="max-w-[12rem] " x-show="open" x-transition>
            {{-- <strong>a.3. Outstanding Employee Award.</strong> --}}
            <br>

            This shall apply to applicants with previous work experience, or those applying to positions with experience
            requirement.
            <br>
            <strong>Means of Verification: </strong>
            <br>

            A. Any issuance, memorandum or document showing the Criteria for the Search; and
            <br>
            B. Certificate of Recognition/ Merit.
            <br>



            <strong>Rubrics:</strong>
            <br>

        <table class="border-collapse border border-black text-[.7rem]" x-show="open" x-transition>
            <tr>
                <td class="border border-black font-bold ">Applicants from external institution</td>
                <td class="border border-black font-bold ">Applicants from central office</td>
                <td class="border border-black font-bold ">Applicants from regional office</td>
                <td class="border border-black font-bold ">Applicants from schools division office</td>
                <td class="border border-black font-bold ">Applicants from schools</td>
            </tr>
            <tr>
                <td class="border border-black ">Organizational Level Search or Higher - 4 points</td>
                <td class="border border-black ">National Level Search or Higher - 4 points</td>
                <td class="border border-black ">National Level Search or Higher - 4 points</td>
                <td class="border border-black ">Regional Level Search or Higher - 4 points</td>
                <td class="border border-black ">Division Level Search or Higher - 4 points</td>
            </tr>
            <tr>
                <td class="border border-black ">Local Office Search - 2 points</td>
                <td class="border border-black ">Central Office Search - 2 points</td>
                <td class="border border-black ">Regional Office Search - 2 points</td>
                <td class="border border-black ">Division/ Provincial/City Level Search - 2 points</td>
                <td class="border border-black ">School/Municipality/District Level Search - 2 points</td>
            </tr>

        </table>
        </p>


        <p class="max-w-[12rem]" x-show="open" x-transition>
            For multiple awards received from the same award giving body and/or award category that are conducted in
            series or progressive manner, only the highest-level award shall be considered. Similarly, only the highest
            award shall be given points in cases where applicants submit multiple awards from different award giving
            bodies.
            <br>
            <br>
            An applicant to a General Services position who has presented Letter/s of Citation/Commendation and/or
            Outstanding Employee Award, shall be given points based on either Category a. 1 or Category a.3., whichever
            is higher.
        </p>

        <div class="grid">
            <label>Remarks</label>
            <textarea x-model="outstanding_remarks.outstanding3_a_remarks" class="!w-52 "></textarea>
        </div>

    </td>
    <td class="px-6 py-4 ">

        <input type="number" oninput="this.value = this.value.slice(0, 2)" required class="!w-[5rem]"
            x-model="outstanding_attr.outstanding3_a" />


    </td>
    <td class="px-6 py-4">



    </td>
</tr>
{{-- b. Research and Innovation --}}
<tr class="border-b border-gray-600 dark:border-gray-700">
    <th
        class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
        b. Research <br> and Innovation
    </th>
    <td class="px-6 py-4">

    </td>
    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800" x-data="{ open: false }">
        <button class="text-blue-500 hover:underline" type="button" x-on:click="open = !open"
            x-text="open ? 'hide details' : 'show details'"></button>


        <p class="max-w-[12rem] text-black" x-show="open">
            <strong>Means of verification:</strong>
            <br>
            A. Proposal duly approved by the Head of Office or the designated Research Committee per DO No. 16, s. 2017
            <br>
            B. Accomplishment Report verified by the Head of Office
            <br>
            C. Certification of utilization of the innovation or research, within the school/office duly signed by the
            Head of Office
            <br>
            D. Certification of adoption of the innovation or research by another school/office duly signed by the Head
            of Office
            <br>
            E. Proof of citation by other researchers (whose study/ research is likewise approved by authorized body) of
            the concept/s developed in the research.
            <br>
            <strong>Rubrics:</strong>
            <br>
            <strong>MOVs submitted</strong>
            <br>
            - A, B, C & D - 4 points
            <br>
            - A, B, C & E - 4 points
            <br>
            - Only A, B & C - 3 points
            <br>
            - Only A & B - 2 points
            <br>
            - Only A - 1 point
            <br>
            <br>
            For collaborative research studies/innovation, the total points shall be divided by the number of
            authors/researchers indicated in the copyright page.
        </p>
        <div class="grid">
            <label>Remarks</label>
            <textarea x-model="outstanding_remarks.outstanding_b_remarks" class="!w-52"></textarea>
        </div>

    </td>
    <td class="px-6 py-4">
        <input type="number" pattern="[0-9]" max="10" oninput="this.value = this.value.slice(0, 2)" required
            class="!w-[5rem]" x-model="outstanding_attr.outstanding_b" />
    </td>
    <td class="px-2 py-4">



    </td>
</tr>
{{-- C.  Subject Matter Expert/Membership in National TWGs or Committees  --}}
<tr class="border-b border-gray-600 dark:border-gray-700">
    <th
        class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
        c. Subject Matter <br> Expert/Membership <br> in National TWGs <br>or Committees (3 pts.)
    </th>
    <td class="px-6 py-4">

    </td>
    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800" x-data="{ open: false }">
        <button class="text-blue-500 hover:underline" type="button" x-on:click="open = !open"
            x-text="open ? 'hide details' : 'show details'"></button>

        <p class="max-w-[12rem] text-black " x-show="open">
            This shall apply to applicants who have been chosen and requested to use their technical knowledge, skills,
            and experience to develop an output, or work towards an outcome in the national level. This may include but
            not limited to the development and/or validation of framework, models, policies, and learning materials.
            Subject matter expertise or membership in NTWGs or Committees must, however, be relevant to the position
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
            - ALL MOVS - 3 points
            <br>
            - Only A & B - 2 points
        </p>
        <div class="grid">
            <label>Remarks</label>
            <textarea x-model="outstanding_remarks.outstanding_c_remarks" class="!w-52"></textarea>
        </div>

    </td>
    <td class="px-6 py-4">
        <input type="number" pattern="[0-9]" max="10" oninput="this.value = this.value.slice(0, 2)" required
            class="!w-[5rem]" x-model="outstanding_attr.outstanding_c" />
    </td>
    <td class="px-2 py-4">



    </td>
</tr>
{{-- d. Resource Speakership/ Learning facilitation (2 pts.)  --}}
<tr class="border-b border-gray-600 dark:border-gray-700">
    <th
        class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
        d. Resource <br> Speakership/ Learning <br> facilitation (2 pts.)
    </th>
    <td class="px-6 py-4">

    </td>
    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800 " x-data="{ open: false }">
        <button class="text-blue-500 hover:underline" type="button" x-on:click="open = !open"
            x-text="open ? 'hide details' : 'show details'"></button>

        <p class="max-w-[12rem] text-black " x-show="open">
            This shall apply to applicants who have been requested and invited to share their knowledge and expertise on
            specific subject matter/s. This may include applicants who served as a Resource Speaker, Resource Person,
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
            <br />
        <table class="border-collapse border text-black border-black text-[.7rem]" x-show="open" x-transition>
            <tr>
                <td class="border border-black font-bold ">Applicants from external institution</td>
                <td class="border border-black font-bold ">Applicants from central office</td>
                <td class="border border-black font-bold ">Applicants from regional office</td>
                <td class="border border-black font-bold ">Applicants from schools division office</td>
                <td class="border border-black font-bold ">Applicants from schools</td>
            </tr>
            <tr>
                <td class="border border-black ">Organizational Level Search or Higher - 2 point</td>
                <td class="border border-black ">National Level Search or Higher - 2 points</td>
                <td class="border border-black ">National Level Search or Higher - 2 points</td>
                <td class="border border-black ">Regional Level Search or Higher - 2 points</td>
                <td class="border border-black ">Division Level Search or Higher - 2 points</td>
            </tr>
            <tr>
                <td class="border border-black ">Local Office Search - 1 point</td>
                <td class="border border-black ">Central Office Search - 1 point</td>
                <td class="border border-black ">Regional Office Search - 1 point</td>
                <td class="border border-black ">Division/ Provincial/City Level Search - 1 point</td>
                <td class="border border-black ">School/Municipality/District Level Search - 1 point</td>
            </tr>

        </table>
        </p>
        <div class="grid">
            <label>Remarks</label>
            <textarea x-model="outstanding_remarks.outstanding_d_remarks" class="!w-52"></textarea>
        </div>

    </td>
    <td class="px-6 py-4">
        <input type="number" pattern="[0-9]" max="10" oninput="this.value = this.value.slice(0, 2)" required
            class="!w-[5rem]" x-model="outstanding_attr.outstanding_d" />
    </td>
    <td class="px-2 py-4">



    </td>
</tr>
{{-- e. NEAP Accredited Learning Facilitator (2 pts.)  --}}
<tr class="border-b border-gray-600 dark:border-gray-700">
    <th
        class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
        e. NEAP <br> Accredited
        Learning<br> Facilitator (2 pts.)
    </th>
    <td class="px-6 py-4">

    </td>
    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800" x-data="{ open: false }">
        <button class="text-blue-500 hover:underline" type="button" x-on:click="open = !open"
            x-text="open ? 'hide details' : 'show details'"></button>

        <p class="max-w-[12rem] text-black " x-show="open">
            This shall apply to applicants who have been given accreditation as Learning Facilitator by the National
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

              <table class="border-collapse border text-black border-black text-[.7rem]" x-show="open" x-transition>
            <tr>
                <td class="border border-black  ">Accredited National Assessor</td>
                <td class="border border-black ">2 points</td>


            </tr>
            <tr>
                <td class="border border-black  ">Accredited National Trainer</td>
                <td class="border border-black ">1.5 points</td>

            </tr>
            <tr>
                <td class="border border-black  ">Accredited Regional Trainer</td>
                <td class="border border-black ">1 point</td>
            </tr>

        </table>
        </p>

        <div class="grid">
            <label>Remarks</label>
            <textarea x-model="outstanding_remarks.outstanding_e_remarks" class="!w-52"></textarea>
        </div>

    </td>
    <td class="px-6 py-4">
        <input type="number" pattern="[0-9]" max="10" oninput="this.value = this.value.slice(0, 2)" required
            class="!w-[5rem]" x-model="outstanding_attr.outstanding_e" />
    </td>
    <td class="px-2 py-4">



    </td>
</tr>
