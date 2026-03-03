<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['name', 'value' => '']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['name', 'value' => '']); ?>
<?php foreach (array_filter((['name', 'value' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>" <?php echo e($attributes); ?>>
<?php /**PATH /var/www/html/vendor/alxarafe/alxarafe/templates//form/hidden.blade.php ENDPATH**/ ?>