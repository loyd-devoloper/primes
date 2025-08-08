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
<x-assets.admin_layout target="modalFormUpdateJobAction,modalFormChangeBatchAction,modalFormChangeBatch,callMountedTableAction,unmountFormComponentAction,deleteComment">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <div>


        @if (Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
        <x-bread-crumb class="py-10 " :list="[
            [
                'link' => null,
                'name' => 'Recruitment',
            ],
            [
                'link' => route('recruitment.jobs'),
                'name' => 'Jobs',
            ],
            [
                'link' => null,
                'name' => $job_title,
            ],
        ]" />
            <div class="space-y-10">
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-1 text-sm">
                            <x-filament::icon icon="heroicon-o-information-circle" class="size-5" /> Job Information
                        </div>
                    </x-slot>
                    <x-slot name="headerEnd">
                        <x-filament::input.wrapper size="xs">
                            <x-filament::input.select wire:model.live="batch">
                                @foreach ($batches as $batch)
                                    <option value="{{ $batch?->batch_id }}">{{ $batch?->batch_name }}</option>
                                @endforeach
                            </x-filament::input.select>
                        </x-filament::input.wrapper>
                    </x-slot>
                    <main class="grid grid-cols-1 md:grid-cols-2 gap-y-10">
                        <div>
                            <div class="flex gap-20 text-sm">
                                <div class="space-y-3">
                                    <h1 class="dark:text-white text-gray-500">Batch</h1>
                                    <h1 class="dark:text-white text-gray-500">Position Title</h1>
                                    <h1 class="dark:text-white text-gray-500">Plantilla Item</h1>
                                    <h1 class="dark:text-white text-gray-500">Status of hiring</h1>
                                    <h1 class="dark:text-white text-gray-500">Status of appointment</h1>
                                    <h1 class="dark:text-white text-gray-500">Posting Date</h1>
                                    <h1 class="dark:text-white text-gray-500">Closing Date</h1>
                                    <h1 class="dark:text-white text-gray-500">No. Of Applicant</h1>
                                </div>
                                <div class="space-y-3">
                                    <h1 class="dark:text-white text-black font-medium">
                                        {{ $currentBatch?->batch_name ?? 'N/A' }}
                                    </h1>
                                    <h1 class="dark:text-white text-black font-medium">{{ $jobInfo?->job_title ?? 'N/A' }}
                                    </h1>
                                    <h1 class="dark:text-white text-black font-medium">
                                        {{ $jobInfo?->plantilla_item ?? 'N/A' }}
                                    </h1>
                                    <h1 class="dark:text-white text-black font-medium">
                                        {{ $jobInfo?->status_of_hiring ?? 'N/A' }}
                                    </h1>
                                    <h1 class="dark:text-white text-black font-medium">
                                        {{ $jobInfo?->status_of_appointment ?? 'N/A' }}</h1>

                                    <h1 class="dark:text-white text-black font-medium">
                                        {{ $currentBatch?->posting_date ? \Carbon\Carbon::parse($currentBatch?->posting_date)->format('F d, Y h:i:s A') : 'N/A' }}
                                    </h1>
                                    <h1 class="dark:text-white text-black font-medium">
                                        {{ $currentBatch?->closing_date ? \Carbon\Carbon::parse($currentBatch?->closing_date)->format('F d, Y h:i:s A') : 'N/A' }}
                                    </h1>
                                    <h1 class="dark:text-white text-black font-medium">
                                        <x-filament::badge class="w-fit" color="warning">
                                            {{ $jobInfo?->all_applicant_count ?? 'N/A' }}
                                        </x-filament::badge>

                                    </h1>

                                </div>
                            </div>
                            @if (Auth::user()->fd_code == '01D' || Auth::user()->can('RECRUITMENT') )
                            <x-filament::fieldset>
                                <x-slot name="label">
                                    Job Button
                                </x-slot>

                                <div class="flex flex-wrap gap-2">
                                    {{ $this->modalFormUpdateJobAction }}
                                    {{ $this->modalFormChangeBatchAction }}
                                    {{ $this->modalFormPsbAndOtherInformationAction }}
                                    {{ $this->modalFormActivityLogAction }}
                                    {{ $this->modalFormPsbGradingAction }}
                                    {{ $this->modalFormCarFileAction }}
                                </div>
                            </x-filament::fieldset>
                            @endif
                        </div>
                        <div class="flex justify-center items-start gap-20 text-sm">
                            <div class=" flex justify-center items-center ">
                                <div class="flex flex-col items-center">
                                    {{-- hired applicant --}}
                                    <div class="flex flex-col items-center mb-8">
                                        <img alt="Profile picture of Ziko Sichi"
                                            class="rounded-full border-2 dark:border-4 border-black dark:border-white"
                                            height="100" src="{{ asset('assets/no_image.jpg') }}" width="100" />
                                        <div class="mt-2 text-black dark:text-white text-center">
                                            <strong>
                                                {{ $currentBatch?->hiredInfo ? $currentBatch?->hiredInfo?->fname . ' ' . $currentBatch?->hiredInfo?->lname : 'N/A' }}
                                            </strong>
                                            <p class="text-sm text-gray-800 dark:text-teal-500 ">
                                                Hired
                                            </p>
                                        </div>
                                    </div>
                                    {{-- all psb --}}
                                    <div class="flex justify-between w-full max-w-4xl">
                                        <div class="grid grid-cols-3 md:grid-cols-2 lg:grid-cols-4 gap-10 w-full">
                                            @foreach ($psbMembers as $psb)
                                                <div class="flex flex-col items-center">
                                                    <img alt="Profile picture of Anne Potts"
                                                        class="rounded-full border-2 dark:border-4 border-black dark:border-white min-h-20 min-w-20  max-h-20 max-w-20 "

                                                        src="{{ !!$psb?->psbInformation?->profile ? asset('storage/' . $psb?->psbInformation?->profile) : asset('assets/no_image.jpg') }}"
                                                        />
{{--                                                    <x-filament::avatar--}}
{{--                                                        src="{{ !!$psb?->psbInformation?->profile ? asset('storage/' . $psb?->psbInformation?->profile) : asset('assets/no_image.jpg') }}"--}}
{{--                                                        alt="Dan Harrin"--}}
{{--                                                        size="lg"--}}
{{--                                                    />--}}
                                                    <div class="mt-2 text-black dark:text-white text-center">
                                                        <strong>
                                                            {{ $psb?->psbInformation?->name }}
                                                        </strong>
                                                        <p class="text-sm text-gray-800 dark:text-teal-400">
                                                            HRMPSB MEMBER
                                                        </p>
                                                    </div>
                                                </div>

                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </main>
                    {{-- Content --}}
                </x-filament::section>

                <x-filament::section>
                    <x-slot name="heading">
                        <x-filament::tabs label="Content tabs">
                            <x-filament::tabs.item icon="heroicon-o-list-bullet"
                                class="{{ $activeTab === 'all' ? 'border' : '' }}" :active="$activeTab === 'all'" :disabled="$activeTab === 'all'"
                                x-on:click="changeTab('all')">
                                ALL
                                <x-slot name="badge">
                                    {{ $allCount }}
                                </x-slot>
                            </x-filament::tabs.item>
                            <x-filament::tabs.item id="checkfile" icon="heroicon-o-clipboard-document-check"
                                class="{{ $activeTab === 'checkfile' ? 'border' : '' }}" :active="$activeTab === 'checkfile'"
                                :disabled="$activeTab === 'checkfile'" x-on:click="changeTab('checkfile')">
                                <span class="whitespace-nowrap">Check Requirements</span>
                                <x-slot name="badge" class="bg-red-500">
                                    {{ $checkFileCount }}
                                </x-slot>
                            </x-filament::tabs.item>


                            <x-filament::tabs.item id="validator" icon="heroicon-o-magnifying-glass-circle"
                                class="{{ $activeTab === 'validator' ? 'border' : '' }}" :active="$activeTab === 'validator'"
                                :disabled="$activeTab === 'validator'" x-on:click="changeTab('validator')">
                                Validator
                                <x-slot name="badge" color="danger">
                                    {{ $validatorCount }}
                                </x-slot>
                            </x-filament::tabs.item>


                            <x-filament::tabs.item id="qualified" icon="heroicon-o-shield-check"
                                class="{{ $activeTab === 'qualified' ? 'border' : '' }}" :active="$activeTab === 'qualified'"
                                :disabled="$activeTab === 'qualified'" x-on:click="changeTab('qualified')">
                                Qualified
                                <x-slot name="badge" color="danger">
                                    {{ $qualifiedCount }}
                                </x-slot>
                            </x-filament::tabs.item>
                            <x-filament::tabs.item id="notqualified" icon="heroicon-o-no-symbol"
                                class="{{ $activeTab === 'notqualified' ? 'border' : '' }}" :active="$activeTab === 'notqualified'"
                                :disabled="$activeTab === 'notqualified'" x-on:click="changeTab('notqualified')">
                                Not Qualified
                                <x-slot name="badge" color="danger">
                                    {{ $notqualifiedCount }}
                                </x-slot>
                            </x-filament::tabs.item>
                        </x-filament::tabs>
                    </x-slot>

                    <div class=" w-full" wire:loading wire:loading.delay.longest wire:target="changeTab">
                        <div class="relative mx-auto my-20 w-fit">
                            <img src="{{ asset('assets/r4a.png') }}"
                                class="min-w-[4rem] max-w-[4rem] min-h-[4rem] max-h-[4rem]  rounded-full " alt="">
                            <svg viewBox="0 0 250 250"
                                class="fill-black dark:fill-white animate-spin-slow absolute -top-4 -left-4   min-w-[6rem] max-w-[6rem] min-h-[6rem] max-h-[6rem]">
                                <path id="curve" class="fill-transparent" d="M 25 125 A 100 100 0 1 1 25 127"></path>
                                <text class=" font-bold text-3xl">
                                    <textPath href="#curve">
                                        DEPED CALABARZON
                                    </textPath>
                                </text>
                            </svg>


                        </div>

                    </div>
                    <div wire:loading.remove wire:target="changeTab" class="min-w-full max-w-full">
                        {{ $this->table }}
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




            },
            async changeTab($value) {
                await $wire.changeTab($value);
                $wire.$refresh()
            }
        }));
    </script>
@endscript
