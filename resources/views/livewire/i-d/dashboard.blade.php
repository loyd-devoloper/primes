<x-assets.admin_layout target="callMountedTableAction">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <div>







        @if (Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::GENERATING_ID->value))
            <!-- Breadcrumb -->
            <x-bread-crumb class="py-10" :list="[
                [
                    'link' => null,
                    'name' => 'Generating ID',
                ],
            ]" />

            {{ $this->table }}
        @else
            <div class=" mx-auto w-fit">
                @include('components.restrict')
            </div>
        @endif


    </div>
</x-assets.admin_layout>


@script
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            init() {


            }
        }));
    </script>
@endscript
