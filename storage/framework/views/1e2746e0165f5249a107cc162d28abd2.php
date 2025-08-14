<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'activeAccordion' => 1,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'activeAccordion' => 1,
]); ?>
<?php foreach (array_filter(([
    'activeAccordion' => 1,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div x-data="{
        activeAccordion: 'accordion-<?php echo e($activeAccordion); ?>',
        setActiveAccordion(id) {
            this.activeAccordion = (this.activeAccordion == id) ? '' : id
        }
    }"
     class="fi-accordion rounded-xl shadow-sm
        bg-white dark:bg-gray-900
        ring-1 ring-gray-950/10 dark:ring-white/10
        divide-y divide-gray-300 dark:divide-white/10
      "
>
    <div class="p-2">
        <?php echo e($slot); ?>

    </div>
</div><?php /**PATH /home/loyd-deped/Desktop/www/PDS/vendor/lara-zeus/accordion/resources/views/components/accordion/index.blade.php ENDPATH**/ ?>