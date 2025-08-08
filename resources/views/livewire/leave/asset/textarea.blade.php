<div x-data="textarea">

    <x-dynamic-component
        :component="$getFieldWrapperView()"
        :field="$field"
    >
        <div class="p-0" wire:ignore>
            <div class="flex items-end ">
                <span class="whitespace-nowrap dark:text-gray-400 mr-2">For disapproval due to</span>
                <input type="text" x-model.debounce.300ms="firstInput" maxlength="20" required
                       class="border-x-0 border-t-0 border-b border-gray-600 w-64 focus:outline-none pb-0  dark:bg-bgDarkLight dark:border-white dark:text-white">
            </div>
            <input type="text" x-ref="secondInput" x-model.debounce.300ms="secondInput" maxlength="30"
                   class="border-x-0 border-t-0 border-b w-full border-gray-600  focus:outline-none leading-none pb-0  dark:bg-bgDarkLight dark:border-white dark:text-white">
            <input type="text" x-ref="thirdInput" x-model.debounce.300ms="thirdInput" maxlength="30"
                   class="border-x-0 border-t-0 border-b  w-full border-gray-600  focus:outline-none leading-none pb-0 dark:bg-bgDarkLight dark:border-white dark:text-white">
        </div>
    </x-dynamic-component>


</div>
@script
    <script>
        Alpine.data('textarea', () => ({
            aside: true,
            apexChart: null,
            firstInput: '',
            secondInput: '',
            thirdInput: '',
            functionFirst(e) {
                if (e.target.value.length == 20) {
                    $wire.set('example', e.target.value)
                    this.$focus.focus(this.$refs.secondInput)
                }
            },
            functionSecond(e) {
                if (e.target.value.length == 30) {
                    this.$focus.focus(this.$refs.thirdInput)
                }
            },
            init() {
                var self = this;
                this.$watch('firstInput', (val) => {
                    $wire.set('remarks.line1', val);
                    if (val.length == 20) {

                        self.$focus.focus(this.$refs.secondInput)
                    }
                })
                this.$watch('secondInput', (val) => {
                    $wire.set('remarks.line2', val);
                    if (val.length == 30) {

                        self.$focus.focus(this.$refs.thirdInput)
                    }
                })
                this.$watch('thirdInput', (val) => {
                    $wire.set('remarks.line3', val);

                })

            }
        }));
    </script>
@endscript
