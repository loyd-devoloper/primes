<div class="!z-[999]">

    <x-assets.admin_layout target="deselectAllTableRecords,unmountFormComponentAction,deleteComment,tab">
        <x-slot name="modal">
            <div x-cloak class="z-50">
                <x-filament-actions::modals class="z-50" />

            </div>
        </x-slot>
        <div x-data="leaveData(@js($leaves), @js($leaveCto))" class="!z-[999]">


            <!-- Breadcrumb -->
            <x-bread-crumb class="py-10" :list="[
                [
                    'link' => route('leave.employees'),
                    'name' => 'Leave',
                ],
                [
                    'link' => route('leave.employees'),
                    'name' => 'Employees',
                ],
                [
                    'link' => null,
                    'name' => $employeeInfo?->name,
                ],
            ]" />


            <div class="grid mb-10 ">

                <x-filament::section>


                    <div class="grid grid-cols-1 md:grid-cols-2 items-start  ">
                        <div>
                            <div class="flex items-center flex-col xl:flex-row  gap-1 ">
                                <img src="{{ !!$employeeInfo?->profile ? asset('storage/' . $employeeInfo?->profile) : asset('assets/no_image.jpg') }}"
                                    class="min-w-[10rem] max-w-[10rem] min-h-[10rem] max-h-[10rem]  rounded-full border-2 border-black "
                                    alt="">

                                <div>
                                    <h2 class=" font-semibold text-2xl dark:text-white pl-1 ">
                                        {{ $employeeInfo?->name }}
                                    </h2>
                                    <p class="text-gray-500 flex items-end gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>

                                        {{ $employeeInfo?->email }}
                                    </p>
                                    <p class="text-gray-500 flex items-end gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                        </svg>

                                        Division/Unit : {{ Auth::user()?->user_fd_code?->division_name }}
                                    </p>

                                </div>
                            </div>

                        </div>
                        {{-- <div class="grid grid-cols-5 justify-center items-center col-span-3">
                            <div id="sl" class="!p-0 m-0"></div>
                            <div id="vl" class="!p-0 m-0"></div>
                            <div id="fl" class="!p-0 m-0"></div>
                            <div id="spl" class="!p-0 m-0"></div>
                            <div id="cto" class="!p-0 m-0"></div>
                        </div> --}}

                        @if ($leaves?->status)
                            <div id="chart" wire:ignore>
                            </div>
                        @endif
                    </div>


                    {{-- Content --}}
                </x-filament::section>

            </div>

            <div class="bg-white dark:bg-bgDarkLight" x-data="{ tabOpen: @entangle('tab') }">


                <div class="border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">

                        <li class="me-2">
                            <a type="button" wire:click="changeTab('LEAVE-REQUEST')"
                                class="cursor-pointer transition-all inline-flex items-center justify-center p-4 {{ $tab == 'LEAVE-REQUEST' ? 'text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500' : 'border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} group"
                                aria-current="page">
                                <svg class="w-4 h-4 me-2 {{ $tab == 'LEAVE-REQUEST' ? 'text-blue-600 dark:text-blue-500' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                                </svg>
                                Leave Request
                            </a>
                        </li>
                        <li class="me-2">
                            <a type="button" wire:click="changeTab('UPDATE-LEAVE')"
                                class="cursor-pointer transition-all inline-flex items-center justify-center p-4  rounded-t-lg {{ $tab == 'UPDATE-LEAVE' ? 'text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500' : 'border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}  group">

                                <svg class=" me-2 size-6 {{ $tab == 'UPDATE-LEAVE' ? 'text-blue-600 dark:text-blue-500' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                </svg>
                                Update Leave
                            </a>
                        </li>
                        <li class="me-2">
                            <a type="button" wire:click="changeTab('LEAVE-CARD')"
                                class="cursor-pointer transition-all inline-flex items-center justify-center p-4 {{ $tab == 'LEAVE-CARD' ? 'text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500' : 'border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} group">
                                <svg class="w-4 h-4 me-2 {{ $tab == 'LEAVE-CARD' ? 'text-blue-600 dark:text-blue-500' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 20">
                                    <path
                                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                </svg>
                                Leave Card
                            </a>
                        </li>
                        <li class="me-2">
                            <a type="button" wire:click="changeTab('ACTIVITY-LOG')"
                                class="cursor-pointer transition-all inline-flex items-center justify-center p-4 {{ $tab == 'ACTIVITY-LOG' ? 'text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500' : 'border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} group">
                                <svg class="w-4 h-4 me-2 {{ $tab == 'ACTIVITY-LOG' ? 'text-blue-600 dark:text-blue-500' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 20">
                                    <path
                                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                </svg>
                                Activity Log
                            </a>
                        </li>

                    </ul>
                </div>
                {{-- loading --}}
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


                <div x-show="tabOpen == 'LEAVE-REQUEST'" wire:loading.remove wire:target="changeTab">
                    {{ $this->table }}
                </div>


                <div x-show="tabOpen == 'UPDATE-LEAVE'" wire:loading.remove wire:target="changeTab">

                    <div class="grid grid-cols-1 lg:grid-cols-7  p-6 text-sm break-words ">
                        <div class="bg-white shadow-md col-span-2 rounded-lg p-6 mb-6">
                            <h2 class="text-2xl font-semibold mb-4">Leave Points Management</h2>
                            {{ $this->slideOverNewLeaveAction }}
                            {{ $this->modalFormSyncAction }}
                            {{-- @if ($employeeInfo?->leavePointLatest?->sync)
                                <x-filament::button disabled="true" wire:click="sync" class="!cursor-not-allowed" icon="heroicon-m-arrow-path">
                                    Sync
                                </x-filament::button>
                            @else
                                <x-filament::button  wire:click="sync" icon="heroicon-m-arrow-path">
                                    Sync
                                </x-filament::button>
                            @endif --}}


                            {{-- <div class="bg-green-100 p-4 rounded-lg mb-4">
                                <h3 class="text-lg font-medium">Sick Leave (SL)</h3>
                                <p class="text-gray-700">Current Points: <span
                                        id="current-sl">{{ $leaves?->sl }}</span></p>
                                <input type="number" id="update-sl" placeholder="Update Points"
                                       wire:model.live="sl" class="border border-gray-300 rounded p-2 mb-2 w-full">


                                {{ ($this->modalFormAddAction)(['label' => 'sl', 'fullLabel' => 'Sick Leave']) }}
                                {{ ($this->modalFormMinusAction)(['label' => 'sl', 'fullLabel' => 'Sick Leave']) }}
                            </div>
                            <div class="bg-blue-100 p-4 rounded-lg mb-4">
                                <h3 class="text-lg font-medium">Vacation Leave (VL)</h3>
                                <p class="text-gray-700">Current Points: <span
                                        id="current-vl">{{ $leaves?->vl }}</span></p>
                                <input type="number" id="update-vl" placeholder="Update Points"
                                       class="border border-gray-300 rounded p-2 mb-2 w-full" wire:model.live="vl">
                                {{ ($this->modalFormAddAction)(['label' => 'vl', 'fullLabel' => 'Vacation Leave']) }}
                                {{ ($this->modalFormMinusAction)(['label' => 'vl', 'fullLabel' => 'Vacation Leave']) }}
                            </div>

                            <div class="bg-orange-100 p-4 rounded-lg mb-4">
                                <h3 class="text-lg font-medium">Force Leave (FL)</h3>
                                <p class="text-gray-700">Current Points: <span
                                        id="current-fl">{{ $leaves?->fl }}</span></p>
                                <input type="number" id="update-fl" max="5" placeholder="Update Points"
                                       class="border border-gray-300 rounded p-2 mb-2 w-full" wire:model.live="fl">
                                {{ ($this->modalFormAddAction)(['label' => 'fl', 'fullLabel' => 'Force Leave']) }}
                                {{ ($this->modalFormMinusAction)(['label' => 'fl', 'fullLabel' => 'Force Leave']) }}
                            </div>
                            <div class="bg-orange-100 p-4 rounded-lg mb-4">
                                <h3 class="text-lg font-medium">Special Privilege Leave(SPL)</h3>
                                <p class="text-gray-700">Current Points: <span
                                        id="current-fl">{{ $leaves?->spl }}</span></p>
                                <input type="number" id="update-fl" placeholder="Update Points"
                                       class="border border-gray-300 rounded p-2 mb-2 w-full" wire:model.live="spl">
                                {{ ($this->modalFormAddAction)(['label' => 'spl', 'fullLabel' => 'Special Privilege Leave']) }}
                                {{ ($this->modalFormMinusAction)(['label' => 'spl', 'fullLabel' => 'Special Privilege Leave']) }}
                            </div> --}}
                        </div>
                        <div class="col-span-5">
                            <div class="px-5">
                                {{ $this->slideOverCtoAction }}
                            </div>
                            <div class="px-4 py-5 ">
                                <livewire:leave.personnel.update-leave employee_name="{{ $employeeName }}"
                                    employee_id="{{ $employee_id }}" />
                            </div>


                        </div>
                    </div>
                </div>


                <div x-show="tabOpen == 'LEAVE-CARD'" class="p-10" wire:loading.remove wire:target="changeTab">
                    <div class="flex justify-end py-2">
                        {{--                        {{ $this->slideOverLeaveCardAction }} --}}
                        <x-filament-actions::group :actions="[$this->slideOverLeaveCardAction, $this->slideOverLeaveCardCtoAction]" button label="Download Leave Card"
                            icon="heroicon-m-arrow-down-tray" color="danger" size="sm"
                            tooltip="More actions" />
                    </div>
                    <livewire:leave.personnel.leave-card :employeeid="$employee_id" :name="$employeeName" />
                </div>

                <div x-show="tabOpen == 'ACTIVITY-LOG'" class="!max-h-[40svh] !overflow-y-auto" wire:loading.remove
                    wire:target="changeTab">

                    <livewire:leave.personnel.employee-logs :activities="$employeeInfo?->leaveActivityLogs" />

                </div>

            </div>


        </div>


    </x-assets.admin_layout>

