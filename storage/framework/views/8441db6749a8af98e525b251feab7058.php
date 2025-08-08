<?php if (isset($component)) { $__componentOriginalb6c54c1805cbceaf226d77ef80a67c61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb6c54c1805cbceaf226d77ef80a67c61 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.assets.admin_layout','data' => ['target' => 'callMountedTableAction']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('assets.admin_layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['target' => 'callMountedTableAction']); ?>
     <?php $__env->slot('modal', null, []); ?> 
        <div x-cloak class="z-50">
            
        </div>
     <?php $__env->endSlot(); ?>
    <div>


        <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
             <?php $__env->slot('heading', null, []); ?> 
                User details
             <?php $__env->endSlot(); ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(\App\Livewire\CAD\CadChart::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2820276930-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            
            <main class="text-sm">
                <div class="grid gap-10">
                    <div class="flex justify-between">
                        <article>
                            <h1>Gender</h1>
                            <div class="pl-5">
                                <li>Male</li>
                                <li>Female</li>
                            </div>
                        </article>
                        <div id="chart" wire:ignore></div>
                    </div>
                    <div class="flex justify-between">
                        <article>
                            <h1>Civil Status</h1>
                            <div class="pl-5">
                                <li>Single</li>
                                <li>Widdowed</li>
                                <li>Married</li>
                                <li>Seperated</li>
                                <li>Solo Patent</li>
                            </div>
                        </article>
                        <div id="civilStatuschart" wire:ignore></div>
                    </div>

                    <div class="flex justify-between">
                        <article>
                            <h1>Status appointment</h1>
                            <div class="pl-5">
                                <li>Permanent</li>
                                <li>Contractual</li>
                                <li>Job Order</li>
                                <li>Casual</li>
                                <li>Contract of service</li>
                                <li>Temporary</li>
                            </div>
                        </article>
                        <div id="statusAppointmentStatuschart" wire:ignore></div>
                    </div>
                    <div class="flex justify-between">
                        <article>
                            <h1>Age</h1>
                            <div class="pl-5">
                                <li>Permanent</li>
                                <li>Contractual</li>
                                <li>Job Order</li>
                                <li>Casual</li>
                                <li>Contract of service</li>
                                <li>Temporary</li>
                            </div>
                        </article>
                        <div id="ageStatuschart" wire:ignore></div>
                    </div>
                </div>
            </main>
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


    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb6c54c1805cbceaf226d77ef80a67c61)): ?>
<?php $attributes = $__attributesOriginalb6c54c1805cbceaf226d77ef80a67c61; ?>
<?php unset($__attributesOriginalb6c54c1805cbceaf226d77ef80a67c61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb6c54c1805cbceaf226d77ef80a67c61)): ?>
<?php $component = $__componentOriginalb6c54c1805cbceaf226d77ef80a67c61; ?>
<?php unset($__componentOriginalb6c54c1805cbceaf226d77ef80a67c61); ?>
<?php endif; ?>


    <?php
        $__scriptKey = '2820276930-0';
        ob_start();
    ?>
<script>
    Alpine.data('skillDisplay', () => ({
        aside: true,
        option(value, labels,type = 1) {
            let newLabel = [];
            newLabel = labels;
            if(type == 1)
            {


                var data = [];
                var label = [];
                Object.keys(value).map(function (key){

                    // data.push(value[key]);
                    // label.push(key);
                    newLabel[key] = value[key];
                });
                Object.keys(newLabel).map(function (key){
                    data.push(newLabel[key]);
                    label.push(key);
                })
            }else if(type == 2)
            {
                var data = [];
                var label = [];
                var i = 0;

                var result = Object.keys(value).map((key) => value[key]);




                Object.keys(newLabel).map(function (keylabel){
                        const main = keylabel.split('to');
                        const first = parseInt(main[0]);
                        const second = parseInt(main[1]);
                        console.log(result)
                    const grouped = result.reduce((acc, num) => {


                        // If the number is not already a key in the accumulator, initialize it
                        if (!acc[num]) {
                            acc[num] = 0;
                        }
                        // Increment the count for this number
                        acc[num]++;
                        return acc;
                    }, {});
                    // const filter = result.filter((val) =>{
                    //
                    //     return val > first && val < second ? val : 0;
                    // })
                    // data.push(filter[0] == undefined ? 0 : filter[0])
                    label.push(keylabel);

                })

                // console.log(data)

            }
            // console.log(result)
            const options = {
                series: [{
                    name: 'total',
                    data: data,
                }],
                chart: {
                    // height: 200,
                    width: 500,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'center', // top, center, bottom
                        },
                    }
                },
                // dataLabels: {
                //     enabled: true,
                //     formatter: function(val) {
                //         return val;
                //     },
                //     offsetY: -20,
                //     style: {
                //         fontSize: '12px',
                //         colors: ["#304758"]
                //     }
                // },

                xaxis: {
                    categories: label,
                    position: 'bottom',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function (val) {
                            return val;
                        }
                    }

                },

            };

            return options;
        },
        init() {


            setTimeout(() => {
                const sexLabel = {Male: 0, Female: 0};
                var chart = new ApexCharts(document.querySelector("#chart"), this.option( <?php echo \Illuminate\Support\Js::from($genderCounts)->toHtml() ?>, sexLabel));
                chart.render();

                const civilStatuschartLabel = {Single: 0, Widowed: 0, Married: 0, Seperated:0, 'Solo Parent': 0};
                var civilStatuschart = new ApexCharts(document.querySelector("#civilStatuschart"), this.option(<?php echo \Illuminate\Support\Js::from($civil_status)->toHtml() ?>, civilStatuschartLabel));
                civilStatuschart.render();

                const appointmentchartLabel = {Permanent: 0, Contractual: 0, 'Job Order': 0, Casual: 0,'Contract of Service': 0, 'Temporary' : 0};
                var statusAppointmentStatuschart = new ApexCharts(document.querySelector("#statusAppointmentStatuschart"), this.option(<?php echo \Illuminate\Support\Js::from($status_appointment)->toHtml() ?>, appointmentchartLabel));
                statusAppointmentStatuschart.render();



                const agechartLabel = {'20 to 30 years old': 0, '30 to 40 years old': 0, '40 to 50 years old': 0, '50 to 60 years old': 0,'60 to 70 years old': 0, '70 to 80 years old' : 0};
                var ageStatuschart = new ApexCharts(document.querySelector("#ageStatuschart"), this.option(<?php echo \Illuminate\Support\Js::from($allBirthData)->toHtml() ?>, agechartLabel,2));
                ageStatuschart.render();
            }, 500);

        }
    }));
</script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/livewire/c-a-d/home.blade.php ENDPATH**/ ?>