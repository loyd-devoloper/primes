<div class="max-w-[1300px] overflow-x-auto">

    <div style="padding: 2rem" class="min-w-[1300px] max-w-[1300px]">
        <div style=" margin-left: auto;margin-right: auto; border-width: 1px;padding: 1rem;background: white">
            <div style="text-align: left;margin-bottom: 1rem;">
                <p style="font-size: 0.875rem;line-height: 1.25rem;font-weight: 700; font-style: italic;">Civil Service
                    Form No. 6</p>
                <p style="font-size: 0.875rem;line-height: 1.25rem;font-weight: 700; font-style: italic;">Revised 2020
                </p>
            </div>
            <div style="text-align: center;margin-bottom: 1rem;">
                <p style="font-weight: 700;">Republic of the Philippines</p>
                <p style="font-weight: 700;">Department of Education</p>
                <p style="font-weight: 800;">Region IV-A CALABARZON</p>
                <p style="font-weight: 700;">Gate 2 Karangalan Village, Cainta, Rizal</p>
            </div>
            <div style="text-align: center; margin-bottom: 1rem;">
                <p style="font-weight: 700;font-size: 1.875rem;line-height: 2.25rem;">APPLICATION FOR LEAVE</p>
            </div>
            <div style="border-width: 1px;border-style: solid;  border-color: black;">
                <div class="grid grid-cols-7 p-1" style="">
                    <div class="col-span-2 ">
                        <p style="font-weight: 700;padding-bottom: 1rem;">1. OFFICE/DEPARTMENT</p>
                        <p>DEPED REGION IV-A CALABARZON</p>
                    </div>
                    <div class="col-span-5 " style="">
                        <p class="font-bold pb-4">2. NAME:</p>
                        <div class="flex">
                            <div class="w-1/3">
                                <p>{{ $getRecord()->userInfo?->lname }}</p>
                            </div>
                            <div class="w-1/3">
                                <p>{{ $getRecord()->userInfo?->fname }}</p>
                            </div>
                            <div class="w-1/3">
                                <p>{{ $getRecord()->userInfo?->mname }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border border-solid border-black my-1.5">
                <div class="flex justify-between">
                    <div class="w-1/2 flex gap-2">
                        <p class="font-bold">3. DATE OF FILING</p>
                        <p>{{ \Carbon\Carbon::parse($getRecord()->created_at)->format('F d, Y') }}</p>
                    </div>
                    <div class="w-1/4 flex gap-2"">
                        <p class="font-bold">4. POSITION</p>
                        <p>{{ $getRecord()->workexperience?->position_title }}</p>
                    </div>
                    <div class="w-1/4 flex gap-2"">
                        <p class="font-bold">5. SALARY</p>
                        <p> {{ $getRecord()->workexperience ? 'SG ' . $getRecord()->workexperience?->salary_grade : '' }}
                        </p>
                    </div>
                </div>
            </div>
            <div>
                <p class="font-bold text-center border border-solid border-black my-1.5">6. DETAILS OF APPLICATION</p>
                <div class="flex border border-solid border-black">
                    <div class="w-1/2 border-r border-black pr-4">
                        <p class="font-bold">6.A TYPE OF LEAVE TO BE AVAILED OF</p>
                        <div class="pl-4 py-4">
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value ? 'checked' : '' }}>
                                Vacation Leave (Sec. 51, Rule XVI, Omnibus Rules
                                Implementing E.O.
                                No. 292)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value ? 'checked' : '' }}>
                                Mandatory/Forced Leave (Sec. 25, Rule XVI, Omnibus Rules
                                Implementing
                                E.O. No. 292)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value ? 'checked' : '' }}>
                                Sick Leave (Sec. 43, Rule XVI, Omnibus Rules Implementing E.O.
                                No.
                                292)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::MATERNITY_LEAVE->value ? 'checked' : '' }}>
                                Maternity Leave (R.A. No. 11210/ Implemented by CSC, DOLE and
                                SSS)
                            </p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::PATERNITY_LEAVE->value ? 'checked' : '' }}>
                                Paternity Leave (R.A. No. 8187/ CSC MC No. 71, s. 1998, as
                                amended)
                            </p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::SPECIAL_PRIVILEGE_LEAVE->value ? 'checked' : '' }}>
                                Special Privilege Leave (Sec. 21, Rule XVI, Omnibus Rules
                                Implementing E.O. No. 292)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::SOLO_PARENT_LEAVE->value ? 'checked' : '' }}>
                                Solo Parent Leave (RA No. 8972/ CSC MC No. 8, s. 2004)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::STUDY_LEAVE->value ? 'checked' : '' }}>
                                Study Leave (Sec. 68, Rule XVI, Omnibus Rules Implementing E.O.
                                No.
                                292)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::VAWC_LEAVE->value ? 'checked' : '' }}>
                                10-Day VAWC Leave (RA No. 9262/ CSC MC No. 15, s. 2005)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::REHABILITATION_PRIVILEGE->value ? 'checked' : '' }}>
                                Rehabilitation Privilege (Sec. 55, Rule XVI, Omnibus Rules
                                Implementing E.O. No. 292)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::SPECIAL_LEAVEL_BENIFITS_FOR_WOMEN->value ? 'checked' : '' }}>
                                Special Leave Benefits for Women (RA No. 9710/ CSC MC No. 25, s.
                                2010)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::SPECIAL_EMERGENCY_CALAMITY_LEAVE->value ? 'checked' : '' }}>
                                Special Emergency (Calamity) Leave (CSC MC No. 2, s. 2012, as amended)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::ADOPTION_LEAVE->value ? 'checked' : '' }}>
                                Adoption Leave (RA No. 8552)</p>
                            <p><input type="checkbox"
                                    {{ $getRecord()->type_of_leave == \App\Enums\TypeOfLeaveEnum::OTHERS->value ? 'checked' : '' }}>
                                Others:
                                {{-- other leave --}}
                                <span class="border-b border-black inline-block w-1/2 text-center"></span>
                            </p>
                        </div>
                    </div>
                    <div class="w-1/2 pl-4">
                        <p class="font-bold">6.B DETAILS OF LEAVE</p>
                        <div class="pl-4 pb-6">
                            <p class="italic">In case of Vacation/Special Privilege Leave:</p>
                            <p class="flex justify-between items-end"><span><input type="checkbox"> Within the
                                    Philippines</span> <span class="border-b border-black inline-block w-1/2"></p>
                            <p class="flex justify-between items-end"><span><input type="checkbox"> Abroad
                                    (Specify)</span>
                                <span class="border-b border-black inline-block w-1/2"></span>
                            </p>
                            <p class="italic">In case of Sick Leave:</p>
                            <p class="flex justify-between items-end"><span><input type="checkbox"> In Hospital (Specify
                                    Illness)</span> <span class="border-b border-black inline-block w-1/2"></span></p>
                            <p class="flex justify-between items-end"><span><input type="checkbox"> Out Patient (Specify
                                    Illness)</span> <span class="border-b border-black inline-block w-1/2"></span></p>
                            <p class="italic indent-2">In case of Special Leave Benefits for Women:</p>
                            <p class="flex justify-between indent-6">(Specify Illness): <span
                                    class="border-b border-black inline-block w-1/2"></span></p>
                            <p class="italic indent-2">In case of Study Leave:</p>
                            <p><input type="checkbox"> Completion of Master's Degree</p>
                            <p><input type="checkbox"> BAR/Board Examination Review Other</p>
                            <p class="flex justify-between indent-6"> purpose: <span
                                    class="border-b border-black inline-block w-1/2"></span></p>
                            <p><input type="checkbox"> Monetization of Leave Credits</p>
                            <p><input type="checkbox"> Terminal Leave</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class="mb-4 w-1/2 border-x border-b border-solid border-black p-1">
                    <div class="grid gap-y-10">
                        <div>
                            <p>6.C NUMBER OF WORKING DAYS APPLIED FOR</p>

                        </div>
                        <div class="space-y-6 px-10">
                            <div>

                                <p class="border-b border-black text-center font-bold">
                                    {{ (int) $getRecord()->days > 1 ? $getRecord()->days . ' Days' : $getRecord()->days . ' Day' }}
                                </p>
                                <p>INCLUSIVE DATES</p>
                            </div>
                            <p class="border-b border-black text-center font-bold">{{ $inclusive_date }}</p>
                        </div>
                    </div>
                </div>
                <div class="mb-4 w-1/2  border-r border-b border-solid border-black ">
                    <div class="">
                        <div class="grid ">
                            <p>6.D COMMUTATION</p>
                            <p class="indent-6"><input type="checkbox"> Not Requested</p>
                            <p class="indent-6"><input type="checkbox"> Requested</p>
                        </div>
                        <div class="w-full py-5 mt-8 ">
                            <p class=" border-b border-black text-center relative">
                                <img src="{{ asset('storage/' . $e_sign) }}"
                                    class="absolute -top-[6rem] left-1/2 transform -translate-x-1/2  w-[10rem] h-[10rem] "
                                    alt="">
                            </p>
                            <p class="text-center">(Signature of Applicant)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <p class="font-bold text-center border border-solid border-black">7. DETAILS OF ACTION ON APPLICATION
                </p>
                <div class="flex  mt-1 border border-solid border-black">
                    <div class="w-1/2 border-r border-black pr-4">
                        <p class="font-bold">7.A CERTIFICATION OF LEAVE CREDITS</p>
                        <div class="px-10 py-5 flex flex-col items-end">
                            <div class="flex">As of <div
                                    class="border-b border-black min-w-[20rem] text-center font-bold">
                                    {{ \Carbon\Carbon::parse($getRecord()->created_at)->subMonth()->endOfMonth()->format('F d, Y') }}
                                </div>
                            </div>
                            <table class="w-full border border-black mt-2">
                                <thead>
                                    <tr>
                                        <th class="border border-black"></th>
                                        <th class="border border-black">Vacation Leave</th>
                                        <th class="border border-black">Sick Leave</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-black">Total Earned</td>
                                        <td class="border border-black text-center">{{ $getRecord()->vl }}</td>
                                        <td class="border border-black text-center">{{ $getRecord()->sl }}</td>
                                    </tr>
                                    <tr>

                                        <td class="border border-black">Less this application</td>
                                        <td class="border border-black text-center">
                                            {{ $getRecord()->type_of_leave == 'Vacation Leave' || $getRecord()->type_of_leave == 'Mandatory/Forced Leave' ? $getRecord()->paid_days : '' }}
                                        </td>
                                        <td class="border border-black text-center">
                                            {{ $getRecord()->type_of_leave == 'Sick Leave' ? $getRecord()->paid_days : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-black">Balance</td>
                                        <td class="border border-black text-center">
                                            {{ $getRecord()->type_of_leave == 'Vacation Leave' || $getRecord()->type_of_leave == 'Mandatory/Forced Leave' ? (float) $getRecord()->vl - (float) $getRecord()->paid_days : $getRecord()->vl }}
                                        </td>
                                        <td class="border border-black text-center">
                                            {{ $getRecord()->type_of_leave == 'Sick Leave' ? (float) $getRecord()->sl - (float) $getRecord()->paid_days : $getRecord()->sl }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-10 w-full relative">
                                @if ($getRecord()->chiefInfo?->leavePointLatest?->e_sign && $getRecord()->location == 'Records' && $getRecord()->type_of_process == 'ELECTRONIC SIGNATURE')
                                    <img src="{{ asset('storage/' . $getRecord()->chiefInfo?->leavePointLatest?->e_sign) }}"
                                        class="absolute -top-[6rem] left-1/2 transform -translate-x-1/2  w-[10rem] h-[10rem] "
                                        alt="">
                                @endif
                                <p class="text-center font-bold">{{ $getRecord()->chiefInfo?->name }}</p>
                                <p class="text-center w-full border-t border-solid border-black">
                                    {{ $getRecord()->chief_type }}</p>
                            </div>
                        </div>
                    </div>
                    <div class=" w-1/2 pl-4">
                        <div class="text-sm font-bold mb-2">7.B RECOMMENDATION</div>
                        <div class="p-10">
                            <div class="flex items-center mb-2">
                                <input type="checkbox" class="mr-2">
                                <span class="text-sm">For approval</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <input type="checkbox" class="mr-2">
                                <span class="text-sm">For disapproval due to</span>
                                <span class="ml-2 border-b border-black flex-grow"></span>
                            </div>
                            <div class="border-b border-black mt-8"></div>
                            <div class="border-b border-black mt-8"></div>
                            <div class="relative">
                                @if (
                                    $getRecord()->headInfo?->leavePointLatest?->e_sign &&
                                        ($getRecord()->location == 'Chief' || $getRecord()->location == 'Rd' || $getRecord()->location == 'Records') && $getRecord()->type_of_process == 'ELECTRONIC SIGNATURE')
                                    <img src="{{ asset('storage/' . $getRecord()->headInfo?->leavePointLatest?->e_sign) }}"
                                        class="absolute -top-[6rem] left-1/2 transform -translate-x-1/2  w-[10rem] h-[10rem] "
                                        alt="">
                                @endif

                                <div class="border-b border-black font-bold  mt-9 text-center">
                                    {{ $getRecord()->headInfo?->name }}</div>
                                <div class="text-center text-sm">Chief of the Division/Section or Unit Head</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="flex justify-center items-center w">
                <div class="border-b border-x border-black p-4 w-full ">
                    <div class="flex justify-between">
                        <div class="w-1/2">
                            <p class="font-bold">7.C APPROVED FOR:</p>
                            <div class="flex items-center">
                                <span class="font-bold border-b border-black px-3"></span>
                                <span class="ml-2">days with pay</span>
                            </div>
                            <div class="flex items-center mt-2">
                                <span class="font-bold border-b border-black px-3"></span>
                                <span class="ml-2">days without pay</span>
                            </div>
                            <div class="flex items-center mt-2">
                                <span class="font-bold border-b border-black px-3"></span>
                                <span class="ml-2">others (Specify)</span>
                            </div>
                        </div>
                        <div class=" w-1/2 pl-4">

                            <div class="flex items-center mb-2">
                                <div class="text-sm font-bold ">7.D DISAPPROVED DUE TO: </div> <span
                                    class="ml-2 border-b border-black flex-grow"></span>
                            </div>
                            <div class="border-b border-black mt-8"></div>
                            <div class="border-b border-black mt-8"></div>
                            <div class="border-b border-black mt-8"></div>



                        </div>

                    </div>
                    <div class="flex justify-center items-center mt-20">
                        <div class="text-center relative">
                            @if ($getRecord()->rdInfo?->leavePointLatest?->e_sign && $getRecord()->location == 'Records' && $getRecord()->type_of_process == 'ELECTRONIC SIGNATURE')
                                <img src="{{ asset('storage/' . $getRecord()->rdInfo?->leavePointLatest?->e_sign) }}"
                                    class="absolute -top-[6rem] left-1/2 transform -translate-x-1/2  w-[10rem] h-[10rem] "
                                    alt="">
                            @endif
                            <p class="font-bold border-b border-black w-[24rem]">{{ $getRecord()->rdInfo?->name }}</p>
                            <p>{{ $getRecord()->rd_type }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
