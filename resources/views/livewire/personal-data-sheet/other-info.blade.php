<x-assets.admin_layout target="store">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <form wire:submit='store' >
        <div>
            <x-bread-crumb class="py-10" :list="[
                [
                    'link' => null,
                    'name' => 'Personal Data Sheet',
                ],
                [
                    'link' => null,
                    'name' => 'Other Info',
                ],
            ]" />
            {{ $this->form }}
        </div>


    </form>
</x-assets.admin_layout>

@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,

        }));
    </script>
@endscript
