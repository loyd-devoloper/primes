@assets
    <style>
        .trSplit>div {
            width: 100%;
        }

        .trSplit>div>.max-w-max {
            min-width: 100%;

        }

        .trSplit>div>.max-w-max>div {
            min-width: 100%;

        }

        .trSplit>div>.max-w-max>div>span {
            min-width: 100%;
            display: flex;
            justify-content: space-around
        }

        .fi-table-header-cell-i-n-c-l-u-s-i-v-e-d-a-t-e-s>span>span {

            min-width: 100%;
        }
    </style>
@endassets
<x-assets.admin_layout target="callMountedTableAction,unmountFormComponentAction">


    <x-slot name="modal">
        <div x-cloak class="z-50">
            {{-- <x-filament-actions::modals class="z-50" /> --}}
        </div>
    </x-slot>
    <div>


    @if (Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
            {{-- children container  --}}
            <div class="mt-6">






                <x-filament::section>
                    <x-slot name="heading">
                        HRMPSB GRADING MONITORING (<span class="font-bold">{{ $this->job_title }}</span class="font-bold">)
                    </x-slot>
                    <x-slot name="headerEnd">
                        <x-filament::button size="sm" icon="heroicon-o-arrow-long-right" icon-position="after"
                            href="{{ route('recruitment.view_job', ['job_id' => $this->job_id, 'job_title' => $this->job_title,'batch'=>$this->batch]) }}"
                            tag="a">
                            BACK TO APPLICANTS
                        </x-filament::button>
                    </x-slot>

                    <div class="w-full " wire:loading wire:loading.delay.longest wire:target="changeTab">
                        <x-filament::loading-indicator class="size-14 mx-auto mt-10" />
                    </div>



                    <div wire:ignore wire:poll>

                        <x-zeus-accordion::accordion activeAccordion="1">
                            @foreach ($applicantData as $psb)
                                <x-zeus-accordion::accordion.item wire:poll :isIsolated="true" :open="false"
                                    :label="__($psb?->psbInformation?->name)" :active="false" icon="heroicon-o-lock-closed" badgeColor="danger">
                            <div class="bg-white dark:bg-bgDark dark:text-white p-4 *:py-1">
                                @foreach ($psb->applicants as $applicant)
                                    <div class="flex gap-3">
                                        @if ($this->grade($applicant?->application_code, $psb->id_number, $applicant?->batch_id))
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor"
                                                 class="min-h-[1.5rem] max-h-[1.5rem]  min-w-[1.5rem] max-w-[1.5rem] text-green-500 font-bold">
                                                <path fill-rule="evenodd"
                                                      d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                                      clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor"
                                                 class="min-h-[1.5rem] max-h-[1.5rem]  min-w-[1.5rem] max-w-[1.5rem] text-red-500 font-bold">
                                                <path fill-rule="evenodd"
                                                      d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                                      clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                        <p>{{ $applicant?->lname . ', ' . $applicant?->fname . ' ' . $applicant?->mname }}
                                        </p>
                                        @if ($loop->parent->first)
                                            <x-filament::button size="xs" color="success"
                                                                icon="heroicon-o-printer"
                                                                wire:confirm="Are you sure you want to download this IES?"
                                                                wire:click="applicantPrint({{ $applicant }},{{ $psb }})"
                                                                class="!h-fit">
                                                Excel
                                            </x-filament::button>
                                        @endif
                                        {{-- <x-filament::button size="xs" color="danger" icon="heroicon-o-printer"
                                        outline
                                        wire:click="applicantPrintPdf({{ $applicant }},{{ $psb }})">
                                        Pdf
                                    </x-filament::button> --}}
                                    </div>
                                @endforeach

                            </div>
                                </x-zeus-accordion::accordion.item>
                            @endforeach


                        </x-zeus-accordion::accordion>
                    </div>
                    {{-- Content --}}
                </x-filament::section>

            </div>
        @else
            <div class=" mx-auto w-fit">
                @include('components.restrict')
            </div>
        @endif
    </div>
</x-assets.admin_layout>

@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            clickMe: null,
            init() {
                // const accordionItems = document.querySelectorAll('.accordion-item'); // Adjust the selector based on your component's structure
                // accordionItems.forEach(item => {
                //     const content = item.querySelector('.accordion-collapse'); // Adjust based on your component's structure
                //     if (content) {
                //         content.classList.add('show'); // Add 'show' class to open the item
                //         content.style.display = 'block'; // Ensure the item is displayed
                //     }
                // });


            },

        }));
    </script>
@endscript
