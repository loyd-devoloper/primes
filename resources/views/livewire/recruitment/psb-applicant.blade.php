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
<x-assets.admin_layout target="callMountedTableAction,unmountFormComponentAction">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <div >


    <x-bread-crumb class="py-10 " :list="[
            [
                'link' => null,
                'name' => 'Recruitment',
            ],
            [
                'link' => route('recruitment.psb'),
                'name' => 'PSB',
            ],
            [
                'link' => null,
                'name' => $job_title,
            ],
        ]" />
    <div  >

        <x-filament::section>
            <x-slot name="heading">
                {{ $this->job_title . '- APPLICANT' }}
            </x-slot>
            <ul class="py-2">
                <x-filament::tabs label="Content tabs">


                    <x-filament::tabs.item  id="validator" icon="heroicon-o-numbered-list"
                        class="border" >
                        ALL APPLICANT
                        <x-slot name="badge" color="danger">
                            {{ $validatorCount }}
                        </x-slot>
                    </x-filament::tabs.item>

                </x-filament::tabs>


            </ul>

            <div class="w-full " wire:loading wire:loading.delay.longest wire:target="changeTab">
                <x-filament::loading-indicator class="size-14 mx-auto mt-10" />
            </div>

            <button x-ref="clickMe" class="hidden" x-on:click="$wire.$refresh()">clicke</button>

            <div wire:loading.remove wire:target="changeTab">
                {{ $this->table }}

            </div>
            {{-- Content --}}
        </x-filament::section>

    </div>

</div>
</x-assets.admin_layout>

@script

    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            clickMe: null,
            async changeTab($value) {
                await $wire.changeTab($value);
                $wire.$refresh()
            }
        }));

    </script>
@endscript
