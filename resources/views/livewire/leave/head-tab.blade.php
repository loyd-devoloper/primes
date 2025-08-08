

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
        'link'=>null,
        'name'=>'Head'
    ]]"/>
            {{ $this->table }}
    </div>


</x-assets.admin_layout>

@script

    <script>
            function handleInput(input, nextInputId) {
        if (input.value.length >= 10) {
            const nextInput = document.getElementById(nextInputId);
            if (nextInput) {
                nextInput.focus();
            }
        }
    }
        Alpine.data('skillDisplay', () => ({
            aside: true,
            apexChart: null,
            init() {


            }
        }));
    </script>
@endscript
