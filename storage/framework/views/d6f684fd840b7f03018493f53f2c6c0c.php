<?php if (isset($component)) { $__componentOriginalb6c54c1805cbceaf226d77ef80a67c61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb6c54c1805cbceaf226d77ef80a67c61 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.assets.admin_layout','data' => ['target' => 'store']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('assets.admin_layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['target' => 'store']); ?>
     <?php $__env->slot('modal', null, []); ?> 
        <div x-cloak class="z-50">
            <?php if (isset($component)) { $__componentOriginal028e05680f6c5b1e293abd7fbe5f9758 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-actions::components.modals','data' => ['class' => 'z-50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament-actions::modals'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'z-50']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758)): ?>
<?php $attributes = $__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758; ?>
<?php unset($__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal028e05680f6c5b1e293abd7fbe5f9758)): ?>
<?php $component = $__componentOriginal028e05680f6c5b1e293abd7fbe5f9758; ?>
<?php unset($__componentOriginal028e05680f6c5b1e293abd7fbe5f9758); ?>
<?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>
    <div>
        <!-- Breadcrumb -->
        <?php if (isset($component)) { $__componentOriginalc2072a121b282e859e8bdea9c58b76d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2072a121b282e859e8bdea9c58b76d8 = $attributes; } ?>
