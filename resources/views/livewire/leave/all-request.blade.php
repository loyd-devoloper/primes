<x-assets.admin_layout target="store">
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
        'link'=>route('leave.employees'),
        'name'=>'All Request'
    ]]"/>
            {{ $this->table }}
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
