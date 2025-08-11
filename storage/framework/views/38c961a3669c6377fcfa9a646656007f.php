    <?php
        $__assetKey = '376292126-0';

        ob_start();
    ?>
    <style>
        .trSplit>div {
            width: 100%;
        }

        .trSplit>div>.max-w-max {
            min-width: 100%;

        }

        .trSplit>div>.max-w-max>div {
            min-width: 100%;

        }

        .trSplit>div>.max-w-max>div>span {
            min-width: 100%;
            display: flex;
            justify-content: space-around
        }

        .fi-table-header-cell-i-n-c-l-u-s-i-v-e-d-a-t-e-s>span>span {

            min-width: 100%;
        }
    </style>
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
<?php if (isset($component)) { $__componentOriginalb6c54c1805cbceaf226d77ef80a67c61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb6c54c1805cbceaf226d77ef80a67c61 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.assets.admin_layout','data' => ['target' => 'callMountedTableAction,unmountFormComponentAction']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('assets.admin_layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['target' => 'callMountedTableAction,unmountFormComponentAction']); ?>


     <?php $__env->slot('modal', null, []); ?> 
        <div x-cloak class="z-50">
            
        </div>
     <?php $__env->endSlot(); ?>

    <!--[if BLOCK]><![endif]--><?php if(Auth::user()->fd_code == '01D' || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) || Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
        <div>

            <?php if (isset($component)) { $__componentOriginalc2072a121b282e859e8bdea9c58b76d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2072a121b282e859e8bdea9c58b76d8 = $attributes; } ?>
<?php $component = App\View\Components\BreadCrumb::resolve(['list' => [
                [
                    'link' => null,
                    'name' => 'Recruitment',
                ],
                [
                    'link' => null,
                    'name' => 'All Applicants',
                ],
            ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('bread-crumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\BreadCrumb::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-10 ']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2072a121b282e859e8bdea9c58b76d8)): ?>
<?php $attributes = $__attributesOriginalc2072a121b282e859e8bdea9c58b76d8; ?>
<?php unset($__attributesOriginalc2072a121b282e859e8bdea9c58b76d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2072a121b282e859e8bdea9c58b76d8)): ?>
<?php $component = $__componentOriginalc2072a121b282e859e8bdea9c58b76d8; ?>
<?php unset($__componentOriginalc2072a121b282e859e8bdea9c58b76d8); ?>
<?php endif; ?>
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
                        ALL APPLICATION
                     <?php $__env->endSlot(); ?>
                    <ul class="py-2">
                        <?php if (isset($component)) { $__componentOriginal447636fe67a19f9c79619fb5a3c0c28d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.tabs.index','data' => ['label' => 'Content tabs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Content tabs']); ?>
                            <?php if (isset($component)) { $__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.tabs.item','data' => ['icon' => 'heroicon-o-list-bullet','class' => ''.e($activeTab === 'all' ? 'border' : '').'','active' => $activeTab === 'all','disabled' => $activeTab === 'all','xOn:click' => 'changeTab(\'all\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::tabs.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-o-list-bullet','class' => ''.e($activeTab === 'all' ? 'border' : '').'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeTab === 'all'),'disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeTab === 'all'),'x-on:click' => 'changeTab(\'all\')']); ?>
                                ALL
                                 <?php $__env->slot('badge', null, []); ?> 
                                    <?php echo e($allCount); ?>

                                 <?php $__env->endSlot(); ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f)): ?>
<?php $attributes = $__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f; ?>
<?php unset($__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f)): ?>
<?php $component = $__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f; ?>
<?php unset($__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f); ?>
<?php endif; ?>


                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d)): ?>
<?php $attributes = $__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d; ?>
<?php unset($__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal447636fe67a19f9c79619fb5a3c0c28d)): ?>
<?php $component = $__componentOriginal447636fe67a19f9c79619fb5a3c0c28d; ?>
<?php unset($__componentOriginal447636fe67a19f9c79619fb5a3c0c28d); ?>
<?php endif; ?>


                    </ul>

                    <div class="w-full " wire:loading wire:loading.delay.longest wire:target="changeTab">
                        <?php if (isset($component)) { $__componentOriginalbef7c2371a870b1887ec3741fe311a10 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbef7c2371a870b1887ec3741fe311a10 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.loading-indicator','data' => ['class' => 'size-14 mx-auto mt-10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::loading-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-14 mx-auto mt-10']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbef7c2371a870b1887ec3741fe311a10)): ?>
<?php $attributes = $__attributesOriginalbef7c2371a870b1887ec3741fe311a10; ?>
<?php unset($__attributesOriginalbef7c2371a870b1887ec3741fe311a10); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbef7c2371a870b1887ec3741fe311a10)): ?>
<?php $component = $__componentOriginalbef7c2371a870b1887ec3741fe311a10; ?>
<?php unset($__componentOriginalbef7c2371a870b1887ec3741fe311a10); ?>
<?php endif; ?>
                    </div>

                    <button x-ref="clickMe" class="hidden" x-on:click="$wire.$refresh()">clicke</button>

                    <div wire:loading.remove wire:target="changeTab">

                        <?php echo e($this->table); ?>


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
            <?php else: ?>
                <div class=" mx-auto w-fit">
                    <?php echo $__env->make('components.restrict', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
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
        $__scriptKey = '376292126-1';
        ob_start();
    ?>
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            clickMe: null,
            init() {




            },
            async changeTab($value) {
                await $wire.changeTab($value);
                $wire.$refresh()
            }
        }));
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/livewire/recruitment/all-applicant.blade.php ENDPATH**/ ?>