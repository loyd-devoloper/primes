
<x-assets.admin_layout target="store">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <div class=" z-10  grid grid-cols-1 lg:grid-cols-5 gap-6  mb-4"  >
        <x-filament::section class="h-fit  col-span-2  bg-white shadow">
            <x-slot name="heading">
                User details
            </x-slot>

            <div class="flex items-center flex-col xl:flex-row  gap-1 ">
                <img src="{{ !!Auth::user()->profile ? asset('storage/' . Auth::user()->profile) : asset('assets/no_image.jpg') }}"
                     class="min-w-[7rem] max-w-[7rem] min-h-[7rem] max-h-[7rem] rounded-full border-2 border-black"
                     alt="">
                {{-- employee information content --}}
                <div>
                    <h2 class=" font-semibold text-xl dark:text-white">{{ Auth::user()->name }}</h2>
                    <p class="text-gray-500 flex items-end gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>

                        {{ Auth::user()->email }}
                    </p>
                    <p class="text-gray-500 flex items-end gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>

                        Division/Unit : {{ $fd_code?->user_fd_code?->division_name }}
                    </p>
                    <p class="text-gray-500 flex items-end gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>


                        {{ $this->birthDate }}
                    </p>
                </div>
            </div>
        </x-filament::section>

        <x-filament::section class="h-fit col-span-3  bg-white shadow">
            <x-slot name="heading">
                <div class="flex justify-between items-center ">
                    Completed in PDS

                </div>
            </x-slot>

            @if (Auth::user()->fd_code == '01D' || Auth::user()->fd_code == '08C')
                <x-filament::button wire:click="generate" tooltip="Generate Reports" class="float-right !mr-2 !mt-2" outlined>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </x-filament::button>
            @endif
            @livewire(\App\Livewire\Dashboard\CompletePdsBar::class)





            {{-- {{ $this->form }} --}}
{{--            <x-filament::modal id="edit-user" width="7xl" :close-button="true">--}}
{{--                <x-slot name="heading">--}}
{{--                    <div class="flex items-center gap-2">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
{{--                             stroke="currentColor" class="size-8 text-yellow-500">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                  d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />--}}
{{--                        </svg>--}}
{{--                        Announcement--}}
{{--                    </div>--}}
{{--                </x-slot>--}}

{{--                --}}{{-- Modal content goes here --}}
{{--                <div class="max-h-[80svh] overflow-y-auto dark:text-white">--}}
{{--                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit deleniti perferendis soluta quam libero--}}
{{--                    nisi sapiente! Deleniti consectetur voluptas--}}
{{--                </div>--}}
{{--            </x-filament::modal>--}}



        </x-filament::section>
    </div>







    @if ($task)
    <x-filament::section class="col-span-2">
                            <x-slot name="heading">
            {{ $task->name }}
        </x-slot>

        <div wire:sortable-group="updateTaskOrder" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
            @foreach ($groups as $group)
                <div wire:key="group-{{ $group->id }}" wire:sortable.item="{{ $group->id }}"
                    class="flex-1 bg-gray-50 ring-1 ring-black dark:bg-bgDark p-4 h-fit rounded-lg shadow-2xl">

                    <h2 wire:sortable.handle class="text-xl font-semibold mb-4 " style="color: {{ $group->color }}">
                        {{ $group->label }} <span>({{ count($group?->tasks) }})</span></h2>
                    <div wire:sortable-group.item-group="{{ $group->id }}" id="todo-list"
                        class="min-h-[200px] space-y-2">
                        @foreach ($group->tasks as $task)
                            <main class="relative group " wire:key="task-{{ $task->id }}"
                                wire:sortable-group.item="{{ $task->id }}">
                                <x-filament::section style="border-color: {{ $group->color }}"
                                    class="bg-white dark:bg-bgDarkLight dark:text-white  rounded-md border-l-[.3rem] ">


                                        <x-slot name="heading"  >
                                           <span class="cursor-move " wire:sortable-group.handle> {{ $task->title }}</span>

                                        </x-slot>
                                    <article class="text-sm px-3 text-gray-600 taskCardImage line-clamp-2 prose leading-none">
                                        {!! str($task->description)->sanitizeHtml() !!}
                                    </article>
                                    <div class="flex flex-wrap gap-2 mt-2 prose">
                                        @foreach (json_decode($task->tags) as $tag)
                                            <x-filament::badge size="sm" class="fill-red-500 p-2 ">
                                                {{ $tag }}
                                            </x-filament::badge>
                                        @endforeach

                                    </div>
                                </x-filament::section>
                                <div
                                    class="absolute  gap-2 top-4 right-2 hidden transition-all ease-in-out group-hover:flex">
                                    {{ ($this->slideOverViewTaskAction)(['id' => $task->id, 'title' => $task->title]) }}

                                </div>
                            </main>
                        @endforeach
                    </div>
                </div>
            @endforeach



        </div>
    </x-filament::section>
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
