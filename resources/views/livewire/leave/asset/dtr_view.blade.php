<div>
    <main x-data="dtrx">


        <div class="  text-xs dark:text-white grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-10"
             x-show="Object.keys(disabledDate).length > 0">

            @foreach($this->dtrArrView as $key => $value)
                <x-filament::section collapsible size="sm" class="h-fit">
                    <x-slot name="heading">
                        {{explode('--',$key)[1]}}
                    </x-slot>
                    {{ ($getAction('dtr'))([$key => $value]) }}
                    <div x-data="{model: @js($value)}">
                        {{$this->form}}
                    </div>

                    {{-- Content --}}
                    <div x-data="{employee: @js($value?->data)}">
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

                            @foreach($value->data as $dateKey => $date)

                                <tr x-data="{date: @js($date)}">
                                    <td class="border px-2.5 font-bold text-center"
                                        :class="{
                                                                'bg-gray-500': date.fc,
                                                            }">

                                        {{explode('-',$dateKey)[1]}}
                                    </td>
                                    <td class=" px-2.5 text-center border"
                                        :class="{

                                                                'text-red-500': date.type === 'Absent',
                                                                'font-bold': date.type === 'Absent' || typeof(
                                                                    date
                                                                ) === 'string' ? true : false // This will ensure 'font-bold' is applied if type is 'Absent'
                                                            }"
                                        :colspan="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 6 : 1"
                                        x-text="convertDate(date)"></td>
                                    <td class="border px-2.5 text-center"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                                        x-text="date.date_departure_am"></td>
                                    <td class="border px-2.5 text-center"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                                        x-text="date.date_arrival_pm">
                                    </td>
                                    <td class="border px-2.5 text-center"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                                        x-text="date.date_departure_pm"></td>
                                    <td class="border px-2.5 text-center"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                                        x-text="convertUndertime('h',date)">

                                    </td>
                                    <td class="border px-2.5 text-center"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                                        x-text="convertUndertime('m',date)">

                                    </td>
                                    <td class="whitespace-nowrap"
                                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                                        x-text="decrease(date)"></td>
                                </tr>
                            @endforeach
                            <div>
                                <p x-text="month" class="font-bold"></p>

                                <p class="font-bold">L / UT = <span x-text="totalPerEmployee(employee)"></span></p>
                                <p class="font-bold">L / UT = <span x-text="totalPerEmployeeMin(employee)"></span></p>

                            </div>
                        </table>
                    </div>


                </x-filament::section>
            @endforeach
        </div>

    </main>

</div>

@script
<script>
    Alpine.data('dtrx', () => ({
        {{--// disabledDate: $wire.{{ $applyStateBindingModifiers("\$entangle('dtrArr')"),--}}
        //            disabledDate:$wire.$entangle('dtrArrView'),
        disabledDate: @js(json_decode($getRecord()->dtr)),
        month: $wire.$entangle('month'),
        total: 0,
        convertUndertime(type, date) {
            if (date.type != 'Absent' && typeof (date) !== 'string') {
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
        decrease(date) {

            if (date.late > 0 && date.type == 'Full') {
                // this.total += parseInt(date.late)

                return 'L = ' + date.late;
            }

        },
        totalPerEmployee(employee) {
            var x = 0;
            console.log(employee)
            Object.entries(employee).forEach(([key, value]) => {
                if (typeof (value) !== 'string') {

                    x += parseInt(value.undertime)

                    x += parseInt(value.late)
                }

            });
            const hours = Math.floor(x / 60);
            const minutes = x % 60;
            return `${hours} hours and ${minutes} minutes`;
        },
        totalPerEmployeeMin(employee) {
            var x = 0;

            Object.entries(employee).forEach(([key, value]) => {
                if (typeof (value) !== 'string') {

                    x += parseInt(value.undertime)

                    x += parseInt(value.late)
                }

            });

            return `${x} minutes`;
        },
        convertDate(date) {
            if (typeof (date) === 'string') {
                return date;
            } else if (date.type == 'Absent') {
                return date.type;
            } else {
                return date.date_arrival_am;
            }

        },
        updateDtr(value, id) {
            $wire.updateDtr(value, id);
        },
        init() {

            this.$watch('disabledDate', (val) => {

                Object.values(val).forEach(element => {

                    if (element.type == 'UT') {
                        this.total += parseInt(element.undertime)
                    }
                    if (element.late > 0 && element.type == 'Full') {
                        this.total += parseInt(element.late)
                    }
                });
            })


        }
    }));
</script>
@endscript
