<div class=" ">

    {{-- check if link is not null --}}
    {{-- {{ dd($getRecord()) }} --}}
    {{-- <h1 class="text-2xl font-bold dark:text-white py-3">Applicant Attachments</h1> --}}

    <x-zeus-accordion::accordion activeAccordion="20">
        <x-zeus-accordion::accordion.item :isIsolated="false" :label="\App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT" icon="heroicon-o-chevron-right"
           class="!p-0">
            <div class="bg-white !p-0 ">
                @if (!!$getRecord()->letter_of_intent)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->letter_of_intent) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::PDS" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->pds)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->pds) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>


        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::PRC" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->prc)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->prc) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white ">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>
{{--
        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::ELIGIBILITY" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->eligibility)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->eligibility) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item> --}}

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::TOR" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->tor)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->tor) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->training_attended)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->training_attended) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->certificate_of_employment)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->certificate_of_employment) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->latest_appointment)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->latest_appointment) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>


        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->performance_rating)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->performance_rating) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::CAV" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->cav)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->cav) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>


          <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::AWARDS_AND_RECOGNITION" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->awards_recognition)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->awards_recognition) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::RESEARCH_AND_INNOVATION" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->research_innovation)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->research_innovation) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::RESEARCH_AND_INNOVATION" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->research_innovation)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->research_innovation) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>
        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::MEMBERSHIP_IN_NATIONAL" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->membership_in_national)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->membership_in_national) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::RESOURCE_AND_SPEAKERSHIP" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->resource_speakership)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->resource_speakership) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>
        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::NEAP" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->neap)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->neap) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::APPLICATION_OF_EDUCATION" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->application_of_education)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->application_of_education) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                      <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>

        <x-zeus-accordion::accordion.item :isIsolated="false"  :label="\App\Enums\RecruitmentLabelEnum::LEARNING_AND_DEVELOPMENT" icon="heroicon-o-chevron-right">
            <div class="bg-white ">
                @if (!!$getRecord()->l_and_d)
                    <object
                        data="{{ asset('storage/recruitment/application/' . $getRecord()->jobInfo?->id . '/' . $getRecord()->batchInfo?->id . '/' . $getRecord()->email . '/' . $getRecord()->l_and_d) }}"
                        type="application/pdf" width="100%" style="height: 80dvh">
                        <p class="dark:text-white">No Attachment</p>
                    </object>
                @else
                    <img src="{{ asset('assets/no-attachment.jpg') }}" alt="">
                @endif
            </div>
        </x-zeus-accordion::accordion.item>
    </x-zeus-accordion::accordion>
</div>
