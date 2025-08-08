
<x-assets.admin_layout target="save">
    <x-slot name="modal">
        <div x-cloak class="z-50">
            <x-filament-actions::modals class="z-50" />
        </div>
    </x-slot>
    <div  >
  <!-- Breadcrumb -->
  <x-bread-crumb class="py-10" :list="[
    [
        'link'=>null,
        'name'=>'Leave'
    ]
    ,[
        'link'=>null,
        'name'=>'RD/ARD'
    ]]"/>
    <x-filament::section>
        <form wire:submit="save">
            {{ $this->form }}

            <x-filament::button type="submit" color="success" class="w-full mt-5">
                Update
            </x-filament::button>
        </form>

        <x-filament-actions::modals />
    </x-filament::section>



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
