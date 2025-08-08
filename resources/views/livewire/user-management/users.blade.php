<x-assets.admin_layout target="store">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <div>
        @if (Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::USER_MANAGEMENT->value))
            <!-- Breadcrumb -->
            <x-bread-crumb class="py-10" :list="[
                [
                    'link' => null,
                    'name' => 'User Management',
                ],
                [
                    'link' => route('user_management.permission'),
                    'name' => 'Permission',
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
            apexChart: null,
            init() {


            }
        }));
    </script>
@endscript
