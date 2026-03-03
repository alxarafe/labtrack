<!-- Templates/common/form/form.blade.php -->


<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['method' => 'POST', 'action' => '#', 'class' => 'form']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['method' => 'POST', 'action' => '#', 'class' => 'form']); ?>
<?php foreach (array_filter((['method' => 'POST', 'action' => '#', 'class' => 'form']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<form method="<?php echo e(strtoupper($method)); ?>" action="<?php echo e($action); ?>" <?php echo e($attributes->merge(['class' => $class])); ?>>
    <?php echo e($slot); ?>

</form>
<?php /**PATH /var/www/alxarafe/templates/form/form.blade.php ENDPATH**/ ?>