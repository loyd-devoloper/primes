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


<div>

    {{-- Main container --}}
    <main class="flex dark:bg-bgDark min-h-[100svh]" x-data="skillDisplay">
        {{-- aside --}}
        <span x-cloak :class="aside ? 'hidden xl:block' : 'block xl:block'" class="relative  z-30" x-transition>
            @include('components.assets.admin_aside')
        </span>
        {{-- Aside end --}}
        {{-- main content --}}
        <section class="w-full    z-10">
            <div class="bg-gradient-to-r from-[#0061ff] to-[#60efff] fixed -z-10 top-0 left-0  w-full min-h-[35svh]">
            </div>

            {{-- top nav --}}
            @include('components.assets.topNav')
            <div wire:loading wire:target='callMountedTableAction'>
                <div class="fixed top-0 h-[100svh] bg-black/60 left-0 w-full z-[99]  flex justify-center items-center">
                    <div class="loader" class="mx-auto"></div>
                </div>
            </div>
            <div class=" overflow-x-auto  overflow-y-auto max-h-[80svh] px-2 sm:px-5 xl:px-10"
                :class='aside ? " xl:max-w-[calc(100svw-270px)]" : "max-w-[calc(100svw)]"'>

                {{-- children container  --}}
                <div class="mt-6">

                    <x-filament::section>
                        <x-slot name="heading">
                            Jobs
                        </x-slot>
                        <div class="grid gap-3">
                            @forelse ($jobs as $job)
                                <div class=" bg-gray-100/50 dark:bg-bgDark dark:text-white px-4 py-2">
                                    <div
                                        class="flex items-center justify-between gap-3 text-sm font-semibold  rounded-md">
                                        <div class="flex items-center gap-3 ">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="min-w-8 max-w-8 h-8 fill-[#FFCB23] text-yellow-600">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                            </svg>
                                            {{ $job->job_title }}
                                        </div>
                                        <a href="{{ route('recruitment.application.table', ['job_title' => urldecode($job->job_title), 'id' => $job->job_id]) }}"
                                            class="bg-gray-800 text-white text-xs px-4 py-2 rounded-2xl hover:bg-green-500">Open</a>
                                    </div>
                                    <div class="w-fit flex gap-2 items-center">
                                        <x-filament::badge>
                                            {{ $job->check_file_count }}
                                        </x-filament::badge>
                                        <x-filament::badge color="warning">
                                            {{ $job->validator_count }}
                                        </x-filament::badge>
                                        <x-filament::badge color="success">
                                            {{ $job->qualified_count }}
                                        </x-filament::badge>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        {{-- Content --}}
                    </x-filament::section>

                </div>
            </div>
            {{-- <x-filament-actions::modals /> --}}
        </section>
        {{-- main content end --}}
    </main>

</div>
@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,

        }));
    </script>
@endscript
