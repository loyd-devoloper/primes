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
    <main class="flex" x-data="skillDisplay">
        {{-- aside --}}
        <span x-cloak :class="aside ? 'hidden xl:block' : 'block xl:block'" class="relative  z-30" x-transition>
            @include('components.assets.admin_aside')
        </span>
        {{-- Aside end --}}
        {{-- main content --}}
        <section class="w-full   ">
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
                    <div class="grid grid-cols-3 gap-2">
                       <div class="col-span-1">
                        <x-filament::section>
                            <x-slot name="heading">
                               Basic Information
                            </x-slot>

                            <div class="space-y-1">
                                <p>Fullname: <strong >Johnloyd</strong></p>
                            <p>Email: <strong>Johnloyd@gmail.com</strong></p>
                            <p>Mobile Number: <strong>09101421233</strong></p>
                            <p>Address: <strong>dsad sadasdasd</strong></p>
                            </div>
                        </x-filament::section>

                       </div>

                       <div class="col-span-2">
                        <x-filament::section>
                            <x-slot name="heading">
                                Applicant Documets
                            </x-slot>


                        </x-filament::section>

                       </div>
                    </div>

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
