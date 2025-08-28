<div>
    <main x-data="dtrx">

        <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $getFieldWrapperView()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field' => $field]); ?>
            <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <?php if (isset($component)) { $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.index','data' => ['type' => 'file','wire:model.live' => 'file','required' => true,'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'file','wire:model.live' => 'file','required' => true,'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e)): ?>
<?php $attributes = $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e; ?>
<?php unset($__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e)): ?>
<?php $component = $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e; ?>
<?php unset($__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $attributes = $__attributesOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__attributesOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $component = $__componentOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__componentOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>

        <div class=" space-y-6 py-10 text-xs dark:text-white" x-show="Object.keys(disabledDate).length > 0">
            <template x-for="(employee,index) in disabledDate" :key="index">

                <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['collapsible' => true,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['collapsible' => true,'size' => 'sm']); ?>

                     <?php $__env->slot('heading', null, []); ?> 

                        <span x-text="index"></span>
                     <?php $__env->endSlot(); ?>
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
                    
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>

            </template>


        </div>

    </main>

</div>

    <?php
        $__scriptKey = '265890056-0';
        ob_start();
    ?>
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
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/livewire/leave/asset/dtr.blade.php ENDPATH**/ ?>