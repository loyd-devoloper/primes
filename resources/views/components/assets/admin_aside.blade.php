<aside
    class="  min-h-[100svh] min-w-[270px] max-w-[270px] p-2    bg-white dark:bg-bgDarkLight shadow z-0 fixed left-0 xl:relative ">
    {{-- logo --}}
    <img src="{{ asset('login.png') }}" class="avatar w-[9rem] sm:w-[11rem] mt-2" alt="">
    <button class="text-white hover:opacity-85 absolute top-5 z-50 right-3 block xl:hidden" x-on:click='aside = !aside'>

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="w-6 h-6 text-red-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
        </svg>


    </button>
    {{-- user name and ID SECTION --}}
    <div class="p-2 mt-5">
        <h2 class="font-semibold dark:text-white">{{ Auth::user()->name }}</h2>
        <p class="text-xs text-gray-500 dark:text-gray-400">EMPLOYEE ID:
            {{ !!Auth::user()->employee_id ? Illuminate\Support\Facades\Crypt::decryptString(Auth::user()->employee_id) : null }}
        </p>
    </div>

    {{-- links --}}
    <ul wire:ignore class="menu  w-full grid gap-2 mt-8 max-h-[70svh] overflow-y-auto  " x-data="{
        dropdown: {{ request()->routeIs('personnel.pds.personal_informatiom') || request()->routeIs('personnel.pds.family_background') || request()->routeIs('personnel.pds.educational_background') || request()->routeIs('personnel.pds.eligibility') || request()->routeIs('personnel.pds.work_experience') || request()->routeIs('personnel.pds.affiliation_involvement') || request()->routeIs('personnel.pds.learning_development') || request()->routeIs('personnel.pds.skill_hobbies') || request()->routeIs('personnel.pds.distinction') || request()->routeIs('personnel.pds.association') || request()->routeIs('personnel.pds.other_info') ? 'true' : 'false' }},
        dropdown_recruitment: {{ request()->routeIs('recruitment.jobs') || request()->routeIs('recruitment.application.table') || request()->routeIs('recruitment.applications') || request()->routeIs('recruitment.all.applicant') || request()->routeIs('recruitment.monitoring') || request()->routeIs('recruitment.psb') ? 'true' : 'false' }},
        dropdown_recruitment_step1: {{ request()->routeIs('recruitment.step1.checkfile') || request()->routeIs('recruitment.step1.checkfile.checkfiletable') ? 'true' : 'false' }},
        dropdown_leave: {{ request()->routeIs('leave.employees') || request()->routeIs('leave.personnel.calendar') || request()->routeIs('leave.employees.view') || request()->routeIs('leave.all_request') || request()->routeIs('leave.my_leave') || request()->routeIs('leave.request.view') || request()->routeIs('leave.head.tab') || request()->routeIs('leave.chief.tab') || request()->routeIs('leave.rd.tab') | request()->routeIs('leave.personnel.advance_setting') || request()->routeIs('leave.records.pending') || request()->routeIs('leave.records.archived') ? 'true' : 'false' }},
        dropdown_personnel_leave: {{ request()->routeIs('leave.employees') || request()->routeIs('leave.personnel.advance_setting') || request()->routeIs('leave.personnel.calendar') ? 'true' : 'false' }},
        dropdown_records_leave: {{ request()->routeIs('leave.records.pending') || request()->routeIs('leave.records.archived') ? 'true' : 'false' }},
        dropdown_user_management: {{ request()->routeIs('user_management.permission') || request()->routeIs('user_management.users') ? 'true' : 'false' }}
    }">
        {{-- ########################################### Dashboard ###################################################### --}}
        <x-filament::tabs.item wire:navigate tag='a' href="{{ route('personnel.home') }}"
                               icon='heroicon-o-computer-desktop' active="{{ request()->routeIs('personnel.home') }}">
            Dashboard
        </x-filament::tabs.item>
        {{-- ################################################## Task Board ###################################################### --}}
        @if (Auth::user()->fd_code == '01D')
            <x-filament::tabs.item wire:navigate tag='a' href="{{ route('task') }}"
                                   icon='heroicon-o-rectangle-stack' active="{{ request()->routeIs('task') }}">
                Task Board
            </x-filament::tabs.item>
        @endif
        {{-- ########################################### PDS ############################################################ --}}
        <x-filament::tabs.item icon='heroicon-o-document' class="relative" x-on:click="dropdown = !dropdown"
                               active="{{ request()->routeIs('personnel.pds.personal_informatiom') || request()->routeIs('personnel.pds.family_background') || request()->routeIs('personnel.pds.educational_background') || request()->routeIs('personnel.pds.eligibility') || request()->routeIs('personnel.pds.work_experience') || request()->routeIs('personnel.pds.affiliation_involvement') || request()->routeIs('personnel.pds.learning_development') || request()->routeIs('personnel.pds.skill_hobbies') || request()->routeIs('personnel.pds.distinction') || request()->routeIs('personnel.pds.association') || request()->routeIs('personnel.pds.other_info') }}">
            Personal Data Sheet
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-5 h-5 absolute top-2 right-2" :class="dropdown ? 'rotate-90' : ''">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
            </svg>

        </x-filament::tabs.item>

        <div class="px-5 w-full grid gap-1" x-show="dropdown" x-transition>
            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.personal_informatiom') }}"
                                   active="{{ request()->routeIs('personnel.pds.personal_informatiom') }}">
                Personal Information
            </x-filament::tabs.item>

            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.family_background') }}"
                                   active="{{ request()->routeIs('personnel.pds.family_background') }}">
                Family Background
            </x-filament::tabs.item>
            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.educational_background') }}"
                                   active="{{ request()->routeIs('personnel.pds.educational_background') }}">
                Educational Background
            </x-filament::tabs.item>
            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.eligibility') }}"
                                   active="{{ request()->routeIs('personnel.pds.eligibility') }}">
                Eligibility
            </x-filament::tabs.item>
            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.work_experience') }}"
                                   active="{{ request()->routeIs('personnel.pds.work_experience') }}">
                Work Experience
            </x-filament::tabs.item>
            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.affiliation_involvement') }}"
                                   active="{{ request()->routeIs('personnel.pds.affiliation_involvement') }}">
                Affiliation / Involvement
            </x-filament::tabs.item>
            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.learning_development') }}"
                                   active="{{ request()->routeIs('personnel.pds.learning_development') }}">
                Learning & Development
            </x-filament::tabs.item>
            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.skill_hobbies') }}"
                                   active="{{ request()->routeIs('personnel.pds.skill_hobbies') }}">
                Skills & Hobbies
            </x-filament::tabs.item>

            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.distinction') }}"
                                   active="{{ request()->routeIs('personnel.pds.distinction') }}">
                Distinctions / Recognition
            </x-filament::tabs.item>
            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.association') }}"
                                   active="{{ request()->routeIs('personnel.pds.association') }}">
                Association / Organization
            </x-filament::tabs.item>
            <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                   href="{{ route('personnel.pds.other_info') }}"
                                   active="{{ request()->routeIs('personnel.pds.other_info') }}">
                Other Info
            </x-filament::tabs.item>

            <form action="{{ route('exportPds') }}" method="POST" class="mt-2">
                @csrf
                <x-filament::button color="danger" icon='heroicon-o-arrow-down-on-square' type="submit">
                    Download PDS
                </x-filament::button>

            </form>


        </div>


        <span class="py-2 rounded mt-6  font-bold text-center text-sm uppercase text-red-600 ">Administrator
            Panel</span>

        {{-- ################################################## GAD ###################################################### --}}
        {{-- <x-filament::tabs.item wire:navigate tag='a' href="{{ route('cad.home') }}" icon='heroicon-o-chart-pie'
            active="{{ request()->routeIs('cad.home') }}">
            GAD
        </x-filament::tabs.item> --}}



        {{-- ################################################## RECRUITMENT ################################################### --}}
        @if (Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value) || count(Auth::user()->psb) > 0)
            <x-filament::tabs.item icon='heroicon-o-user-group' class="relative"
                                   x-on:click="dropdown_recruitment = !dropdown_recruitment"
                                   active="{{ request()->routeIs('recruitment.jobs') || request()->routeIs('recruitment.applications') || request()->routeIs('recruitment.step1.checkfile.checkfiletable') || request()->routeIs('recruitment.all.applicant') || request()->routeIs('recruitment.monitoring') || request()->routeIs('recruitment.psb') }}">
                Recruitment
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5 absolute top-2 right-2"
                     :class="dropdown_recruitment ? 'rotate-90' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>

            </x-filament::tabs.item>

            <div class="px-5 w-full grid gap-1" x-show="dropdown_recruitment" x-transition>
                @if (Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
                    <x-filament::tabs.item wire:navigate icon='heroicon-o-plus-circle' tag='a'
                                           href="{{ route('recruitment.jobs') }}"
                                           active="{{ request()->routeIs('recruitment.jobs') }}">
                        Jobs
                    </x-filament::tabs.item>
                    <x-filament::tabs.item wire:navigate icon='heroicon-o-list-bullet' tag='a'
                                           href="{{ route('recruitment.all.applicant') }}"
                                           active="{{ request()->routeIs('recruitment.all.applicant') }}">
                        All Applicants
                    </x-filament::tabs.item>
                    <x-filament::tabs.item wire:navigate icon='heroicon-o-presentation-chart-bar' tag='a'
                                           href="{{ route('recruitment.monitoring') }}"
                                           active="{{ request()->routeIs('recruitment.monitoring') }}">
                        Monitoring
                    </x-filament::tabs.item>
                @endif
                @if (count(Auth::user()->psb) > 0)
                    <x-filament::tabs.item wire:navigate icon='heroicon-o-shield-check' tag='a'
                                           href="{{ route('recruitment.psb') }}"
                                           active="{{ request()->routeIs('recruitment.psb') }}">
                        HRMPSB
                    </x-filament::tabs.item>
                @endif

            </div>
        @endif

        {{-- ################################################## Leave ################################################### --}}
        <x-filament::tabs.item icon='heroicon-o-calendar-days' class="relative"
                               x-on:click="dropdown_leave = !dropdown_leave"
                               active="{{ request()->routeIs('leave.records.pending') || request()->routeIs('leave.employees.view') || request()->routeIs('leave.all_request') || request()->routeIs('leave.my_leave') || request()->routeIs('leave.request.view') || request()->routeIs('leave.head.tab') || request()->routeIs('leave.chief.tab') || request()->routeIs('leave.rd.tab') || request()->routeIs('leave.personnel.advance_setting') }}">
            Leave Management
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-5 h-5 absolute top-2 right-2"
                 :class="dropdown_recruitment ? 'rotate-90' : ''">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
            </svg>

        </x-filament::tabs.item>
        <div class="px-5 w-full grid gap-1" x-show="dropdown_leave" x-transition>
            <x-filament::tabs.item wire:navigate icon='heroicon-o-numbered-list' tag='a'
                                   href="{{ route('leave.my_leave') }}"
                                   active="{{ request()->routeIs('leave.my_leave') }}">
                My Leave
            </x-filament::tabs.item>

            @if (Auth::user()->user_fd_code?->id_number == Auth::user()->id_number)
                <x-filament::tabs.item wire:navigate icon='heroicon-o-user-circle' tag='a'
                                       href="{{ route('leave.head.tab') }}"
                                       active="{{ request()->routeIs('leave.head.tab') }}">
                    Head
                </x-filament::tabs.item>
            @endif
            @if (Auth::user()->fd_code == '08')
                <x-filament::tabs.item wire:navigate icon='heroicon-o-numbered-list' tag='a'
                                       href="{{ route('leave.chief.tab') }}"
                                       active="{{ request()->routeIs('leave.chief.tab') }}">
                    Chief
                </x-filament::tabs.item>
            @endif
            @if (Auth::user()->fd_code == '01' || Auth::user()->fd_code == '01A')
                <x-filament::tabs.item wire:navigate icon='heroicon-o-shield-check' tag='a'
                                       href="{{ route('leave.rd.tab') }}"
                                       active="{{ request()->routeIs('leave.rd.tab') }}">
                    RD/ARD
                </x-filament::tabs.item>
            @endif


            @if (Auth::user()->fd_code == '01D' || Auth::user()->fd_code == '08C')
                <x-filament::tabs.item icon='heroicon-o-arrow-top-right-on-square' class="relative"
                                       x-on:click="dropdown_personnel_leave = !dropdown_personnel_leave"
                                       active="{{ request()->routeIs('leave.employees') || request()->routeIs('leave.personnel.advance_setting') || request()->routeIs('leave.personnel.calendar') }}">
                    Personnel Section
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5 absolute top-2 right-2"
                         :class="dropdown_recruitment ? 'rotate-90' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                    </svg>

                </x-filament::tabs.item>
                <div class="px-5 w-full grid gap-1" x-show="dropdown_personnel_leave" x-transition>
                    <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                           href="{{ route('leave.employees') }}"
                                           active="{{ request()->routeIs('leave.employees') || request()->routeIs('leave.employees.view') }}">
                        Employees
                    </x-filament::tabs.item>
                    <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                           href="{{ route('leave.personnel.calendar') }}"
                                           active="{{ request()->routeIs('leave.personnel.calendar')  }}">
                        Calendar
                    </x-filament::tabs.item>
                    <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                           href="{{ route('leave.personnel.advance_setting') }}"
                                           active="{{ request()->routeIs('leave.personnel.advance_setting') || request()->routeIs('leave.personnel.advance_setting') }}">
                        Advance Setting
                    </x-filament::tabs.item>
                </div>
            @endif
            @if (Auth::user()->fd_code == '01D' || Auth::user()->fd_code == '08D')
                <x-filament::tabs.item icon='heroicon-o-arrow-top-right-on-square' class="relative"
                                       x-on:click="dropdown_records_leave = !dropdown_records_leave"
                                       active="{{ request()->routeIs('leave.records.pending') || request()->routeIs('leave.records.archived') }}">
                    Records Section
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5 absolute top-2 right-2"
                         :class="dropdown_recruitment ? 'rotate-90' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                    </svg>

                </x-filament::tabs.item>
                <div class="px-5 w-full grid gap-1" x-show="dropdown_records_leave" x-transition>
                    <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                           href="{{ route('leave.records.pending') }}"
                                           active="{{ request()->routeIs('leave.records.pending') }}">
                        Pending
                    </x-filament::tabs.item>
                    <x-filament::tabs.item wire:navigate icon='radix-dot' tag='a'
                                           href="{{ route('leave.records.archived') }}"
                                           active="{{ request()->routeIs('leave.records.archived') }}">
                        Archived
                    </x-filament::tabs.item>
                </div>
            @endif

        </div>

        {{-- ################################################## Generating ID ###################################################### --}}
        @if (Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::GENERATING_ID->value))
            <x-filament::tabs.item wire:navigate tag='a' href="{{ route('id.dashboard') }}"
                                   icon='heroicon-o-identification'
                                   active="{{ request()->routeIs('id.dashboard') || request()->routeIs('id.template') }}">
                Generating ID
            </x-filament::tabs.item>
        @endif
        {{-- ################################################## Office Management ###################################################### --}}
        @if (Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::OFFICE_MANAGEMENT->value))
            <x-filament::tabs.item wire:navigate tag='a' href="{{ route('offices') }}"
                                   icon='heroicon-o-building-office-2' active="{{ request()->routeIs('offices') }}">
                Office Management
            </x-filament::tabs.item>
        @endif

        {{-- ################################################## User Management ################################################### --}}
        @if (Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::USER_MANAGEMENT->value))
            <x-filament::tabs.item icon='heroicon-o-users' class="relative"
                                   x-on:click="dropdown_user_management = !dropdown_user_management"
                                   active="{{ request()->routeIs('user_management.permission') || request()->routeIs('user_management.users') }}">
                User Management
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5 absolute top-2 right-2"
                     :class="dropdown_user_management ? 'rotate-90' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>

            </x-filament::tabs.item>

            <div class="px-5 w-full grid gap-1" x-show="dropdown_user_management" x-transition>
                <x-filament::tabs.item wire:navigate icon='heroicon-o-user-group' tag='a'
                                       href="{{ route('user_management.users') }}"
                                       active="{{ request()->routeIs('user_management.users') }}">
                    users
                </x-filament::tabs.item>
                <x-filament::tabs.item wire:navigate icon='heroicon-o-eye-slash' tag='a'
                                       href="{{ route('user_management.permission') }}"
                                       active="{{ request()->routeIs('user_management.permission') }}">
                    Permission
                </x-filament::tabs.item>


            </div>
        @endif

    </ul>

    <p class="absolute bottom-2 left-2 text-black dark:text-white">V 1.0 </p>
</aside>
