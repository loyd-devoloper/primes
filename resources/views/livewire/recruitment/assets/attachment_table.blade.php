<div class="space-y-2 max-h-[70svh] overflow-y-auto">
    <div class="px-4 py-2 border {{$getRecord()->letter_of_intent_status ? 'checkFileApproved' : ''}} {{$getRecord()->letter_of_intent_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value }}</h1>
        <div class="flex items-center gap-2 mt-2">
            @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
            {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value)->getColumn()]) }}
            {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value)->getColumn()]) }}
                @endif
            @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value]) }}


        </div>
        <x-recruitment.comment  :id="$getRecord()->id"  :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value)" />
    </div>

    <div class="px-4 py-2 border {{$getRecord()->pds_status ? 'checkFileApproved' : ''}} {{$getRecord()->pds_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::PDS->value }}</h1>
        <div class="flex items-center gap-2 mt-2">
            @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
            {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PDS->value)->getColumn()]) }}
            {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PDS->value)->getColumn()]) }}
                @endif
            @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::PDS->value]) }}
        </div>
        <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::PDS->value)"/>
    </div>


    <div class="px-4 py-2 border {{$getRecord()->prc_status ? 'checkFileApproved' : ''}} {{$getRecord()->prc_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::PRC->value }}</h1>
        <div class="flex items-center gap-2 mt-2">
            @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
            {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PRC->value)->getColumn()]) }}
            {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PRC->value)->getColumn()]) }}
                @endif
            @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::PRC->value]) }}
        </div>
        <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::PRC->value)"/>
    </div>

    <div class="px-4 py-2 border {{$getRecord()->tor_status ? 'checkFileApproved' : ''}} {{$getRecord()->tor_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::TOR->value }}</h1>
        <div class="flex items-center gap-2 mt-2">
            @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
            {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::TOR->value)->getColumn()]) }}
            {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::TOR->value)->getColumn()]) }}
                @endif
            @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::TOR->value]) }}
        </div>
        <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::TOR->value)"/>
    </div>

    <div class="px-4 py-2 border {{$getRecord()->training_attended_status ? 'checkFileApproved' : ''}} {{$getRecord()->training_attended_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value }}</h1>
        <div class="flex items-center gap-2 mt-2">
            @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
            {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value)->getColumn()]) }}
            {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value)->getColumn()]) }}
                @endif
            @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value]) }}
        </div>
        <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value)"/>
    </div>

    <div class="px-4 py-2 border {{$getRecord()->certificate_of_employment_status ? 'checkFileApproved' : ''}} {{$getRecord()->certificate_of_employment_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value }}</h1>
        <div class="flex items-center gap-2 mt-2">
            @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
            {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value)->getColumn()]) }}
            {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value)->getColumn()]) }}
                @endif
            @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value]) }}
        </div>
        <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value)"/>
    </div>

    <div class="px-4 py-2 border {{$getRecord()->latest_appointment_status ? 'checkFileApproved' : ''}} {{$getRecord()->latest_appointment_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value }}</h1>
        <div class="flex items-center gap-2 mt-2">
            @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
            {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value)->getColumn()]) }}
            {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value)->getColumn()]) }}
                @endif
            @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value]) }}
        </div>
        <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value)"/>
    </div>

    <div class="px-4 py-2 border {{$getRecord()->performance_rating_status ? 'checkFileApproved' : ''}} {{$getRecord()->performance_rating_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value }}</h1>
        <div class="flex items-center gap-2 mt-2">
            @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
            {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value)->getColumn()]) }}
            {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value)->getColumn()]) }}
                @endif
            @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value]) }}
        </div>
        <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value)"/>
    </div>

    <div class="px-4 py-2 border {{$getRecord()->cav_status ? 'checkFileApproved' : ''}} {{$getRecord()->cav_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::CAV->value }}</h1>
        <div class="flex items-center gap-2 mt-2">


          @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
              @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
                    {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::CAV->value)->getColumn()]) }}
                    {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::CAV->value)->getColumn()]) }}
              @endif
          @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::CAV->value]) }}
        </div>
        <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::CAV->value)">
            {{  ($getAction('deletecomment'))(['id'=>\App\Enums\RecruitmentLabelEnum::CAV->value]) }}
            hello world
        </x-recruitment.comment>
    </div>

