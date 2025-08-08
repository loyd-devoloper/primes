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
        .attachment__caption{
            color:rgb(49, 49, 245);
            text-decoration: underline;
        }
    </style>
@endassets
<x-assets.admin_layout target="store">
    <x-slot name="modal">
        <x-filament-actions::modals class="z-50" />
    </x-slot>

    <div>
        <x-bread-crumb class="py-10" :list="[
            [
                'link' => null,
                'name' => 'Task Board',
            ],
            [
                'link' => null,
                'name' => 'Task',
            ],
        ]" />

        <x-filament::section>
            <x-slot name="heading">
                {{ $task_name }}
            </x-slot>
            <x-slot name="headerEnd">
                {{ $this->slideOverAddTaskAction }}

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
                                        {{ ($this->slideOverEditTaskAction)(['id' => $task->id]) }}
                                        {{ ($this->slideOverDeleteTaskAction)(['id' => $task->id]) }}
                                    </div>
                                </main>
                            @endforeach
                        </div>
                    </div>
                @endforeach



            </div>
            {{-- Content --}}
        </x-filament::section>

    </div>
</x-assets.admin_layout>


@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            init()
            {

            }
        }));
    </script>
@endscript