</div>

@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,

            apexChart: null,
            leaves: [],
            circleChart(id, min, max, value) {
                const maxValue = max;
                const minValue = min;
                const valueToPercent = (val) => ((val - minValue) * 100) / (maxValue - minValue);


                var optionsCircle = {
                    max: 1,
                    chart: {
                        height: 240,
                        type: 'radialBar',

                    },
                    series: [valueToPercent(
                        value)], // Use a number instead of a string for the series value
                    labels: ['Sick Leave'],

                    plotOptions: {

                        radialBar: {

                            // range: [0, 10] ,
                            dataLabels: {
                                name: {
                                    show: true,
                                    fontSize: '13px',
                                    fontWeight: 'bold',
                                    color: '#000',
                                },
                                value: {
                                    show: true,
                                    formatter: (val) => (val * (maxValue - minValue)) / 100 + minValue,
                                    fontSize: '16px',
                                    color: '#000',
                                },
                            },
                        },
                    },
                };

                // Create and render the chart
                var chart = new ApexCharts(document.querySelector("#" + id), optionsCircle);
                chart.render();
            },
            init() {


                // this.leaves = this.leavePoints;
                // const sl = this.leavePoints?.sl;
                // const vl = this.leavePoints?.vl;
                // const fl = this.leavePoints?.fl;
                // const spl = this.leavePoints?.spl;
                // const cto = this.leavePoints?.cto ?? 0;
                // var options = {
                //     series: [{
                //         name: 'points',
                //         data: [sl, vl, fl, spl, cto]
                //     }],
                //     chart: {
                //         height: 200,
                //         // width: 500,
                //         type: 'bar',
                //     },
                //     plotOptions: {
                //         bar: {
                //             borderRadius: 10,
                //             dataLabels: {
                //                 position: 'top',
                //             },
                //             columnWidth: '50%',
                //         }
                //     },
                //     dataLabels: {
                //         enabled: true,
                //         formatter: function(val) {
                //             return val;
                //         },
                //         offsetY: -20,
                //         style: {
                //             fontSize: '12px',
                //             colors: ["#304758"]
                //         }
                //     },

                //     xaxis: {
                //         categories: [`Sick Leave(${sl})`, `Vacation Leave(${vl})`, `Force Leave(${fl})`,
                //             `SPL(${spl})`,
                //             `CTO(${cto})`
                //         ],
                //         position: 'bottom',
                //         axisBorder: {
                //             show: false
                //         },
                //         axisTicks: {
                //             show: false
                //         },
                //         crosshairs: {
                //             fill: {
                //                 type: 'gradient',
                //                 gradient: {
                //                     colorFrom: '#D8E3F0',
                //                     colorTo: '#BED1E6',
                //                     stops: [0, 100],
                //                     opacityFrom: 0.4,
                //                     opacityTo: 0.5,
                //                 }
                //             }
                //         },
                //         tooltip: {
                //             enabled: true,
                //         }
                //     },
                //     yaxis: {
                //         axisBorder: {
                //             show: false
                //         },
                //         axisTicks: {
                //             show: false,
                //         },
                //         labels: {
                //             show: false,
                //             formatter: function(val) {
                //                 return val;
                //             }
                //         }

                //     },

                // };
                // var chart = new ApexCharts(document.querySelector("#chart"), options);
                // chart.render();
                // this.circleChart('sl', 0, 50, sl);
                // this.circleChart('vl', 0, 50, vl);
                // this.circleChart('fl', 0, 50, fl);
                // this.circleChart('spl', 0, 50, spl);
                // this.circleChart('cto', 0, 50, cto);

                this.$watch('leaves', (val) => console.log(val))
            }
        }));
        Alpine.data('leaveData', (leavePoints, ctoLeave) => ({
            aside: true,
            leavePoints: leavePoints,
            ctoLeave: ctoLeave,
            apexChart: null,
            leaves: [],
            circleChart(id, min, max, value) {
                const maxValue = max;
                const minValue = min;
                const valueToPercent = (val) => ((val - minValue) * 100) / (maxValue - minValue);


                var optionsCircle = {
                    max: 1,
                    chart: {
                        height: 240,
                        type: 'radialBar',

                    },
                    series: [valueToPercent(
                        value)], // Use a number instead of a string for the series value
                    labels: ['Sick Leave'],

                    plotOptions: {

                        radialBar: {

                            // range: [0, 10] ,
                            dataLabels: {
                                name: {
                                    show: true,
                                    fontSize: '13px',
                                    fontWeight: 'bold',
                                    color: '#000',
                                },
                                value: {
                                    show: true,
                                    formatter: (val) => (val * (maxValue - minValue)) / 100 + minValue,
                                    fontSize: '16px',
                                    color: '#000',
                                },
                            },
                        },
                    },
                };

                // Create and render the chart
                var chart = new ApexCharts(document.querySelector("#" + id), optionsCircle);
                chart.render();
            },
            barChart() {
                var y = this.leavePoints;
                this.leaves = y;
                const sl = y?.sl;
                const vl = y?.vl;
                const fl = y?.fl;
                const spl = y?.spl;
                const cto = this.ctoLeave ?? 0;
                var options = {
                    series: [{
                        name: 'points',
                        data: [sl, vl, fl, spl, cto]
                    }],
                    chart: {
                        height: 350,
                        // width: 500,
                        type: 'bar',
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 10,
                            dataLabels: {
                                position: 'top',
                            },
                            columnWidth: '50%',
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return val;
                        },
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: ["#304758"]
                        }
                    },

                    xaxis: {
                        categories: [`Sick Leave(${sl})`, `Vacation Leave(${vl})`, `Force Leave(${fl})`,
                            `SPL(${spl})`,
                            `CTO(${cto})`
                        ],
                        position: 'bottom',
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        crosshairs: {
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    colorFrom: '#D8E3F0',
                                    colorTo: '#BED1E6',
                                    stops: [0, 100],
                                    opacityFrom: 0.4,
                                    opacityTo: 0.5,
                                }
                            }
                        },
                        tooltip: {
                            enabled: true,
                        }
                    },
                    yaxis: {
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false,
                        },
                        labels: {
                            show: false,
                            formatter: function(val) {
                                return val;
                            }
                        }

                    },

                };
                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            },
            init() {


                // this.circleChart('sl', 0, 50, sl);
                // this.circleChart('vl', 0, 50, vl);
                // this.circleChart('fl', 0, 50, fl);
                // this.circleChart('spl', 0, 50, spl);
                // this.circleChart('cto', 0, 50, cto);
                this.barChart()

            }
        }));
    </script>
@endscript
