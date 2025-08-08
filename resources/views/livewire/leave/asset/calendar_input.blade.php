<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" x-data="calendarInput">


    <x-filament::input.wrapper>

        <x-filament::input type="text" class="datex border-red-500" wire:model.live="{{ $getStatePath() }}" />
        @error('date')
            {{ $message }}
        @enderror

    </x-filament::input.wrapper>
</x-dynamic-component>


@script
    <script>
        Alpine.data('calendarInput', () => ({
            dateArr: null,
            disabledDate: $wire.$entangle('disabledDate'),
            disabledArr: [],
            token: $wire.$entangle('x'),
            state: $wire.$entangle('{{ $getStatePath() }}'),
            resetInput() {

                const disableArray = [
                    function(date) {
                        return (date.getDay() === 6 || date.getDay() === 0);
                    }
                ];

                const newArr = this.disabledDate.map((val) => {
                    return val.start;
                });

                disableArray.push(...newArr);

                flatpickr('.datex', {
                    mode: "multiple",
                    dateFormat: "Y-m-d",
                    minDate: this.token,
                    showMonths: 2,
                    disable:disableArray,
                    defaultDate: this.state,
                });

            },
            init() {

                this.resetInput();
                this.$watch('dateArr', async (val) => await console.log($wire.$entangle('x')))
                this.$watch('token', (val) => this.resetInput())

            }
        }));
    </script>
@endscript
