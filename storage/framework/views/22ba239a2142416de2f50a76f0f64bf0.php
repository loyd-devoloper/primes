<div class="space-y-2 max-h-[70svh] overflow-y-auto">
    <div class="px-4 py-2 border <?php echo e($getRecord()->letter_of_intent_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->letter_of_intent_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
                <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
            <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value)->getColumn()])); ?>

            <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value)->getColumn()])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value])); ?>



        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::LETTER_OF_INTENT->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>

    <div class="px-4 py-2 border <?php echo e($getRecord()->pds_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->pds_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::PDS->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
                <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
            <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PDS->value)->getColumn()])); ?>

            <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PDS->value)->getColumn()])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::PDS->value])); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::PDS->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::PDS->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>


    <div class="px-4 py-2 border <?php echo e($getRecord()->prc_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->prc_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::PRC->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
                <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
            <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PRC->value)->getColumn()])); ?>

            <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PRC->value)->getColumn()])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::PRC->value])); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::PRC->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::PRC->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>

    <div class="px-4 py-2 border <?php echo e($getRecord()->tor_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->tor_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::TOR->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
                <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
            <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::TOR->value)->getColumn()])); ?>

            <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::TOR->value)->getColumn()])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::TOR->value])); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::TOR->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::TOR->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>

    <div class="px-4 py-2 border <?php echo e($getRecord()->training_attended_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->training_attended_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
                <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
            <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value)->getColumn()])); ?>

            <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value)->getColumn()])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value])); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::TRAINING_ATTENDED->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>

    <div class="px-4 py-2 border <?php echo e($getRecord()->certificate_of_employment_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->certificate_of_employment_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
                <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
            <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value)->getColumn()])); ?>

            <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value)->getColumn()])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value])); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>

    <div class="px-4 py-2 border <?php echo e($getRecord()->latest_appointment_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->latest_appointment_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
                <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
            <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value)->getColumn()])); ?>

            <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value)->getColumn()])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value])); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::LATEST_APPOINTMENT->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>

    <div class="px-4 py-2 border <?php echo e($getRecord()->performance_rating_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->performance_rating_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
                <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
            <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value)->getColumn()])); ?>

            <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value)->getColumn()])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value])); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::PERFORMANCE_RATING->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>

    <div class="px-4 py-2 border <?php echo e($getRecord()->cav_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->cav_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::CAV->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">


          <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
              <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
                    <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::CAV->value)->getColumn()])); ?>

                    <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::CAV->value)->getColumn()])); ?>

              <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
          <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::CAV->value])); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::CAV->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::CAV->value))]); ?>
            <?php echo e(($getAction('deletecomment'))(['id'=>\App\Enums\RecruitmentLabelEnum::CAV->value])); ?>

            hello world
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>












    <div class="px-4 py-2 border <?php echo e($getRecord()->neap_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->neap_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::NEAP->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">


            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
                <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
                    <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::NEAP->value)->getColumn()])); ?>

                    <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::NEAP->value)->getColumn()])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::NEAP->value])); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::NEAP->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::NEAP->value))]); ?>
            <?php echo e(($getAction('deletecomment'))(['id'=>\App\Enums\RecruitmentLabelEnum::NEAP->value])); ?>


         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>

    <div class="px-4 py-2 border <?php echo e($getRecord()->movs_status ? 'checkFileApproved' : ''); ?> <?php echo e($getRecord()->movs_status == 2 ? 'checkFileDisApproved' : ''); ?> rounded-md">
        <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::MOVS->value); ?></h1>
        <div class="flex items-center gap-2 mt-2">
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value) ||  Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)): ?>
                <!--[if BLOCK]><![endif]--><?php if($getRecord()->application_status != 2 && $getRecord()->application_status != 4): ?>
            <?php echo e(($getAction('approved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::MOVS->value)->getColumn()])); ?>

            <?php echo e(($getAction('disapproved'))(['id'=>\App\Enums\RecruitmentLabelEnum::tryFrom(\App\Enums\RecruitmentLabelEnum::MOVS->value)->getColumn()])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::MOVS->value])); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::MOVS->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::MOVS->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
    </div>

    <div class="pl-5 space-y-2">
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::AWARDS_AND_RECOGNITION->value); ?></h1>
            <div class="flex items-center gap-2 mt-2">

                <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::AWARDS_AND_RECOGNITION->value])); ?>

            </div>
            <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::AWARDS_AND_RECOGNITION->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::AWARDS_AND_RECOGNITION->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
        </div>
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::RESEARCH_AND_INNOVATION->value); ?></h1>
            <div class="flex items-center gap-2 mt-2">

                <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::RESEARCH_AND_INNOVATION->value])); ?>

            </div>
            <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::RESEARCH_AND_INNOVATION->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::RESEARCH_AND_INNOVATION->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
        </div>
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::MEMBERSHIP_IN_NATIONAL->value); ?></h1>
            <div class="flex items-center gap-2 mt-2">

                <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::MEMBERSHIP_IN_NATIONAL->value])); ?>

            </div>
            <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::MEMBERSHIP_IN_NATIONAL->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::MEMBERSHIP_IN_NATIONAL->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
        </div>
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::RESOURCE_AND_SPEAKERSHIP->value); ?></h1>
            <div class="flex items-center gap-2 mt-2">

                <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::RESOURCE_AND_SPEAKERSHIP->value])); ?>

            </div>
            <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::RESOURCE_AND_SPEAKERSHIP->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::RESOURCE_AND_SPEAKERSHIP->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
        </div>








        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::APPLICATION_OF_EDUCATION->value); ?></h1>
            <div class="flex items-center gap-2 mt-2">

                <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::APPLICATION_OF_EDUCATION->value])); ?>

            </div>
            <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::APPLICATION_OF_EDUCATION->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::APPLICATION_OF_EDUCATION->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
        </div>
        <div class="px-4 py-2 border  rounded-md">
            <h1 class="text-xs"><?php echo e(\App\Enums\RecruitmentLabelEnum::LEARNING_AND_DEVELOPMENT->value); ?></h1>
            <div class="flex items-center gap-2 mt-2">

                <?php echo e(($getAction('comment'))(['id'=>\App\Enums\RecruitmentLabelEnum::LEARNING_AND_DEVELOPMENT->value])); ?>

            </div>
            <?php if (isset($component)) { $__componentOriginal448bbe463d545d1f40b97f29743bddda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal448bbe463d545d1f40b97f29743bddda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.recruitment.comment','data' => ['id' => $getRecord()->id,'comments' => $getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::LEARNING_AND_DEVELOPMENT->value)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('recruitment.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->id),'comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getRecord()->comments?->where('filename', \App\Enums\RecruitmentLabelEnum::LEARNING_AND_DEVELOPMENT->value))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $attributes = $__attributesOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__attributesOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal448bbe463d545d1f40b97f29743bddda)): ?>
<?php $component = $__componentOriginal448bbe463d545d1f40b97f29743bddda; ?>
<?php unset($__componentOriginal448bbe463d545d1f40b97f29743bddda); ?>
<?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/livewire/recruitment/assets/attachment_table.blade.php ENDPATH**/ ?>