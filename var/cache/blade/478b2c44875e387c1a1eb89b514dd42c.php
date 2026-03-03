<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['type' => 'info', 'dismissible' => false]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['type' => 'info', 'dismissible' => false]); ?>
<?php foreach (array_filter((['type' => 'info', 'dismissible' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => "alert alert-{$type}" . ($dismissible ? ' alert-dismissible fade show' : '')])); ?> role="alert">
    <?php echo e($slot); ?>

    <?php if($dismissible): ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <?php endif; ?>
</div><?php /**PATH /var/www/html/vendor/alxarafe/alxarafe/templates//component/alert.blade.php ENDPATH**/ ?>