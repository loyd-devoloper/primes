<div  x-data="skillDisplays(@js($getRecord()), @js($this->applicationOfEducationWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category)), @js($this->outstandingAccomplishmentWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category)))" id="psbtablegrade" class="relative overflow-x-auto shadow-md sm:rounded-lg  " wire:ignore>

    <div id="mainContainer" >

        <x-dynamic-component
            :component="$getFieldWrapperView()"
            :field="$field"
        >

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 relative  ">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400 sticky w-full left-0 top-0 bg-gray-100 ">
                <tr>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 max-w-[20px]" >
                        Criteria
                    </th>
                    <th scope="col" class="px-2 py-3">
                        Weight <br> Allocation
                    </th>
                    <th scope="col" class="px-2 !max-w-[12rem] py-3 bg-gray-50 dark:bg-gray-800 ">
                        <p class="!max-w-[12rem] ">
                            Details of Applicant's Qualification
                            (Relevant documents submitted additional requirements, notes of HRMPSB Members)
                        </p>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Computation
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actual Score
                    </th>
                </tr>
            </thead>
            <tbody>
                {{-- education --}}
                <tr class="border-b border-gray-600 dark:border-gray-700">
                    <th
                        class="px-6 text-xs py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Education
                    </th>
                    <td class="px-6 py-4">
                        {{ $this->educationWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category) }}
                    </td>
                    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800">

                        <div class="grid">
                            <label for="education">Increment Level</label>
                            <input type="number" x-ref="education" id="education" min="0" x-model="education"
                                class="!w-52" oninput="this.value = this.value.slice(0, 6)" required />
                        </div>
                        <div class="grid">
                            <label for="education_remarks">Remarks</label>
                            <textarea x-model="education_remarks" id="education_remarks" class="!w-52"></textarea>
                        </div>


                    </td>
                    <td class="px-6 py-4">

                        <div x-show="!!education && education != 0">
                            <span x-text='education'></span> - <span x-text='min_education'></span> = <span
                                class="font-bold" x-text='education_total'></span>
                            {{-- <br>
                            <x-filament::button tooltip="Formula:  (x - min requirement) "
                                class="!bg-transparent !border-none !p-0 !m-0">

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5 text-blue-500" tooltip="Register a user">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </x-filament::button> --}}

                        </div>
                    </td>
                    <td class="px-6 py-4">

                        <input type="text" x-model='education_final'  max="10" disabled="true"
                            oninput="this.value = this.value.slice(0, 2)" class="!w-[5rem]  cursor-not-allowed" />

                    </td>
                </tr>
                {{-- training --}}
                <tr class="border-b border-gray-600 dark:border-gray-700">
                    <th
                        class="px-6 text-xs py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Training
                    </th>
                    <td class="px-6 py-4">
                        {{ $this->trainingWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category) }}
                    </td>
                    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800">

                        <div class="grid">
                            <label for="training">Points</label>
                            <input type="number" x-ref="training" min="0" id="training" x-model="training"
                                class="!w-52" oninput="this.value = this.value.slice(0, 6)" required />
                        </div>
                        <div class="grid">
                            <label for="training_remarks">Remarks</label>
                            <textarea x-model="training_remarks" id="training_remarks" class="!w-52"></textarea>
                        </div>

                    </td>
                    <td class="px-6 py-4">

                        <div x-show="!!training && training != 0">
                            <span x-text='training'></span> - <span x-text='min_training'></span> = <span
                                class="font-bold" x-text='training_total'></span>
                        </div>
                    </td>
                    <td class="px-6 py-4">

                        <input type="text" x-model='training_final' max="10" disabled="true"
                            oninput="this.value = this.value.slice(0, 2)" class="!w-[5rem]  cursor-not-allowed" />


                    </td>
                </tr>

                {{-- experience --}}
                <tr class="border-b border-gray-600 dark:border-gray-700">
                    <th
                        class="px-6 text-xs py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Experience
                    </th>
                    <td class="px-6 py-4">
                        {{ $this->experienceWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category) }}
                    </td>
                    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800">

                        <div class="grid">
                            <label for="experience">Increment Level</label>
                            <input type="number" x-ref="experience" min="0" id="experience" x-model="experience"
                                class="!w-52" oninput="this.value = this.value.slice(0, 6)" required />
                        </div>
                        <div class="grid">
                            <label for="experience_remarks">Remarks</label>
                            <textarea x-model="experience_remarks" id="experience_remarks" class="!w-52"></textarea>
                        </div>

                    </td>
                    <td class="px-6 py-4">

                        <div x-show="!!experience && experience != 0">
                            <span x-text='experience'></span> - <span x-text='min_experience'></span> = <span
                                class="font-bold" x-text='experience_total'></span>
                        </div>
                    </td>
                    <td class="px-6 py-4">

                        <input type="text" x-model='experience_final' max="10" disabled="true"
                            oninput="this.value = this.value.slice(0, 2)" class="!w-[5rem]  cursor-not-allowed" />


                    </td>
                </tr>

                {{-- performance --}}
                <tr class="border-b border-gray-600 dark:border-gray-700">
                    <th
                        class="px-6 text-xs py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Performance
                    </th>
                    <td class="px-6 py-4">
                        {{ $this->performanceWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category) }}
                    </td>
                    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800">

                        <div class="grid">
                            <label for="performance_type">Type</label>
                            <select x-model="performance_type" id="performance_type" required class="!w-52">
                                <option value="" selected>Choose...</option>
                                <option value="Position with experience requirement">Position with experience
                                    requirement
                                </option>

                                <option value="Position with no experience requirement">Position with no experience
                                    requirement</option>

                                <optgroup label="Honor Earn">
                                    <option value="Summa Cum Laude">Summa Cum Laude</option>
                                    <option value="Magna Cum Laude">Magna Cum Laude</option>
                                    <option value="Cum Laude">Cum Laude</option>
                                </optgroup>
                            </select>
                        </div>
                        <div x-show="!!performance_type" class="grid">
                            <label for="performance">Points</label>
                            <input type="number" min="0" id="performance"
                                :max="performance_type == 'Position with experience requirement' ? 5 : 100"
                                x-model="performance" x-ref="performance" x-on:keyup="validateInput()"
                                step="any" :required="!!performance_type ? true : false" class="!w-52" />
                            <span x-show="performance_warning" class="text-red-500"
                                x-text="performance_warning"></span>

                        </div>
                        <div x-show="!!performance_type" class="grid">
                            <label for="performance_remarks">Remarks</label>
                            <textarea x-model="performance_remarks" id="performance_remarks" class="!w-52"></textarea>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div x-show="!!performance && performance != 0 && (performance_type != 'Summa Cum Laude' && performance_type != 'Magna Cum Laude' && performance_type != 'Cum Laude')">
                            <span x-text='performance'></span>/<span
                                x-text='performance_type == "Position with experience requirement" ? 5 : 100'></span>
                            *
                            {{ $this->performanceWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category) }}
                            = <span class="font-bold" x-text='performance_total'></span>
                        </div>
                    </td>
                    <td class="px-6 py-4">

                        <input type="text" readonly max="10" x-model="performance_total"
                            class="!w-[5rem]" />

                    </td>
                </tr>


                @include(
                    'livewire.recruitment.assets.' .
                        $getRecord()->jobOtherInformation?->type .
                        '_' .
                        $getRecord()->jobOtherInformation?->category)
                {{-- Potential (Written,Test, BEI,Work Sample Test	  --}}
                <tr class="border-b border-gray-600 dark:border-gray-700">
                    <th
                        class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Potential <br>(Written, <br> Test, BEI, <br> Work Sample Test
                    </th>
                    <td class="px-6 py-4">
                        {{ $this->potentialWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category) }}
                    </td>
                    <td class="px-2 py-4 bg-gray-50 dark:bg-gray-800">

                        <div class="grid">
                            <label for=""> WE =
                                {{ $this->partialPotentialWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category, 'we') }}
                                pts.</label>
                            <input type="number"
                                max="{{ $this->partialPotentialWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category, 'we') }}"
                                class="w-full  !max-w-[12rem]" x-model="we" step="any" />
                        </div>
                        <div class="grid">
                            <label for="">S/WST =
                                {{ $this->partialPotentialWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category, 'wst') }}
                                pts.</label>
                            <input type="number"
                                max="{{ $this->partialPotentialWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category, 'wst') }}"
                                class="  !max-w-[12rem]" x-model="wst" step="any" />
                        </div>

                        <div class="grid">
                            <label for="">BEI -
                                {{ $this->partialPotentialWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category, 'bei') }}
                                pts.</label>
                            <input type="number"
                                max="{{ $this->partialPotentialWeightAllocation($getRecord()->jobOtherInformation?->type, $getRecord()->jobOtherInformation?->category, 'bei') }}"
                                class="  !max-w-[12rem]" x-model="bei" step="any" />
                        </div>

                    </td>
                    <td class="px-6 py-4">

                    </td>
                    <td class="px-6 py-4">
                        <input type="number" pattern="[0-9]" max="10" x-model="total_wbw" disabled="true"
                            oninput="this.value = this.value.slice(0, 2)" class="!w-[5rem] cursor-not-allowed" />

                    </td>
                </tr>


                <tr class="border-b border-gray-600 dark:border-gray-700">
                    <th class="px-6 py-4 font-medium  whitespace-nowrap  bg-gray-500 text-white">
                        TOTAL
                    </th>
                    <td class="px-6 py-4  bg-gray-500 text-white">
                        100
                    </td>
                    <td class=" py-4  bg-gray-500 text-white max-w-[15rem]">

                    </td>
                    <td class="px-6 py-4  bg-gray-500 text-white">

                    </td>
                    <td class="px-6 py-4  bg-gray-500 text-white">
                        Sub Total = <span x-text="subTotal"></span>
                    </td>
                </tr>
            </tbody>

        </table>
        <div class="py-5 px-3">
            <button type="button" x-on:click="checkValidation"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Save</button>
            @if(Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::PSB_GRADE_BULK->value))
                <button type="button" x-on:click="checkValidationbulk"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-blue-800">Save Grade Bulk</button>
            @endif
        </div>
        </x-dynamic-component>


    </div>
