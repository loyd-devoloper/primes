<?php
    $id = $getId();
    $isContained = $getContainer()->getParentComponent()->isContained();

    $visibleStepClasses = \Illuminate\Support\Arr::toCssClasses([
        'p-6' => $isContained,
        'mt-6' => ! $isContained,
    ]);

    $invisibleStepClasses = 'invisible h-0 overflow-y-hidden p-0';
?>

<div
    x-bind:class="{
        <?php echo \Illuminate\Support\Js::from($visibleStepClasses)->toHtml() ?>: step === <?php echo \Illuminate\Support\Js::from($id)->toHtml() ?>,
        <?php echo \Illuminate\Support\Js::from($invisibleStepClasses)->toHtml() ?>: step !== <?php echo \Illuminate\Support\Js::from($id)->toHtml() ?>,
    }"
    x-on:expand="
        if (! isStepAccessible(<?php echo \Illuminate\Support\Js::from($id)->toHtml() ?>)) {
            return
        }

        step = <?php echo \Illuminate\Support\Js::from($id)->toHtml() ?>
    "
    x-ref="step-<?php echo e($id); ?>"
    <?php echo e($attributes
            ->merge([
                'aria-labelledby' => $id,
                'id' => $id,
                'role' => 'tabpanel',
                'tabindex' => '0',
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
            ->class(['fi-fo-wizard-step outline-none'])); ?>

>
    <?php echo e($getChildComponentContainer()); ?>

</div>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/vendor/filament/forms/resources/views/components/wizard/step.blade.php ENDPATH**/ ?>