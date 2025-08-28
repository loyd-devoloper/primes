<div>
    <main x-data="dtrx">

        <x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
            <x-filament::input.wrapper>
                <x-filament::input type="file" wire:model.live="file" required
                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
            </x-filament::input.wrapper>
        </x-dynamic-component>

        <div class=" space-y-6 py-10 text-xs dark:text-white" x-show="Object.keys(disabledDate).length > 0">
            <template x-for="(employee,index) in disabledDate" :key="index">

                <x-filament::section collapsible size="sm">

                    <x-slot name="heading">

                        <span x-text="index"></span>
                    </x-slot>
                    <div>
                        <table>
                            <tr>
                                <td class="border px-2.5 text-center" rowspan="2">Days</td>
                                <td class="border px-2.5 text-center" colspan="2">A.M.</td>
                                <td class="border px-2.5 text-center" colspan="2">P.M.</td>
                                <td class="border px-2.5 text-center" colspan="2">UNDERTIME</td>
                            </tr>
                            <tr>
                                <td class="border px-2.5 text-center">Arrival</td>
                                <td class="border px-2.5 text-center">Departure</td>
                                <td class="border px-2.5 text-center">Arrival</td>
                                <td class="border px-2.5 text-center">Departure</td>
                                <td class="border px-2.5 text-center">Hours</td>
                                <td class="border px-2.5 text-center">Minutes</td>
                            </tr>
                            <template x-for="(date,index) in employee.data" :key="index">
                                <tr>
                                    <td class="border px-2.5 font-bold text-center" x-text="index.split('-')[1]"
                                        :class="{
                                            'bg-gray-500': date.fc,
                                        }">
                                    </td>
                                    <td class=" px-2.5 text-center border"
                                        :class="{

                                            'text-red-500': date.type === 'Absent',
                                            'font-bold': date.type === 'Absent' || typeof(
                                                    date
                                                ) === 'string' ? true :
                                                false // This will ensure 'font-bold' is applied if type is 'Absent'
                                        }"
                                        :colspan="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ?
                                            6 : 1"
                                        x-text="convertDate(date)"></td>
                                    <td class="border px-2.5 text-center"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ?
                                            'hidden' : ''"
                                        x-text="formatTime(date.date_departure_am.time)"></td>
                                    <td class="border px-2.5 text-center"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ?
                                            'hidden' : ''"
                                        x-text="formatTime(date.date_arrival_pm.time)">
                                    </td>
                                    <td class="border px-2.5 text-center"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ?
                                            'hidden' : ''"
                                        x-text="formatTime(date.date_departure_pm.time)"></td>
                                    <td class="border px-2.5 text-center"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ?
                                            'hidden' : ''"
                                        x-text="convertUndertime('h',date)">

                                    </td>
                                    <td class="border px-2.5 text-center"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ?
                                            'hidden' : ''"
                                        x-text="convertUndertime('m',date)">

                                    </td>
                                    <td class="whitespace-nowrap"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ?
                                            'hidden' : ''"
                                        x-text="decrease(date)"></td>
                                </tr>
                            </template>
                            <div>
                                <p x-text="month" class="font-bold"></p>

                                <p class="font-bold">L / UT = <span x-text="totalPerEmployee(employee)"></span></p>
                                <p class="font-bold">L / UT = <span x-text="totalPerEmployeeMin(employee)"></span></p>

                            </div>
                        </table>
                    </div>
                    {{-- Content --}}
                </x-filament::section>

            </template>


        </div>

    </main>

</div>

@script
    <script>
        Alpine.data('dtrx', () => ({
            // disabledDate: $wire.{{ $applyStateBindingModifiers("\$entangle('dtrArr')"),
            disabledDate: $wire.$entangle('dtrArr'),
            month: $wire.$entangle('month'),
            total: 0,
            convertUndertime(type, date) {
                if (date.type != 'Absent' && typeof(date) !== 'string') {
                    const hours = Math.floor(date.undertime / 60); // Calculate hours
                    const minutes = date.undertime % 60; // Calculate remaining minutes

                    if (type == 'm') {
                        return minutes > 0 ? minutes : '';
                    } else {
                        return hours > 0 ? hours : '';
                    }

                }

                return '';
            },
               formatTime(time) {
                if (!time) return '';
                // Convert 24h to 12h format
                const [hours, minutes] = time.split(':');
                const h = parseInt(hours);
                const ampm = h >= 12 ? 'PM' : 'AM';
                const formattedHours = h % 12 || 12;
                return `${formattedHours}:${minutes} ${ampm}`;

        },
            decrease(date) {

                // if (date.type == 'UT') {
                //     // this.total += parseInt(date.undertime)

                //     return 'UT = ' + date.undertime;
                // }

                if (date.late > 0) {
                    // this.total += parseInt(date.late)

                    return 'L = ' + date.late;
                }

            },
            totalPerEmployee(employee) {
                var x = 0;

                Object.entries(employee.data).forEach(([key, value]) => {
                    if (typeof(value) !== 'string') {

                        x += parseInt(value.undertime)

                        x += parseInt(value.late)
                    }
                    // if (value.type == 'UT') {
                    //     x += parseInt(value.undertime)


                    // }
                    // if (value.late > 0 && value.type == 'Full') {
                    //     x += parseInt(value.late)


                    // }
                });
                const hours = Math.floor(x / 60);
                const minutes = x % 60;
                return `${hours} hours and ${minutes} minutes`;
            },
            totalPerEmployeeMin(employee) {
                var x = 0;

                Object.entries(employee.data).forEach(([key, value]) => {
                    if (typeof(value) !== 'string') {

                        x += parseInt(value.undertime)

                        x += parseInt(value.late)
                    }

                });

                return `${x} minutes`;
            },
            convertDate(date) {
                if (typeof(date) === 'string') {
                    return date;
                } else if (date.type == 'Absent') {
                    return date.type;
                } else {
                    return this.formatTime(date.date_arrival_am.time);
                }

            },
            init() {
                this.$watch('disabledDate', (val) => {
                    Object.values(val).forEach(newVal => {

                        Object.values(newVal.data).forEach(element => {

                            if (element.type == 'UT') {
                                this.total += parseInt(element.undertime)
                            }
                             if (element.type == 'L/UT') {
                                this.total += parseInt(element.undertime)
                            }
                            if (element.late > 0 && element.type == 'Full') {
                                this.total += parseInt(element.late)
                            }
                        });
                    });

                })


            }
        }));
    </script>
@endscript
