<div>
    <x-assets.admin_layout target="store">
        <x-slot name="modal">
            <div x-cloak class="z-50">
                <x-filament-actions::modals class="z-50" />
            </div>
        </x-slot>
        <form wire:submit.prevent="store"
           >

            <div class="w-full overflow-y-auto ">
                <x-bread-crumb class="py-10" :list="[
                    [
                        'link' => null,
                        'name' => 'Personal Data Sheet',
                    ],
                    [
                        'link' => null,
                        'name' => 'Personal Information',
                    ],
                ]" />
                <div class="p-4 bg-white dark:bg-bgDarkLight rounded-md">
                    <h2 class="pb-6 font-bold dark:text-white">Personal Information</h2>
                    <h1 class="flex gap-2 items-center bg-yellow-300  p-4 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="min-w-6 min-h-6 max-w-6 max-h-6 text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        <div class="text-sm xl:text-base">
                            All <span class="text-red-500 font-bold">required</span> field must not be blank.
                            Please enter <span class="font-bold">'N/A'</span> if not applicable.

                        </div>
                    </h1>
                    <div class="py-4 px-2">
                        {{ $this->form }}
                    </div>
                    <button type="submit"
                        class="flex justify-center items-center gap-2  py-2 px-4 bg-gradient-to-r from-[#22c1c3] to-[#66bf95] text-white hover:from-[#66bf95]
                        hover:to-[#22c1c3] rounded">Save</button>
                </div>

            </div>
        </form>
    </x-assets.admin_layout>
</div>
@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,

        }));
    </script>
@endscript
