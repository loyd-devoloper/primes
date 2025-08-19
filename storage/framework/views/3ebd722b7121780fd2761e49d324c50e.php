    <?php
        $__assetKey = '618109592-0';

        ob_start();
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="<?php echo e(asset('canva.js')); ?>"></script>
    <?php
        $__output = ob_get_clean();

        // If the asset has already been loaded anywhere during this request, skip it...
        if (in_array($__assetKey, \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$alreadyRunAssetKeys)) {
            // Skip it...
        } else {
            \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$alreadyRunAssetKeys[] = $__assetKey;
            \Livewire\store($this)->push('assets', $__output, $__assetKey);
        }
    ?>
<div>

    <main x-data="skillDisplay">
        
        <section class="grid grid-cols-3">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $dtrData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dtr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>

                    <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['icon' => 'heroicon-m-printer','label' => 'Print','color' => 'secondary','type' => 'button','xOn:click' => 'generateMe('.e($key).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-m-printer','label' => 'Print','color' => 'secondary','type' => 'button','x-on:click' => 'generateMe('.e($key).')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $attributes = $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $component = $__componentOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
                    
                    <div x-data="{ model: <?php echo \Illuminate\Support\Js::from($dtrData)->toHtml() ?> }" class="max-w-[15rem] px-1 mb-2">
                        <?php echo e($this->form); ?>

                    </div>
                    <div :id="'table' + <?php echo e($key); ?>"
                        class="block w-fit  overflow-x-auto   mx-auto text-xs relative ">


                        <div class=" ">
                            
                            <img src="<?php echo e(asset('/assets/dtr_image.png')); ?>" class="max-w-[29rem] " alt="">
                            <p class="py-2 "><i>Civil Service Form No. 48</i></p>
                            <p class="text-center leading-none pt-4 pb-1 font-bold text-lg">DAILY TIME RECORD</p>
                            <p class="text-center ">-----o0o-----</p>
                            <p class="border-b border-black text-center font-bold mt-4">
                                <?php echo e(explode('--', $dtr['user_name'])[1]); ?></p>
                            <h6 class="text-center text-xs">(Name)</h6>
                            <div class="grid grid-cols-5 pt-5">
                                <div class="col-span-2 px-3">
                                    <p class="text-center">For the month of</p>
                                    <p class="text-center py-1">Official hours</p>
                                    <p class="text-center">for arrival and departure</p>
                                </div>
                                <div class="col-span-3">
                                    <p class="border-b border-black text-center font-bold uppercase">
                                        <?php echo e(\Carbon\Carbon::parse($dtr['date'])->format('F Y')); ?>

                                    </p>
                                    <div class="grid grid-cols-2 py-1">
                                        <p class="text-center">Regular days</p>
                                        <div class="border-b border-black"></div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <p class="text-center">Saturdays</p>
                                        <div class="border-b border-black"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div x-data="{ employee: <?php echo \Illuminate\Support\Js::from($dtr)->toHtml() ?> }" class=" max-w-[29rem]  h-full pt-10">
                                <table class="border-collapse w-full ">
                                    <tr class="">
                                        <td class="border border-black border-solid px-2.5 text-center" rowspan="2">
                                            Days</td>
                                        <td class="border-y border-r border-black border-solid px-2.5 text-center"
                                            colspan="2">
                                            A.M.</td>
                                        <td class="border-y border-r border-black border-solid px-2.5 text-center"
                                            colspan="2">
                                            P.M.</td>
                                        <td class="border-y border-r border-black border-solid px-2.5 text-center"
                                            colspan="2">
                                            UNDERTIME</td>
                                    </tr>
                                    <tr class="">
                                        <td class="border-b border-r border-black border-solid px-2.5 text-center">
                                            Arrival</td>
                                        <td class="border-b border-r border-black border-solid px-2.5 text-center">
                                            Departure
                                        </td>
                                        <td class="border-b border-r border-black border-solid px-2.5 text-center">
                                            Arrival</td>
                                        <td class="border-b border-r border-black border-solid px-2.5 text-center">
                                            Departure
                                        </td>
                                        <td class="border-b border-r border-black border-solid px-2.5 text-center">Hours
                                        </td>
                                        <td class="border-b border-r border-black border-solid px-2.5 text-center">
                                            Minutes</td>
                                    </tr>

                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = json_decode($dtr['dtr'], true)['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateKey => $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr x-data="{ date: <?php echo \Illuminate\Support\Js::from($date)->toHtml() ?> }">
                                            <td
                                                class="border-l border-b border-black border-solid px-2.5 py-1  font-bold text-center whitespace-nowrap">
                                                <?php echo e(explode('-', $dateKey)[1]); ?>

                                            </td>


                                            <!--[if BLOCK]><![endif]--><?php if(!empty($date['editable'])): ?>
                                                <!--[if BLOCK]><![endif]--><?php if(!!$date['date_arrival_am']): ?>
                                                    <td class="border-l border-b border-black border-solid px-2.5 py-1 text-center whitespace-nowrap"
                                                        :class="{
                                                            'font-bold border-r': shouldHighlightCell(date)
                                                        }"
                                                        :colspan="getCellColspan(date)" x-text="convertDate(date)">
                                                    </td>
                                                <?php else: ?>
                                                    <!-- Editable Mode -->
                                                    <td
                                                        class="border-l border-b border-black border-solid px-2.5 py-1 text-center whitespace-nowrap">
                                                        <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['class' => 'text-2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-2xl']); ?>
                                                            <?php if (isset($component)) { $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.index','data' => ['type' => 'text','wire:model' => 'name','class' => '!text-2xl !important']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','wire:model' => 'name','class' => '!text-2xl !important']); ?>
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
                                                    </td>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php else: ?>
                                                <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                                    :class="{
                                                        'font-bold border-r': date.type === 'Absent' || typeof(
                                                            date
                                                        ) === 'string' ? true : false
                                                    }"
                                                    :colspan="typeof(date) === 'string' || date.type == 'travel' ? 6 : 1"
                                                    x-text="convertDate(date)"></td>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



                                            <!--[if BLOCK]><![endif]--><?php if(!empty($date['editable'])): ?>
                                                <!--[if BLOCK]><![endif]--><?php if(!!$date['date_departure_am']): ?>
                                                      <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                                :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                                x-text="date.date_departure_am"></td>
                                                <?php else: ?>
                                                    <!-- Editable Mode -->
                                                    <td
                                                        class="border-l border-b border-black border-solid px-2.5 py-1 text-center whitespace-nowrap">
                                                        <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['class' => 'text-2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-2xl']); ?>
                                                            <?php if (isset($component)) { $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.index','data' => ['type' => 'text','wire:model' => 'name','class' => '!text-2xl !important']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','wire:model' => 'name','class' => '!text-2xl !important']); ?>
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
                                                    </td>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php else: ?>
                                                  <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                                :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                                x-text="date.date_departure_am"></td>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]--><?php if(!empty($date['editable'])): ?>
                                                <!--[if BLOCK]><![endif]--><?php if(!!$date['date_arrival_pm']): ?>
                                                     <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                                :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                                x-text="date.date_arrival_pm">
                                            </td>
                                                <?php else: ?>
                                                    <!-- Editable Mode -->
                                                    <td
                                                        class="border-l border-b border-black border-solid px-2.5 py-1 text-center whitespace-nowrap">
                                                        <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['class' => 'text-2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-2xl']); ?>
                                                            <?php if (isset($component)) { $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.index','data' => ['type' => 'text','wire:model' => 'name','class' => '!text-2xl !important']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','wire:model' => 'name','class' => '!text-2xl !important']); ?>
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
                                                    </td>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php else: ?>
                                                 <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                                :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                                x-text="date.date_arrival_pm">
                                            </td>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if(!empty($date['editable'])): ?>
                                                <!--[if BLOCK]><![endif]--><?php if(!!$date['date_departure_pm']): ?>
                                                  <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                                :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                                x-text="date.date_departure_pm"></td>
                                                <?php else: ?>
                                                    <!-- Editable Mode -->
                                                    <td
                                                        class="border-l border-b border-black border-solid px-2.5 py-1 text-center whitespace-nowrap">
                                                        <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['class' => 'text-2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-2xl']); ?>
                                                            <?php if (isset($component)) { $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.index','data' => ['type' => 'text','wire:model' => 'name','class' => '!text-2xl !important']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','wire:model' => 'name','class' => '!text-2xl !important']); ?>
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
                                                    </td>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php else: ?>
                                               <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                                :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                                x-text="date.date_departure_pm"></td>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            <td class="border-l border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                                :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                                x-text="convertUndertime('h',date)">

                                            </td>
                                            <td class="border-x border-b border-black border-solid px-2.5 py-1  text-center whitespace-nowrap"
                                                :class="typeof(date) === 'string' || date.type == 'travel' ? 'hidden' : ''"
                                                x-text="convertUndertime('m',date)">

                                            </td>
                                            
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                                </table>
                            </div>
                            <div class="max-w-[29rem] ">
                                <p class="pb-12 pt-5">I certify on my honor that the above is a true and correct report
                                    of the
                                    hours
                                    of work performed, record of which was made daily at the time of arrival and
                                    departure from
                                    office.</p>

                                <div class="border-b border-black border-solid"></div>

                                <p class="pt-5 pb-12">VERIFIED as to the prescribed office hours:</p>
                                <div class="border-b border-black border-solid"></div>
                                <p class="text-center">in charge</p>
                            </div>

                        </div>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

        </section>
    </main>

