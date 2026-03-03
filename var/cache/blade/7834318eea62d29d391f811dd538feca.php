<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['title' => null, 'image' => null, 'footer' => null, 'header' => null, 'class' => 'card shadow-sm']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['title' => null, 'image' => null, 'footer' => null, 'header' => null, 'class' => 'card shadow-sm']); ?>
<?php foreach (array_filter((['title' => null, 'image' => null, 'footer' => null, 'header' => null, 'class' => 'card shadow-sm']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => $class])); ?>>
    <?php if($header || isset($header_slot)): ?>
        <div class="card-header">
            <?php echo e($header ?? $header_slot); ?>

        </div>
    <?php endif; ?>
    <?php if($image): ?>
        <img src="<?php echo e($image); ?>" class="card-img-top" alt="<?php echo e($title ?? 'Card image'); ?>">
    <?php endif; ?>
    <div class="card-body">
        <?php if($title): ?>
            <h5 class="card-title fw-bold"><?php echo e($title); ?></h5>
        <?php endif; ?>
        <?php echo e($slot); ?>

    </div>
    <?php if($footer || isset($footer_slot)): ?>
        <div class="card-footer">
            <?php echo e($footer ?? $footer_slot); ?>

        </div>
    <?php endif; ?>
</div><?php /**PATH /var/www/html/vendor/alxarafe/alxarafe/templates//component/card.blade.php ENDPATH**/ ?>