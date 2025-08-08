@assets
<style>

    .trSplit > div{
        width: 100%;
    }
    .trSplit > div > .max-w-max{
        min-width: 100%;

    }
    .trSplit > div > .max-w-max > div{
        min-width: 100%;

    }
    .trSplit > div > .max-w-max > div > span{
        min-width: 100%;
        display: flex;
        justify-content: space-around
    }
    .fi-table-header-cell-i-n-c-l-u-s-i-v-e-d-a-t-e-s > span > span
    {

        min-width: 100%;
    }

</style>
@endassets
<x-assets.admin_layout target="callMountedTableAction">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <div >

        <x-bread-crumb class="py-10" :list="[
            [
                'link' => null,
                'name' => 'Personal Data Sheet',
            ],
            [
                'link' => null,
                'name' => 'Learning and Development',
            ],
        ]" />
        <div >

            {{ $this->table }}

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
