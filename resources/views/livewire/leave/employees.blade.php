<x-assets.admin_layout target="store,_finishUpload">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>

    <div x-data="{ tabOpen: @entangle('tab') }">

        <!-- Breadcrumb -->
        <x-bread-crumb class="py-10" :list="[
            [
                'link' => null,
                'name' => 'Leave',
            ],
            [
                'link' => route('leave.employees'),
                'name' => 'Employees',
            ],
        ]" />
        <x-filament::tabs label="Content tabs" class="w-fit mb-2 dark:text-gray-400">
            <x-filament::tabs.item alpine-active="tabOpen === 'EMPLOYEES'" icon="heroicon-m-users"
                wire:click="$set('tab', 'EMPLOYEES')">
                Employees
            </x-filament::tabs.item>

            <x-filament::tabs.item alpine-active="tabOpen === 'BULK-CTO'" icon="heroicon-m-rectangle-group"
                wire:click="$set('tab', 'BULK-CTO')">
                <span class="whitespace-nowrap">Bulk Cto</span>
            </x-filament::tabs.item>
            <x-filament::tabs.item alpine-active="tabOpen === 'BULK-DTR'" icon="heroicon-m-calendar-days"
                wire:click="$set('tab', 'BULK-DTR')">
                <span class="whitespace-nowrap">Bulk DTR</span>
            </x-filament::tabs.item>

        </x-filament::tabs>
        <main>
            <div x-show="tabOpen == 'EMPLOYEES'">
                {{ $this->table }}

            </div>
            <div x-show="tabOpen == 'BULK-CTO'">
                <livewire:leave.bulk-cto />
            </div>
            <div x-show="tabOpen == 'BULK-DTR'" class="z-50">
                <livewire:leave.bulk-dtr class="z-50" /> 
       
            </div>
        </main>

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
