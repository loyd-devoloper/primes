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
<x-assets.admin_layout target="store">
    <x-slot name="modal">

    </x-slot>

    <div class=" overflow-x-auto  overflow-y-auto max-h-[80svh] px-2 sm:px-5 xl:px-10"
        :class='aside ? " xl:max-w-[calc(100svw-270px)]" : "max-w-[calc(100svw)]"'>

        {{-- children container  --}}
        <div class="mt-6">
            <x-filament::section>
                <x-filament::tabs>
                    <div class="flex justify-between flex-col sm:flex-row gap-4 w-full">
                        <div class="flex items-center">
                            {{-- <x-filament::tabs.item icon="heroicon-s-list-bullet" :active="$search === 'all'"
                                wire:click="$set('search', 'all')">
                                ALL
                            </x-filament::tabs.item> --}}

                            {{-- <x-filament::tabs.item icon="heroicon-s-shield-check" :active="$search === 'login_history'"
                                wire:click="$set('search', 'login_history')">
                                Login History
                            </x-filament::tabs.item> --}}

                        </div>

                        <x-filament::input.wrapper>
                            <x-filament::input type="date" wire:model.live="date" />
                        </x-filament::input.wrapper>
                    </div>

                </x-filament::tabs>
                <div class="p-10 ">

                    <ol class="relative border-s border-gray-200 dark:border-gray-700 ">
                        @forelse ($activities as $activity)
                        <li class="mb-10 ms-6">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                <x-filament::icon-button icon="heroicon-m-check-circle" class="!text-green-700"
                                    size="xs" />
                            </span>
                            <h3 class="mb-1 text-base font-semibold text-gray-900 dark:text-white">
                                {{ $activity?->activity }}</h3>

                            <time
                                class="block mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($activity?->created_at)->format('F d, Y h:i:s A') }}</time>


                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">Device: <span
                                    class="opacity-50">{{ $activity->device }}</span></p>
                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">Device Version: <span
                                    class="opacity-50">{{ $activity->device_version }}</span></p>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Device Type: <span
                                    class="opacity-50">{{ $activity->device_type }}</span></p>

                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Browser: <span
                                    class="opacity-50 ">{{ $activity->browser . ' V' . $activity?->browser_version }}</span>
                            </p>

                        </li>
                        @empty
                            <p>No Found!</p>
                        @endforelse


                    </ol>

                </div>

                {{--
                        <div class="  overflow-y-auto relative !important mt-10">
                            <table class="w-full ">
                                <thead class="  bg-white dark:bg-bgDarkLight dark:text-white">
                                    <tr class="">
                                        <th class="border py-3">Activity</th>

                                        <th class="border py-3">Device Information</th>
                                        <th class="border py-3">Time & Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $activity)
                                        <tr>
                                            <td class="border py-3 text-center text-gray-600 dark:text-white">{{ $activity->activity }}
                                            </td>

                                            <td class="border py-3 text-center dark:text-white">
                                                <p>Device Type: <span
                                                        class="opacity-50">{{ $activity->device_type }}</span></p>

                                                <p>Browser: <span
                                                        class="opacity-50 ">{{ $activity->browser . ' V' . $activity?->browser_version }}</span>
                                                </p>
                                            </td>
                                            <td class="border py-3 text-center text-gray-600 dark:text-white">
                                                {{ \Carbon\Carbon::parse($activity->created_at)->format('M d, Y h:m:s A') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="py-5">
                                {{ $activities->links() }}
                            </div>
                        </div> --}}
                {{-- Content --}}
            </x-filament::section>

        </div>
    </div>
</x-assets.admin_layout>


@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,

        }));
    </script>
@endscript
