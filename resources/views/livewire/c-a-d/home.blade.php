<div>

    {{-- Main container --}}
    <main class="flex" x-data="skillDisplay">
        {{-- aside --}}
        <span x-cloak :class="aside ? 'hidden xl:block' : 'block xl:block'" class="relative  z-40" x-transition>
            @include('components.assets.admin_aside')
        </span>
        {{-- Aside end --}}
        {{-- main content --}}
        <section class="w-full">
            <div class="bg-gradient-to-r from-[#0061ff] to-[#60efff] fixed -z-10 top-0 left-0  w-full min-h-[35svh]">
            </div>
            @include('components.assets.topNav')
            <div wire:loading wire:target='filter, getData'>
                <div  class="fixed top-0 h-[100svh] bg-black/60 left-0 w-full z-[99]  flex justify-center items-center" >
                    <div class="loader" class="mx-auto"></div>
                </div>
            </div>
            <div  class="  overflow-y-auto max-h-[80svh] px-2 sm:px-5 xl:px-10" :class='aside ? " xl:max-w-[calc(100svw-270px)]" : "max-w-[calc(100svw)]"'>






                    <div class=" flex justify-center max-h-[40rem] p-32" style="padding:10rem">
                      <div class="w-full lg:w-[70svw]">
                        @livewire(\App\Livewire\CAD\CadChart::class)
                      </div>
                       </div>



                    {{-- Content --}}

                {{-- bar chart section end --}}
            </div>
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
