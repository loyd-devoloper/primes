<x-assets.admin_layout target="store">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <div>
        <!-- Breadcrumb -->
        <x-bread-crumb class="py-10" :list="[
            [
                'link' => null,
                'name' => 'Leave',
            ],
            [
                'link' => route('leave.my_leave'),
                'name' => 'My Leave',
            ],
            [
                'link' => null,
                'name' => $title,
            ],
        ]" />

        @if ($leave)
            <main class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                {{-- Leave Information --}}
                <x-filament::section class="lg:col-span-3 h-fit">
                    <x-slot name="heading">
                        <div class="flex items-center gap-1">
                            <x-filament::icon icon="heroicon-m-paper-clip" class="size-5" /> Leave Information
                        </div>
                    </x-slot>
                    <main class="flex gap-20 text-sm">
                        <div class="space-y-3">
                            <h1 class="dark:text-white text-gray-500">Code</h1>
                            <h1 class="dark:text-white text-gray-500">Subject</h1>
                            <h1 class="dark:text-white text-gray-500">Type of Leave</h1>
                            <h1 class="dark:text-white text-gray-500">Type of process</h1>
                            <h1 class="dark:text-white text-gray-500">Date</h1>
                            <h1 class="dark:text-white text-gray-500">Paid days</h1>
                            <h1 class="dark:text-white text-gray-500">Not Paid days</h1>
                            <h1 class="dark:text-white text-gray-500">Status</h1>
                            <h1 class="dark:text-white text-gray-500">Attachment File(s)</h1>
                        </div>
                        <div class="space-y-3">
                            <h1 class="dark:text-white text-black font-medium">{{ $leave?->code }}</h1>
                            <h1 class="dark:text-white text-black font-medium">{{ $leave?->subject_title }}</h1>
                            <h1 class="dark:text-white text-black font-medium">{{ $leave?->type_of_leave }}</h1>
                            <h1 class="dark:text-white text-black font-medium">{{ $leave?->type_of_process }}</h1>
                            <h1 class="dark:text-white text-black font-medium">
                                {{ $this->convertDate(json_decode($leave?->date)) }}
                            </h1>
                            <h1 class="dark:text-white text-black font-medium">
                                {{ $leave?->paid_days }}
                            </h1>
                            <h1 class="dark:text-white text-black font-medium">
                                {{ $leave?->notpaid_days }}
                            </h1>
                            <h1 class="dark:text-white text-black font-medium">
                                @if ($leave?->status == 'APPROVED')
                                    <x-filament::badge class="w-fit" color="success">
                                        {{ $leave?->status }}
                                    </x-filament::badge>
                                @elseif ($leave?->status == 'DISAPPROVED')
                                    <x-filament::badge class="w-fit" color="danger">
                                        {{ $leave?->status }}
                                    </x-filament::badge>
                                @elseif ($leave?->status == 'PENDING')
                                    <x-filament::badge class="w-fit" color="warning">
                                        {{ $leave?->status }}
                                    </x-filament::badge>
                                @endif

                            </h1>
                            <div>
                                {{ $this->iconPreviewAction }}
                                {{ $this->iconButtonAction }}
                                @if (!!$leave?->signed_file && $leave->type_of_process == 'ELECTRONIC SIGNATURE')
                                    {{ $this->iconButtonSignedAction }}
                                @endif
                                @if (!!$leave?->signed_file && $leave->type_of_process == 'WET SIGNATURE')
                                    {{ $this->iconButtonSignedWetAction }}
                                @endif
                            </div>
                        </div>
                    </main>
                    {{-- Content --}}
                </x-filament::section>

                {{-- leave Logs --}}
                <x-filament::section class="lg:col-span-2">
                    <x-slot name="heading">
                        <div class="flex items-center gap-1">
                            <x-filament::icon icon="heroicon-o-clock" class="size-5" /> Leave Logs
                        </div>
                    </x-slot>

                    <div class="flex w-full items-center">
                        {{-- Head --}}
                        @if (
                            ($leave?->location == 'Chief' || $leave?->location == 'Rd' || $leave?->location == 'Records') &&
                                $leave?->head_status == 1)
                            <div class="flex w-fit items-center  dark:text-white  mr-1">
                                <span
                                    class="flex items-center justify-center w-6 h-6  bg-green-500 rounded-full  dark:bg-green-800 shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white  dark:text-green-300" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                    </svg>
                                </span>
                                Head
                            </div>
                            <div class="w-full h-1 border-b border-green-500 border-4"></div>
                        @elseif (
                            ($leave?->location == 'Chief' || $leave?->location == 'Rd' || $leave?->location == 'Records') &&
                                $leave?->head_status == 0)
                            <div class="flex w-fit items-center  dark:text-white  mr-1">
                                <span
                                    class="flex items-center justify-center w-6 h-6 bg-red-500 rounded-full   shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white  dark:text-green-300" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                    </svg>
                                </span>
                                Head
                            </div>
                            <div class="w-full h-1 border-b border-red-500 border-4"></div>
                        @elseif($leave?->head_status == 0 && $leave?->chief_status == 0 && $leave?->rd_status == 0)
                            <div class="flex w-fit items-center  dark:text-white  mr-1 animate-pulse">
                                <span
                                    class="flex items-center justify-center w-6 h-6 {{ $leave?->status == 'DISAPPROVED' ? 'bg-red-500 ' : ' bg-blue-500 dark:bg-blue-800' }} rounded-full   shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white  dark:text-green-300" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                    </svg>
                                </span>
                                Head
                            </div>
                            <div class="w-full h-1 border-b border-gray-200 border-4"></div>
                        @else
                            <div class="flex w-fit items-center  dark:text-white  mr-1 animate-pulse">
                                <span
                                    class="flex items-center justify-center w-6 h-6 {{ $leave?->status == 'DISAPPROVED' ? 'bg-red-500 ' : ' bg-blue-500 dark:bg-blue-800' }} rounded-full   shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white  dark:text-green-300" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                    </svg>
                                </span>
                                Head
                            </div>
                            <div class="w-full h-1 border-b border-gray-200 border-4"></div>
                        @endif
                        {{-- chief --}}
                        @if (($leave?->location == 'Records' || $leave?->location == 'Rd') && $leave?->chief_status == 1)
                            <div class="flex w-fit items-center text-green-500  mx-1 ">
                                <span
                                    class="flex items-center   justify-center w-6 h-6 bg-green-500 rounded-full  dark:bg-green-800  shrink-0">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white  " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                        <path
                                            d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </span>
                                Chief
                            </div>
                            <div class="w-full h-1 border-b border-green-500 border-4"></div>
                        @elseif (($leave?->location == 'Records' || $leave?->location == 'Rd') && $leave?->chief_status == 0)
                            <div class="flex w-fit items-center  text-red-500 mx-1 ">
                                <span
                                    class="flex items-center bg-red-500 justify-center w-6 h-6  rounded-full dark:bg-gray-700 shrink-0">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white  " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                        <path
                                            d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </span>
                                Chief
                            </div>
                            <div class="w-full h-1 border-b border-red-500 border-4"></div>
                        @elseif ($leave?->location == 'Chief')
                            <div class="flex w-fit items-center  text-gray-500 mx-1">
                                <span
                                    class="flex items-center  justify-center w-6 h-6  rounded-full bg-blue-500 dark:bg-blue-800 shrink-0 animate-pulse">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                        <path
                                            d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </span>
                                Chief
                            </div>
                            <div class="w-full h-1 border-b border-gray-200 border-4"></div>
                        @else
                            <div class="flex w-fit items-center  text-gray-500 mx-1">
                                <span
                                    class="flex items-center  justify-center w-6 h-6  rounded-full bg-gray-500 dark:bg-gray-800 shrink-0 ">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                        <path
                                            d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </span>
                                Chief
                            </div>
                            <div class="w-full h-1 border-b border-gray-200 border-4"></div>
                        @endif

                        {{-- RD --}}
                        @if (($leave?->location == 'Chief' || $leave?->location == 'Rd') && $leave?->rd_status == 1)
                            <div class="flex w-fit items-center  text-green-500 mx-1 ">
                                <span
                                    class="flex items-center bg-green-500 justify-center w-6 h-6  rounded-full dark:bg-gray-700 shrink-0">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white  " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path
                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                    </svg>
                                </span>
                                RD/ARD
                            </div>
                        @elseif($leave?->location == 'Rd')
                            <div class="flex w-fit items-center  text-blue-500 mx-1 animate-pulse">
                                <span
                                    class="flex items-center bg-blue-500 justify-center w-6 h-6  rounded-full dark:bg-gray-700 shrink-0">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white  " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path
                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                    </svg>
                                </span>
                                RD/ARD
                            </div>
                        @elseif ($leave?->location == 'Records')
                            <div class="flex w-fit items-center   text-green-500 mx-1 ">
                                <span
                                    class="flex items-center bg-green-500 justify-center w-6 h-6  rounded-full dark:bg-green-700 shrink-0">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white  " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path
                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                    </svg>
                                </span>
                                RD/ARD
                            </div>
                        @else
                            <div class="flex w-fit items-center  dark:text-white  dark:after:border-green-800 mx-1">
                                <span
                                    class="flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full dark:bg-gray-700 shrink-0">
                                    <svg class="w-4 h-4 text-gray-500 lg:w-5 lg:h-5 dark:text-gray-100"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        viewBox="0 0 18 20">
                                        <path
                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                    </svg>
                                </span>
                                RD/ARD
                            </div>
                        @endif


                    </div>


                    {{-- activity log --}}
                    <main class="py-10 px-5 space-y-4">
                        <hr>
                        <ol class="relative border-s border-gray-400 dark:border-gray-700 ">
                            @foreach ($leavelogs as $log)
                                @if (!$loop->first)
                                    <li class="mb-10 ms-4">
                                        <div
                                            class="absolute w-3 h-3 bg-green-400 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-green-700">
                                        </div>
                                        <h3 class="text-sm font-semibold text-black dark:text-white">
                                            {{ $log?->activity }}</h3>
                                        <time
                                            class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($log?->created_at)->format('F d, Y h:i:s A') }}</time>

                                        <div class="flex items-center text-xs dark:text-gray-200">
                                            <x-filament::icon-button icon="heroicon-s-map-pin" label="Location"
                                                color="danger" />
                                            {{ $log?->location }}
                                        </div>
                                        @if (!!$log?->remarks)
                                            <div
                                                class="rounded py-1 px-1 mt-2 text-xs font-bold border border-black w-fit dark:text-gray-200 dark:border-gray-300">
                                                Remarks: {!! $log?->remarks !!}
                                            </div>
                                        @endif



                                    </li>
                                @else
                                    <li class="mb-10 ms-4">
                                        <div
                                            class="absolute w-3 h-3 bg-blue-500 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">

                                        </div>
                                        <h3 class="text-sm font-semibold text-black dark:text-white">
                                            {{ $log?->activity }}</h3>
                                        <time
                                            class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($log?->created_at)->format('F d, Y h:i:s A') }}</time>

                                        <div class="flex items-center text-xs dark:text-gray-200">
                                            <x-filament::icon-button icon="heroicon-s-map-pin" label="Location"
                                                color="danger" />
                                            {{ $log?->location }}
                                        </div>
                                        @if (!!$log?->remarks)
                                            <div
                                                class="rounded py-1 px-1 mt-2 text-xs font-bold border border-black w-fit dark:text-gray-200 dark:border-gray-300">
                                                Remarks: {!! $log?->remarks !!}
                                            </div>
                                        @endif



                                    </li>
                                @endif
                            @endforeach



                        </ol>
                    </main>
                    {{-- Content --}}
                </x-filament::section>
            </main>
        @else
            <div class="w-full flex justify-center items-center p-10">
                <div class="text-center">
                    <h1 class="text-6xl font-bold text-gray-800 mb-4 dark:text-white">
                        404
                    </h1>
                    <p class="text-2xl text-gray-600 mb-8 dark:text-gray-300">
                        Oops! The page you're looking for doesn't exist.
                    </p>

                </div>
            </div>
        @endif

    </div>


</x-assets.admin_layout>

@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            apexChart: null,
            init() {


            }
        }));
    </script>
@endscript
