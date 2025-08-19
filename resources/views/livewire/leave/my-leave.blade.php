@assets
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endassets
<div>
    <x-assets.admin_layout target="skillDisplay">
        <x-slot name="modal">
            <div x-cloak class="z-50">
                <x-filament-actions::modals class="z-50" />
            </div>
        </x-slot>


        <x-slot name="slot">


            <!-- Breadcrumb -->
            <x-bread-crumb class="py-10" :list="[
                [
                    'link' => route('leave.employees'),
                    'name' => 'Leave',
                ],
                [
                    'link' => route('leave.employees'),
                    'name' => 'My Leave',
                ],
            ]" />



            <div class="grid mb-10 ">
                <x-filament::section>

                    <div class="grid grid-cols-1 md:grid-cols-2 items-start ">
                        <div>
                            <div class="flex items-center flex-col xl:flex-row  gap-1 ">
                                <img src="{{ !!$employeeInfo?->profile ? asset('storage/' . $employeeInfo?->profile) : asset('assets/no_image.jpg') }}"
                                    class="min-w-[10rem] max-w-[10rem] min-h-[10rem] max-h-[10rem]  rounded-full border-2 border-black"
                                    alt="">

                                <div>
                                    <h2 class=" font-semibold text-2xl dark:text-white pl-1 ">{{ $employeeInfo?->name }}
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
                                    <div class="py-3">

                                        {{ $this->slideOverAction }}
                                        {{ $this->slideOverLeaveCardAction }}
                                        {{ $this->slideOverEsignAction }}
                                        {{ $this->slideOverDtr }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if (!!$leaves)

                            <div>
                                   @if (\Carbon\Carbon::now()->format('F Y') !== $leaves->current_month)
                                <div class="bg-orange-200 px-6 py-4 my-4 rounded-md text-xs flex items-center mx-auto ">
                                    <svg viewBox="0 0 24 24" class="text-yellow-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                                        <path fill="currentColor"
                                            d="M23.119,20,13.772,2.15h0a2,2,0,0,0-3.543,0L.881,20a2,2,0,0,0,1.772,2.928H21.347A2,2,0,0,0,23.119,20ZM11,8.423a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Zm1.05,11.51h-.028a1.528,1.528,0,0,1-1.522-1.47,1.476,1.476,0,0,1,1.448-1.53h.028A1.527,1.527,0,0,1,13.5,18.4,1.475,1.475,0,0,1,12.05,19.933Z">
                                        </path>
                                    </svg>
                                    <span class="text-yellow-800 font-bold text-xs">
                                        Your leave point is not yet final. It can still be reduced. This is not
                                        real-time
                                        because our system is still being developed.
                                    </span>
                                </div>


                                     <div class="bg-red-200 px-6 py-4 my-4 rounded-md text-xs flex items-center mx-auto ">
                                    <svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                                        <path fill="currentColor"
                                            d="M23.119,20,13.772,2.15h0a2,2,0,0,0-3.543,0L.881,20a2,2,0,0,0,1.772,2.928H21.347A2,2,0,0,0,23.119,20ZM11,8.423a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Zm1.05,11.51h-.028a1.528,1.528,0,0,1-1.522-1.47,1.476,1.476,0,0,1,1.448-1.53h.028A1.527,1.527,0,0,1,13.5,18.4,1.475,1.475,0,0,1,12.05,19.933Z">
                                        </path>
                                    </svg>
                                    <span class="text-red-800 font-medium text-xs">
                                      Your leave points aren’t fully updated yet—as of now, I’ve only recorded up to <strong>{{ $leaves->current_month}}</strong> (the latest should be <strong>{{ \Carbon\Carbon::now()->format('F Y')}}</strong>).
                                    </span>
                                </div>
                                @endif

                                <div id="chart" wire:ignore>
                                </div>
                            </div>
                        @endif
                    </div>





                    {{-- Content --}}
                </x-filament::section>

            </div>
            <div >
                {{ $this->table }}
                {{-- <livewire:leave.old-request wire:ignore /> --}}
                {{-- @include('livewire.leave.asset.previewForm6') --}}
            </div>


            <x-filament::modal id="edit-user" width="2xl" :close-button="true">
                <x-slot name="heading">
                    <div class="flex items-center gap-2 text-lg">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8 text-yellow-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>

                        <p>Warning</p>
                    </div>
                </x-slot>

                {{-- Modal content goes here --}}
                <div class="max-h-[80svh] overflow-y-auto dark:text-white">
                    <h1 class="text-2xl font-bold">MAY {{ $leaves?->fl }} FORCE LEAVE KAPA. GAMITIN MUNA PO. </h1>
                    <img src="{{ asset('assets/sad.jpg') }}" alt="">
                </div>
            </x-filament::modal>
        </x-slot>



    </x-assets.admin_layout>
</div>

@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            apexChart: null,
            ctos: @entangle('leaveCto'),
            init() {
                const leavePoints = @js($leaves);
                this.leaves = leavePoints;
                const sl = leavePoints?.sl;
                const vl = leavePoints?.vl;
                const fl = leavePoints?.fl;
                const spl = leavePoints?.spl;
                const cto = this.ctos ?? 0;
                var options = {
                    series: [{
                        name: 'points',
                        data: [sl, vl, fl, spl, cto]
                    }],
                    chart: {
                        height: 350,
                        type: 'bar',
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 10,
                            dataLabels: {
                                position: 'top', // top, center, bottom
                            },
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
                        position: 'top',
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
                if (fl > 0) {
                    setTimeout(() => {

                        // $dispatch('open-modal', {
                        //     id: 'edit-user'
                        // })
                    }, 200);
                }
                setTimeout(() => {
                    var chart = new ApexCharts(document.querySelector("#chart"), options);

                    chart.render();
                }, 500);
            }
        }));
    </script>
@endscript