<?php $component = App\View\Components\BreadCrumb::resolve(['list' => [
            [
                'link' => null,
                'name' => 'Leave',
            ],
            [
                'link' => route('leave.my_leave'),
                'name' => 'My Leave',
            ],
            [
                'link' => null,
                'name' => $title,
            ],
        ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('bread-crumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\BreadCrumb::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-10']); ?>
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

        <!--[if BLOCK]><![endif]--><?php if($leave): ?>
            <main class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                
                <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['class' => 'lg:col-span-3 h-fit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'lg:col-span-3 h-fit']); ?>
                     <?php $__env->slot('heading', null, []); ?> 
                        <div class="flex items-center gap-1">
                            <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => 'heroicon-m-paper-clip','class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-m-paper-clip','class' => 'size-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?> Leave Information
                        </div>
                     <?php $__env->endSlot(); ?>
                    <main class="flex gap-20 text-sm">
                        <div class="space-y-3">
                            <h1 class="dark:text-white text-gray-500">Code</h1>
                            <h1 class="dark:text-white text-gray-500">Subject</h1>
                            <h1 class="dark:text-white text-gray-500">Type of Leave</h1>
                            <h1 class="dark:text-white text-gray-500">Type of process</h1>
                            <h1 class="dark:text-white text-gray-500">Date</h1>
                            <h1 class="dark:text-white text-gray-500">Paid days</h1>
                            <h1 class="dark:text-white text-gray-500">Not Paid days</h1>
                            <h1 class="dark:text-white text-gray-500">Status</h1>
                            <h1 class="dark:text-white text-gray-500">Attachment File(s)</h1>
                        </div>
                        <div class="space-y-3">
                            <h1 class="dark:text-white text-black font-medium"><?php echo e($leave?->code); ?></h1>
                            <h1 class="dark:text-white text-black font-medium"><?php echo e($leave?->subject_title); ?></h1>
                            <h1 class="dark:text-white text-black font-medium"><?php echo e($leave?->type_of_leave); ?></h1>
                            <h1 class="dark:text-white text-black font-medium"><?php echo e($leave?->type_of_process); ?></h1>
                            <h1 class="dark:text-white text-black font-medium">
                                <?php echo e($this->convertDate(json_decode($leave?->date))); ?>

                            </h1>
                            <h1 class="dark:text-white text-black font-medium">
                                <?php echo e($leave?->paid_days); ?>

                            </h1>
                            <h1 class="dark:text-white text-black font-medium">
                                <?php echo e($leave?->notpaid_days); ?>

                            </h1>
                            <h1 class="dark:text-white text-black font-medium">
                                <!--[if BLOCK]><![endif]--><?php if($leave?->status == 'APPROVED'): ?>
                                    <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['class' => 'w-fit','color' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-fit','color' => 'success']); ?>
                                        <?php echo e($leave?->status); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $attributes = $__attributesOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $component = $__componentOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__componentOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
                                <?php elseif($leave?->status == 'DISAPPROVED'): ?>
                                    <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['class' => 'w-fit','color' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-fit','color' => 'danger']); ?>
                                        <?php echo e($leave?->status); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $attributes = $__attributesOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $component = $__componentOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__componentOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
                                <?php elseif($leave?->status == 'PENDING'): ?>
                                    <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['class' => 'w-fit','color' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-fit','color' => 'warning']); ?>
                                        <?php echo e($leave?->status); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $attributes = $__attributesOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $component = $__componentOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__componentOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            </h1>
                            <div>
                                <?php echo e($this->iconPreviewAction); ?>

                                <?php echo e($this->iconButtonAction); ?>

                                <!--[if BLOCK]><![endif]--><?php if(!!$leave?->signed_file && $leave->type_of_process == 'ELECTRONIC SIGNATURE'): ?>
                                    <?php echo e($this->iconButtonSignedAction); ?>

                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if(!!$leave?->signed_file && $leave->type_of_process == 'WET SIGNATURE'): ?>
                                    <?php echo e($this->iconButtonSignedWetAction); ?>

                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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

                
                <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['class' => 'lg:col-span-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'lg:col-span-2']); ?>
                     <?php $__env->slot('heading', null, []); ?> 
                        <div class="flex items-center gap-1">
                            <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => 'heroicon-o-clock','class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-o-clock','class' => 'size-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?> Leave Logs
                        </div>
                     <?php $__env->endSlot(); ?>

                    <div class="flex w-full items-center">
                        
                        <!--[if BLOCK]><![endif]--><?php if(
                            ($leave?->location == 'Chief' || $leave?->location == 'Rd' || $leave?->location == 'Records') &&
                                $leave?->head_status == 1): ?>
                            <div class="flex w-fit items-center  dark:text-white  mr-1">
                                <span
                                    class="flex items-center justify-center w-6 h-6  bg-green-500 rounded-full  dark:bg-green-800 shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white  dark:text-green-300" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                    </svg>
                                </span>
                                Head
                            </div>
                            <div class="w-full h-1 border-b border-green-500 border-4"></div>
                        <?php elseif(
                            ($leave?->location == 'Chief' || $leave?->location == 'Rd' || $leave?->location == 'Records') &&
                                $leave?->head_status == 0): ?>
                            <div class="flex w-fit items-center  dark:text-white  mr-1">
                                <span
                                    class="flex items-center justify-center w-6 h-6 bg-red-500 rounded-full   shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white  dark:text-green-300" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                    </svg>
                                </span>
                                Head
                            </div>
                            <div class="w-full h-1 border-b border-red-500 border-4"></div>
                        <?php elseif($leave?->head_status == 0 && $leave?->chief_status == 0 && $leave?->rd_status == 0): ?>
                            <div class="flex w-fit items-center  dark:text-white  mr-1 animate-pulse">
                                <span
                                    class="flex items-center justify-center w-6 h-6 <?php echo e($leave?->status == 'DISAPPROVED' ? 'bg-red-500 ' : ' bg-blue-500 dark:bg-blue-800'); ?> rounded-full   shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white  dark:text-green-300" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                    </svg>
                                </span>
                                Head
                            </div>
                            <div class="w-full h-1 border-b border-gray-200 border-4"></div>
                        <?php else: ?>
                            <div class="flex w-fit items-center  dark:text-white  mr-1 animate-pulse">
                                <span
                                    class="flex items-center justify-center w-6 h-6 <?php echo e($leave?->status == 'DISAPPROVED' ? 'bg-red-500 ' : ' bg-blue-500 dark:bg-blue-800'); ?> rounded-full   shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white  dark:text-green-300" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                    </svg>
                                </span>
                                Head
                            </div>
                            <div class="w-full h-1 border-b border-gray-200 border-4"></div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <!--[if BLOCK]><![endif]--><?php if(($leave?->location == 'Records' || $leave?->location == 'Rd') && $leave?->chief_status == 1): ?>
                            <div class="flex w-fit items-center text-green-500  mx-1 ">
                                <span
                                    class="flex items-center   justify-center w-6 h-6 bg-green-500 rounded-full  dark:bg-green-800  shrink-0">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white  " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                        <path
                                            d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </span>
                                Chief
                            </div>
                            <div class="w-full h-1 border-b border-green-500 border-4"></div>
                        <?php elseif(($leave?->location == 'Records' || $leave?->location == 'Rd') && $leave?->chief_status == 0): ?>
                            <div class="flex w-fit items-center  text-red-500 mx-1 ">
                                <span
                                    class="flex items-center bg-red-500 justify-center w-6 h-6  rounded-full dark:bg-gray-700 shrink-0">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white  " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                        <path
                                            d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </span>
                                Chief
                            </div>
                            <div class="w-full h-1 border-b border-red-500 border-4"></div>
                        <?php elseif($leave?->location == 'Chief'): ?>
                            <div class="flex w-fit items-center  text-gray-500 mx-1">
                                <span
                                    class="flex items-center  justify-center w-6 h-6  rounded-full bg-blue-500 dark:bg-blue-800 shrink-0 animate-pulse">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                        <path
                                            d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </span>
                                Chief
                            </div>
                            <div class="w-full h-1 border-b border-gray-200 border-4"></div>
                        <?php else: ?>
                            <div class="flex w-fit items-center  text-gray-500 mx-1">
                                <span
                                    class="flex items-center  justify-center w-6 h-6  rounded-full bg-gray-500 dark:bg-gray-800 shrink-0 ">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                        <path
                                            d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </span>
                                Chief
                            </div>
                            <div class="w-full h-1 border-b border-gray-200 border-4"></div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        
                        <!--[if BLOCK]><![endif]--><?php if(($leave?->location == 'Chief' || $leave?->location == 'Rd') && $leave?->rd_status == 1): ?>
                            <div class="flex w-fit items-center  text-green-500 mx-1 ">
                                <span
                                    class="flex items-center bg-green-500 justify-center w-6 h-6  rounded-full dark:bg-gray-700 shrink-0">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white  " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path
                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                    </svg>
                                </span>
                                RD/ARD
                            </div>
                        <?php elseif($leave?->location == 'Rd'): ?>
                            <div class="flex w-fit items-center  text-blue-500 mx-1 animate-pulse">
                                <span
                                    class="flex items-center bg-blue-500 justify-center w-6 h-6  rounded-full dark:bg-gray-700 shrink-0">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white  " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path
                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                    </svg>
                                </span>
                                RD/ARD
                            </div>
                        <?php elseif($leave?->location == 'Records'): ?>
                            <div class="flex w-fit items-center   text-green-500 mx-1 ">
                                <span
                                    class="flex items-center bg-green-500 justify-center w-6 h-6  rounded-full dark:bg-green-700 shrink-0">
                                    <svg class="w-4 h-4 text-white lg:w-3 lg:h-3 dark:text-white  " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path
                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                    </svg>
                                </span>
                                RD/ARD
                            </div>
                        <?php else: ?>
                            <div class="flex w-fit items-center  dark:text-white  dark:after:border-green-800 mx-1">
                                <span
                                    class="flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full dark:bg-gray-700 shrink-0">
                                    <svg class="w-4 h-4 text-gray-500 lg:w-5 lg:h-5 dark:text-gray-100"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        viewBox="0 0 18 20">
                                        <path
                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                    </svg>
                                </span>
                                RD/ARD
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                    </div>


                    
                    <main class="py-10 px-5 space-y-4">
                        <hr>
                        <ol class="relative border-s border-gray-400 dark:border-gray-700 ">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $leavelogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <!--[if BLOCK]><![endif]--><?php if(!$loop->first): ?>
                                    <li class="mb-10 ms-4">
                                        <div
                                            class="absolute w-3 h-3 bg-green-400 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-green-700">
                                        </div>
                                        <h3 class="text-sm font-semibold text-black dark:text-white">
                                            <?php echo e($log?->activity); ?></h3>
                                        <time
                                            class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"><?php echo e(\Carbon\Carbon::parse($log?->created_at)->format('F d, Y h:i:s A')); ?></time>

                                        <div class="flex items-center text-xs dark:text-gray-200">
                                            <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['icon' => 'heroicon-s-map-pin','label' => 'Location','color' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-s-map-pin','label' => 'Location','color' => 'danger']); ?>
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
                                            <?php echo e($log?->location); ?>

                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if(!!$log?->remarks): ?>
                                            <div
                                                class="rounded py-1 px-1 mt-2 text-xs font-bold border border-black w-fit dark:text-gray-200 dark:border-gray-300">
                                                Remarks: <?php echo $log?->remarks; ?>

                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



                                    </li>
                                <?php else: ?>
                                    <li class="mb-10 ms-4">
                                        <div
                                            class="absolute w-3 h-3 bg-blue-500 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">

                                        </div>
                                        <h3 class="text-sm font-semibold text-black dark:text-white">
                                            <?php echo e($log?->activity); ?></h3>
                                        <time
                                            class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"><?php echo e(\Carbon\Carbon::parse($log?->created_at)->format('F d, Y h:i:s A')); ?></time>

                                        <div class="flex items-center text-xs dark:text-gray-200">
                                            <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['icon' => 'heroicon-s-map-pin','label' => 'Location','color' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-s-map-pin','label' => 'Location','color' => 'danger']); ?>
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
                                            <?php echo e($log?->location); ?>

                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if(!!$log?->remarks): ?>
                                            <div
                                                class="rounded py-1 px-1 mt-2 text-xs font-bold border border-black w-fit dark:text-gray-200 dark:border-gray-300">
                                                Remarks: <?php echo $log?->remarks; ?>

                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



                                    </li>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->



                        </ol>
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
            </main>
        <?php else: ?>
            <div class="w-full flex justify-center items-center p-10">
                <div class="text-center">
                    <h1 class="text-6xl font-bold text-gray-800 mb-4 dark:text-white">
                        404
                    </h1>
                    <p class="text-2xl text-gray-600 mb-8 dark:text-gray-300">
                        Oops! The page you're looking for doesn't exist.
                    </p>

                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

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
        $__scriptKey = '3449618155-0';
        ob_start();
    ?>
    <script>
        Alpine.data('skillDisplay', () => ({
            aside: true,
            apexChart: null,
            init() {


            }
        }));
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/livewire/leave/request-view.blade.php ENDPATH**/ ?>