</div>
@script
    <script>
        Alpine.data('skillDisplays', (data, applicationOfEducaton, outstandingMin) => ({
            data: data,

            applicationOfEducatonMin: applicationOfEducaton,
            outstandingMin: outstandingMin,
            education: '',
            education_remarks: '',
            min_education: 0,
            education_total: 0,
            education_final: 0,
            // experience data
            experience: '',
            experience_remarks: '',
            min_experience: 0,
            experience_total: 0,
            experience_final: 0,
            // training data
            training: '',
            training_remarks: '',
            min_training: 0,
            training_total: 0,
            training_final: 0,
            type: '',
            category: '',
            we: '',
            wst: '',
            bei: '',
            total_wbw: 0,
            // performance
            performance_type: '',
            performance: '',
            performance_remarks: '',
            performance_warning: '',
            performance_remarks: '',
            performance_total: '',
            outstanding: 0,
            outstanding_attr: {
                outstanding_a: 0,
                outstanding2_a: 0,
                outstanding3_a: 0,
                outstanding_b: 0,
                outstanding_c: 0,
                outstanding_d: 0,
                outstanding_e: 0,
            },
            outstanding_remarks: {
                outstanding_a_remarks: '',
                outstanding2_a_remarks: '',
                outstanding3_a_remarks: '',
                outstanding_b_remarks: '',
                outstanding_c_remarks: '',
                outstanding_d_remarks: '',
                outstanding_e_remarks: '',
            },
            application_of_education: 0,
            application_of_education_attr: {
                application_of_education_a: 0,
            },
            application_of_education_remarks: {
                application_of_education_a_remarks: "",

            },

            l_and_d: 0,
            l_and_d_remarks: '',
            application_code: '',
            batch_id: '',
            job_id: '',

            subTotal() {

                return (parseFloat(this.education_final) +
                    parseFloat(this.experience_final) +
                    parseFloat(this.training_final) +
                    parseFloat(this.performance_total) +
                    parseFloat(this.application_of_education) +
                    parseFloat(this.l_and_d) +
                    parseFloat(this.outstanding) +
                    parseFloat(this.total_wbw)).toFixed(3);
            },
            saveGrades() {
                const data = {
                    education: this.education,
                    education_remarks: this.education_remarks,
                    education_total: this.education_final,
                    experience: this.experience,
                    experience_remarks: this.experience_remarks,
                    experience_total: this.experience_final,
                    training: this.training,
                    training_remarks: this.training_remarks,
                    training_total: this.training_final,
                    performance: this.performance,
                    performance_type: this.performance_type,
                    performance_remarks: this.performance_remarks,
                    performance_total: this.performance_total,
                    outstanding: this.outstanding,
                    outstanding_a: this.outstanding_attr.outstanding_a,
                    outstanding_a_remarks: this.outstanding_remarks.outstanding_a_remarks,
                    outstanding2_a: this.outstanding_attr.outstanding2_a,
                    outstanding2_a_remarks: this.outstanding_remarks.outstanding2_a_remarks,
                    outstanding3_a: this.outstanding_attr.outstanding3_a,
                    outstanding3_a_remarks: this.outstanding_remarks.outstanding3_a_remarks,
                    outstanding_b: this.outstanding_attr.outstanding_b,
                    outstanding_b_remarks: this.outstanding_remarks.outstanding_b_remarks,
                    outstanding_c: this.outstanding_attr.outstanding_c,
                    outstanding_c_remarks: this.outstanding_remarks.outstanding_c_remarks,
                    outstanding_d: this.outstanding_attr.outstanding_d,
                    outstanding_d_remarks: this.outstanding_remarks.outstanding_d_remarks,
                    outstanding_e: this.outstanding_attr.outstanding_e,
                    outstanding_e_remarks: this.outstanding_remarks.outstanding_e_remarks,
                    application_of_education: this.application_of_education,
                    application_of_education_a: this.application_of_education_attr
                        .application_of_education_a,
                    application_of_education_a_remarks: this.application_of_education_remarks
                        .application_of_education_a_remarks,

                    l_and_d: this.l_and_d,
                    l_and_d_remarks: this.l_and_d_remarks,
                    we: this.we,
                    wst: this.wst,
                    bei: this.bei,
                    potential_total: this.total_wbw,
                    applicant_id: this.application_code,
                    batch_id: this.batch_id,
                    job_id: this.job_id,
                }
                $wire.saveGrade(data);
            },
            saveGradeBulk() {
                const data = {
                    education: this.education,
                    education_remarks: this.education_remarks,
                    education_total: this.education_final,
                    experience: this.experience,
                    experience_remarks: this.experience_remarks,
                    experience_total: this.experience_final,
                    training: this.training,
                    training_remarks: this.training_remarks,
                    training_total: this.training_final,
                    performance: this.performance,
                    performance_type: this.performance_type,
                    performance_remarks: this.performance_remarks,
                    performance_total: this.performance_total,
                    outstanding: this.outstanding,
                    outstanding_a: this.outstanding_attr.outstanding_a,
                    outstanding_a_remarks: this.outstanding_remarks.outstanding_a_remarks,
                    outstanding2_a: this.outstanding_attr.outstanding2_a,
                    outstanding2_a_remarks: this.outstanding_remarks.outstanding2_a_remarks,
                    outstanding3_a: this.outstanding_attr.outstanding3_a,
                    outstanding3_a_remarks: this.outstanding_remarks.outstanding3_a_remarks,
                    outstanding_b: this.outstanding_attr.outstanding_b,
                    outstanding_b_remarks: this.outstanding_remarks.outstanding_b_remarks,
                    outstanding_c: this.outstanding_attr.outstanding_c,
                    outstanding_c_remarks: this.outstanding_remarks.outstanding_c_remarks,
                    outstanding_d: this.outstanding_attr.outstanding_d,
                    outstanding_d_remarks: this.outstanding_remarks.outstanding_d_remarks,
                    outstanding_e: this.outstanding_attr.outstanding_e,
                    outstanding_e_remarks: this.outstanding_remarks.outstanding_e_remarks,
                    application_of_education: this.application_of_education,
                    application_of_education_a: this.application_of_education_attr
                        .application_of_education_a,
                    application_of_education_a_remarks: this.application_of_education_remarks
                        .application_of_education_a_remarks,

                    l_and_d: this.l_and_d,
                    l_and_d_remarks: this.l_and_d_remarks,
                    we: this.we,
                    wst: this.wst,
                    bei: this.bei,
                    potential_total: this.total_wbw,
                    applicant_id: this.application_code,
                    batch_id: this.batch_id,
                    job_id: this.job_id,
                }
                $wire.saveGradeBulk(data);
            },
            validateInput() {
                if (this.performance_type == 'Position with experience requirement') {
                    if (this.performance < 0 || this.performance > 5) {
                        this.performance_warning = 'Value must be between 0 and 5';

                    } else {
                        this.performance_warning = '';
                    }
                }else if(this.performance_type == "Position with no experience requirement")
                {
                    if (this.performance < 0 || this.performance > 100) {
                        this.performance_warning = 'Value must be between 0 and 100';
                    } else {
                        this.performance_warning = '';
                    }
                }
            },
            checkValidation(e) {
                if (this.$refs.education.reportValidity() && this.$refs.training.reportValidity() && this.$refs
                    .experience.reportValidity() && this.$refs.performance.reportValidity()) {
                    this.saveGrades()
                }


            },
            checkValidationbulk(e) {
                if (this.$refs.education.reportValidity() && this.$refs.training.reportValidity() && this.$refs
                    .experience.reportValidity() && this.$refs.performance.reportValidity()) {
                    this.saveGradeBulk()
                }


            },
            resizableAttachmentContainer()
            {
                const v = interact('#attachmentContainer');

                v.resizable({
                    edges: {
                        top: false,
                        left: false,
                        bottom: false,
                        right: true
                    },
                    listeners: {
                        start(event) {
                            event.target.classList.remove('border-black');
                            event.target.classList.add('border-yellow-500');
                        },
                        move(event) {

                            let { x, y } = event.target.dataset

                            x = (parseFloat(x) || 0) + event.deltaRect.left
                            y = (parseFloat(y) || 0) + event.deltaRect.top

                            Object.assign(event.target.style, {
                                width: `${event.rect.width}px`,
                                height: `${event.rect.height}px`,
                                transform: `translate(${x}px, ${y}px)`
                            })

                            Object.assign(event.target.dataset, { x, y })

                        },
                        end(event) {
                            event.target.classList.add('border-black');
                            event.target.classList.remove('border-yellow-500');
                        },
                    },
                })
            },
            arrDataFunc()
            {
              return  {
                  education: this.education,
                  education_remarks: this.education_remarks,
                  education_total: this.education_final,
                  experience: this.experience,
                  experience_remarks: this.experience_remarks,
                  experience_total: this.experience_final,
                  training: this.training,
                  training_remarks: this.training_remarks,
                  training_total: this.training_final,
                  performance: this.performance,
                  performance_type: this.performance_type,
                  performance_remarks: this.performance_remarks,
                  performance_total: this.performance_total,
                  outstanding: this.outstanding,
                  outstanding_a: this.outstanding_attr.outstanding_a,
                  outstanding_a_remarks: this.outstanding_remarks.outstanding_a_remarks,
                  outstanding2_a: this.outstanding_attr.outstanding2_a,
                  outstanding2_a_remarks: this.outstanding_remarks.outstanding2_a_remarks,
                  outstanding3_a: this.outstanding_attr.outstanding3_a,
                  outstanding3_a_remarks: this.outstanding_remarks.outstanding3_a_remarks,
                  outstanding_b: this.outstanding_attr.outstanding_b,
                  outstanding_b_remarks: this.outstanding_remarks.outstanding_b_remarks,
                  outstanding_c: this.outstanding_attr.outstanding_c,
                  outstanding_c_remarks: this.outstanding_remarks.outstanding_c_remarks,
                  outstanding_d: this.outstanding_attr.outstanding_d,
                  outstanding_d_remarks: this.outstanding_remarks.outstanding_d_remarks,
                  outstanding_e: this.outstanding_attr.outstanding_e,
                  outstanding_e_remarks: this.outstanding_remarks.outstanding_e_remarks,
                  application_of_education: this.application_of_education,
                  application_of_education_a: this.application_of_education_attr
                      .application_of_education_a,
                  application_of_education_a_remarks: this.application_of_education_remarks
                      .application_of_education_a_remarks,

                  l_and_d: this.l_and_d,
                  l_and_d_remarks: this.l_and_d_remarks,
                  we: this.we,
                  wst: this.wst,
                  bei: this.bei,
                  potential_total: this.total_wbw,
                  applicant_id: this.application_code,
                  batch_id: this.batch_id,
                  job_id: this.job_id,
              };
            },
            async init() {



                this.resizableAttachmentContainer()

                this.application_code = this.data.application_code;
                this.batch_id = this.data.batch_id;
                this.job_id = this.data.job_id;
                this.min_education = this.data.job_other_information?.min_requirements_education;
                this.min_experience = this.data.job_other_information?.min_requirements_experience;
                this.min_training = this.data.job_other_information?.min_requirements_training;
                this.category = this.data.job_other_information?.category;
                this.type = this.data.job_other_information?.type;
                if (!!this.data.my_grade) {
                    this.performance_type = await this.data.my_grade?.performance_type;

                }
                this.$watch('education', (val) => {
                    this.education_total = parseInt(val) - parseInt(this.min_education);

                    $wire.set('arrData',this.arrDataFunc());
                })
                this.$watch('education_total', async (val, oldVal) => {
                    !!val ? this.education_final = await $wire.computationEducation(this.type,
                        parseInt(val), this.category) : this.education_final = 0;
                    $wire.set('arrData',this.arrDataFunc());
                })
                // training
                this.$watch('training', (val) => {
                    this.training_total = parseInt(val) - parseInt(this.min_training);
                    $wire.set('arrData',this.arrDataFunc());
                })
                this.$watch('training_total', async (val, oldVal) => {

                    !!val ? this.training_final = await $wire.computationTraining(this.type,
                        parseInt(val), this.category) : this.training_final = 0;
                     $wire.set('arrData',this.arrDataFunc());
                })

                // experience
                this.$watch('experience', (val) => {
                    this.experience_total = parseInt(val) - parseInt(this.min_experience);
                     $wire.set('arrData',this.arrDataFunc());
                })
                this.$watch('experience_total', async (val, oldVal) => {

                    !!val ? this.experience_final = await $wire.computationExperience(this.type,
                        parseInt(val), this.category) : this.experience_final = 0;
                     $wire.set('arrData',this.arrDataFunc());


                })

                // WBW
                this.$watch('we', async (val, oldVal) => {

                    this.total_wbw = 0;
                    this.total_wbw += !!val ? parseFloat(val) : 0;
                    this.total_wbw += !!this.wst ? parseFloat(this.wst) : 0;
                    this.total_wbw += !!this.bei ? parseFloat(this.bei) : 0;
                     $wire.set('arrData',this.arrDataFunc());

                })
                this.$watch('bei', async (val, oldVal) => {
                    this.total_wbw = 0;
                    this.total_wbw += !!val ? parseFloat(val) : 0;
                    this.total_wbw += !!this.we ? parseFloat(this.we) : 0;
                    this.total_wbw += !!this.wst ? parseFloat(this.wst) : 0;
                     $wire.set('arrData',this.arrDataFunc());



                })
                this.$watch('wst', async (val, oldVal) => {

                    this.total_wbw = 0;
                    this.total_wbw += !!val ? parseFloat(val) : 0;
                    this.total_wbw += !!this.we ? parseFloat(this.we) : 0;
                    this.total_wbw += !!this.bei ? parseFloat(this.bei) : 0;
                     $wire.set('arrData',this.arrDataFunc());
                })

                // performance
                this.$watch('performance_type', async (val, oldVal) => {
                    this.performance_total = '';

                    if (!!val) {
                        if(this.performance_type == 'Summa Cum Laude')
                        {
                            // this.performance_total = 20;
                            this.performance = 20;
                        }
                        else if(this.performance_type == 'Magna Cum Laude')
                        {
                            // this.performance_total = 19;
                            this.performance = 19;
                        }
                        else if(this.performance_type == 'Cum Laude')
                        {
                            // this.performance_total = 18;
                            this.performance = 18;
                        }else{
                            this.performance = '';
                        }

                    }
                    $wire.set('arrData',this.arrDataFunc());
                })
                this.$watch('performance', async (val, oldVal) => {
                    if (!!val) {

                        if (this.performance_type == 'Position with experience requirement') {
                            var total = (parseFloat(val) / 5) * 20;
                            this.performance_total = total.toFixed(3).replace(/\.0+$/, '');
                        } else if (this.performance_type == 'Position with no experience requirement') {


                            var total = (parseFloat(val) / 100) * 20;
                            this.performance_total = total.toFixed(3).replace(/\.0+$/, '');
                        }else{
                            // console.log(this.performance_type)
                            const total = parseFloat(val);
                            this.performance_total = total.toFixed(3).replace(/\.0+$/, '');
                        }
                    } else {
                        this.performance_total = 0;
                    }
                    $wire.set('arrData',this.arrDataFunc());
                })

                // outstanding
                this.$watch('outstanding_attr', async (val, oldVal) => {
                    const total = parseFloat(val.outstanding_a) + parseFloat(val
                        .outstanding2_a) + parseFloat(val.outstanding3_a) + parseFloat(val
                        .outstanding_b) + parseFloat(val.outstanding_c) + parseFloat(val
                        .outstanding_d) + parseFloat(val.outstanding_e);

                    this.outstanding = total > this.outstandingMin ? this.outstandingMin :
                        total;
                    $wire.set('arrData',this.arrDataFunc());
                })
                if (!!this.data.my_grade) {
                    this.outstanding_attr.outstanding_a = this.data.my_grade?.outstanding_a;
                    this.outstanding_attr.outstanding2_a = this.data.my_grade?.outstanding2_a;
                    this.outstanding_attr.outstanding3_a = this.data.my_grade?.outstanding3_a;
                    this.outstanding_attr.outstanding_b = this.data.my_grade?.outstanding_b;
                    this.outstanding_attr.outstanding_c = this.data.my_grade?.outstanding_c;
                    this.outstanding_attr.outstanding_d = this.data.my_grade?.outstanding_d;
                    this.outstanding_attr.outstanding_e = this.data.my_grade?.outstanding_e;
                }
                this.outstanding_remarks.outstanding_a_remarks = this.data.my_grade?.outstanding_a_remarks;
                this.outstanding_remarks.outstanding2_a_remarks = this.data.my_grade
                    ?.outstanding2_a_remarks;
                this.outstanding_remarks.outstanding3_a_remarks = this.data.my_grade
                    ?.outstanding3_a_remarks;
                this.outstanding_remarks.outstanding_b_remarks = this.data.my_grade?.outstanding_b_remarks;
                this.outstanding_remarks.outstanding_c_remarks = this.data.my_grade?.outstanding_c_remarks;
                this.outstanding_remarks.outstanding_d_remarks = this.data.my_grade?.outstanding_d_remarks;
                this.outstanding_remarks.outstanding_e_remarks = this.data.my_grade?.outstanding_e_remarks;
                // application_of_education
                this.$watch('application_of_education_attr', async (val, oldVal) => {
                    const total = parseFloat(val.application_of_education_a);

                    this.application_of_education = total > this.applicationOfEducatonMin ? this
                        .applicationOfEducatonMin : total;


                    $wire.set('arrData',this.arrDataFunc());
                })

                if (!!this.data.my_grade) {
                    this.application_of_education_attr.application_of_education_a = this.data.my_grade
                        ?.application_of_education_a;

                }
                this.application_of_education_remarks.application_of_education_a_remarks = this.data
                    .my_grade?.application_of_education_a_remarks;

                // L and D
                this.l_and_d_remarks = this.data.my_grade?.l_and_d_remarks;

                // fetch
                this.education = this.data.my_grade?.education;
                this.education_remarks = this.data.my_grade?.education_remarks;

                this.training = this.data.my_grade?.training;
                this.training_remarks = this.data.my_grade?.training_remarks;

                this.experience = this.data.my_grade?.experience;
                this.experience_remarks = this.data.my_grade?.experience_remarks;

                this.performance = this.data.my_grade?.performance;
                this.performance_remarks = this.data.my_grade?.performance_remarks;


                if (!!this.data.my_grade) {
                    this.outstanding = this.data.my_grade?.outstanding;
                    this.application_of_education = this.data.my_grade?.application_of_education;
                    this.l_and_d = this.data.my_grade?.l_and_d;
                    this.we = this.data.my_grade?.we;
                    this.wst = this.data.my_grade?.wst;
                    this.bei = this.data.my_grade?.bei;
                }

            },

        }));
    </script>
@endscript