</div>
    <?php
        $__scriptKey = '618109592-1';
        ob_start();
    ?>
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            textWeight: false,
            init() {
                setTimeout(() => {
                    $dispatch('open-modal', {
                        id: 'dtr-id'
                    })
                    console.log('dsad')
                }, 2000)
                // $dispatch('open-modal', {
                //     id: 'edit-user'
                // })

            },
            convertUndertime(type, date) {
                if (date.type != 'Absent' && typeof(date) !== 'string') {
                    const hours = Math.floor(date.undertime / 60); // Calculate hours
                    const minutes = date.undertime % 60; // Calculate remaining minutes

                    if (type == 'm') {
                        // return minutes > 0 ? minutes : '';
                    } else {
                        // return hours > 0 ? hours : '';
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

                Object.entries(employee).forEach(([key, value]) => {
                    if (typeof(value) !== 'string') {

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
                    // return date.type;
                } else {
                    return date.date_arrival_am;
                }

            },
            updateDtr(value, id) {
                $wire.updateDtr(value, id);
            },
            async generateMe(id) {

                const {
                    jsPDF
                } = window.jspdf;
                const element = document.getElementById('table' + id);

                // Capture the content of the div using html2canvas
                const scale = 5; // Adjust scale for resolution
                const canvas = await html2canvas(element, {
                    scale: scale,
                    useCORS: true
                });

                // Convert the canvas to a data URL with reduced quality
                const imgData = canvas.toDataURL('image/jpeg', 0.8); // Adjust quality (0.8 = 80%)

                // Create a new jsPDF instance with A4 dimensions
                const pdf = new jsPDF('p', 'pt', 'a4'); // 'a4' is a predefined size in jsPDF

                // Define margins
                const margin = 20; // Reduced margin (20 points)
                const pageWidth = pdf.internal.pageSize.getWidth() - 2 * margin; // Printable width
                const pageHeight = pdf.internal.pageSize.getHeight() - 2 * margin; // Printable height

                // Calculate the aspect ratio of the captured image
                const imgAspectRatio = canvas.width / canvas.height;

                // Calculate the dimensions to fit the image within the printable area
                let imgWidth, imgHeight;
                if (imgAspectRatio > 1) {
                    // Landscape image
                    imgWidth = pageWidth;
                    imgHeight = pageWidth / imgAspectRatio;
                    if (imgHeight > pageHeight) {
                        imgHeight = pageHeight;
                        imgWidth = pageHeight * imgAspectRatio;
                    }
                } else {
                    // Portrait image
                    imgHeight = pageHeight;
                    imgWidth = pageHeight * imgAspectRatio;
                    if (imgWidth > pageWidth) {
                        imgWidth = pageWidth;
                        imgHeight = pageWidth / imgAspectRatio;
                    }
                }

                // Center the image on the page
                const x = (pdf.internal.pageSize.getWidth() - imgWidth) / 2;
                const y = (pdf.internal.pageSize.getHeight() - imgHeight) / 2;

                // Add the captured image to the PDF
                pdf.addImage(imgData, 'JPEG', x, 10, imgWidth, imgHeight);

                // Save the PDF
                pdf.save('DTR.pdf');
            },


        }));
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/livewire/leave/asset/dtr_print_employee.blade.php ENDPATH**/ ?>