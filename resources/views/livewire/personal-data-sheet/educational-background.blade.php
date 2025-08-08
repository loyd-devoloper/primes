@assets
<x-assets.admin_layout target="callMountedTableAction">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <div >


        {{--children container  --}}
        <div>
            <x-bread-crumb class="py-10" :list="[
                [
                    'link' => null,
                    'name' => 'Personal Data Sheet',
                ],
                [
                    'link' => null,
                    'name' => 'Educational Background',
                ],
            ]" />
            {{ $this->table }}
        {{-- </x-filament::section> --}}
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