{{--    <div class="px-4 py-2 border {{$getRecord()->cav_status ? 'checkFileApproved' : ''}} {{$getRecord()->cav_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">--}}
{{--        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::CAV->value }}</h1>--}}
{{--        <div class="flex items-center gap-2 mt-2">--}}
{{--            {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::CAV->value)->getColumn()]) }}--}}

{{--            {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::CAV->value)->getColumn()]) }}--}}
{{--            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::TOR->value]) }}--}}
{{--        </div>--}}
{{--        <x-recruitment.comment :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::CAV->value)"/>--}}
{{--    </div>--}}

    <div class="px-4 py-2 border {{$getRecord()->neap_status ? 'checkFileApproved' : ''}} {{$getRecord()->neap_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::NEAP->value }}</h1>
        <div class="flex items-center gap-2 mt-2">


            @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
                    {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::NEAP->value)->getColumn()]) }}
                    {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::NEAP->value)->getColumn()]) }}
                @endif
            @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::NEAP->value]) }}
        </div>
        <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::NEAP->value)">
            {{  ($getAction('deletecomment'))(['id'=>\App\Enums\RecruitmentLabelEnum::NEAP->value]) }}

        </x-recruitment.comment>
    </div>

    <div class="px-4 py-2 border {{$getRecord()->movs_status ? 'checkFileApproved' : ''}} {{$getRecord()->movs_status == 2 ? 'checkFileDisApproved' : ''}} rounded-md">
        <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::MOVS->value }}</h1>
        <div class="flex items-center gap-2 mt-2">
            @if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                @if($getRecord()->application_status != 2 && $getRecord()->application_status != 4)
            {{  ($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::MOVS->value)->getColumn()]) }}
            {{  ($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::MOVS->value)->getColumn()]) }}
                @endif
            @endif
            {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::MOVS->value]) }}
        </div>
        <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::MOVS->value)"/>
    </div>
{{--    group--}}
    <div class="pl-5 space-y-2">
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::AWARDS_AND_RECOGNITION->value }}</h1>
            <div class="flex items-center gap-2 mt-2">

                {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::AWARDS_AND_RECOGNITION->value]) }}
            </div>
            <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::AWARDS_AND_RECOGNITION->value)"/>
        </div>
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::RESEARCH_AND_INNOVATION->value }}</h1>
            <div class="flex items-center gap-2 mt-2">

                {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::RESEARCH_AND_INNOVATION->value]) }}
            </div>
            <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::RESEARCH_AND_INNOVATION->value)"/>
        </div>
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::MEMBERSHIP_IN_NATIONAL->value }}</h1>
            <div class="flex items-center gap-2 mt-2">

                {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::MEMBERSHIP_IN_NATIONAL->value]) }}
            </div>
            <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::MEMBERSHIP_IN_NATIONAL->value)"/>
        </div>
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::RESOURCE_AND_SPEAKERSHIP->value }}</h1>
            <div class="flex items-center gap-2 mt-2">

                {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::RESOURCE_AND_SPEAKERSHIP->value]) }}
            </div>
            <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::RESOURCE_AND_SPEAKERSHIP->value)"/>
        </div>
{{--        <div class="px-4 py-2 border  rounded-md">--}}
{{--            <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::NEAP->value }}</h1>--}}
{{--            <div class="flex items-center gap-2 mt-2">--}}

{{--                {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::NEAP->value]) }}--}}
{{--            </div>--}}
{{--            <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::NEAP->value)"/>--}}
{{--        </div>--}}
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::APPLICATION_OF_EDUCATION->value }}</h1>
            <div class="flex items-center gap-2 mt-2">

                {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::APPLICATION_OF_EDUCATION->value]) }}
            </div>
            <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::APPLICATION_OF_EDUCATION->value)"/>
        </div>
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs">{{ \App\Enums\RecruitmentLabelEnum::LEARNING_AND_DEVELOPMENT->value }}</h1>
            <div class="flex items-center gap-2 mt-2">

                {{  ($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::LEARNING_AND_DEVELOPMENT->value]) }}
            </div>
            <x-recruitment.comment :id="$getRecord()->id" :comments="$getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::LEARNING_AND_DEVELOPMENT->value)"/>
        </div>
    </div>
</div>
