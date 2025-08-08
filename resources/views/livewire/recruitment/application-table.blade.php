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
<x-assets.admin_layout target="callMountedTableAction,unmountFormComponentAction,deleteComment">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>

    @if (Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value))
        <div>

            <x-bread-crumb class="py-10 " :list="[
                [
                    'link' => null,
                    'name' => 'Recruitment',
                ],
                [
                    'link' => route('recruitment.jobs'),
                    'name' => 'Job',
                ],
                [
                    'link' => null,
                    'name' => $job_title,
                ],
            ]" />
            <div>
                <x-filament::section>
                    <x-slot name="heading">
                        {{ $this->job_title . '- APPLICANT' }}
                    </x-slot>
                    <ul class="py-2">
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
                                class="{{ $activeTab === 'checkfile' ? 'border' : '' }}" :active="$activeTab === 'checkfile'" :disabled="$activeTab === 'checkfile'"
                                x-on:click="changeTab('checkfile')">
                                <span class="whitespace-nowrap">Check Requirements</span>
                                <x-slot name="badge" class="bg-red-500">
                                    {{ $checkFileCount }}
                                </x-slot>
                            </x-filament::tabs.item>


                            <x-filament::tabs.item id="validator" icon="heroicon-o-magnifying-glass-circle"
                                class="{{ $activeTab === 'validator' ? 'border' : '' }}" :active="$activeTab === 'validator'" :disabled="$activeTab === 'validator'"
                                x-on:click="changeTab('validator')">
                                Validator
                                <x-slot name="badge" color="danger">
                                    {{ $validatorCount }}
                                </x-slot>
                            </x-filament::tabs.item>


                            <x-filament::tabs.item id="qualified" icon="heroicon-o-shield-check"
                                class="{{ $activeTab === 'qualified' ? 'border' : '' }}" :active="$activeTab === 'qualified'" :disabled="$activeTab === 'qualified'"
                                x-on:click="changeTab('qualified')">
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


                    </ul>

                    <div class="w-full " wire:loading wire:loading.delay.longest wire:target="changeTab">
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
           @else
                <div class=" mx-auto w-fit">
                    @include('components.restrict')
                </div>
            @endif
        </div>
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
