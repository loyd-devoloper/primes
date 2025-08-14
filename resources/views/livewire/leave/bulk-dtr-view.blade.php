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
                'link' => route('leave.employees',['tab'=>'BULK-DTR']),
                'name' => 'Employees',
            ],
             [
                'link' => null,
                'name' => 'Employee Dtr',
            ],
        ]" />

        <main>

                {{ $this->table }}

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
