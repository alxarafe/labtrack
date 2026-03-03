<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['variant' => 'primary', 'tag' => 'button', 'href' => '#', 'spacing' => null]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['variant' => 'primary', 'tag' => 'button', 'href' => '#', 'spacing' => null]); ?>
<?php foreach (array_filter((['variant' => 'primary', 'tag' => 'button', 'href' => '#', 'spacing' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $finalClass = "btn btn-{$variant}";
    if ($spacing) {
        $finalClass .= " {$spacing}";
    }
?>

<?php if($tag === 'link' || $attributes->has('href')): ?>
    <a <?php echo e($attributes->merge(['class' => $finalClass, 'href' => $href])); ?>>
        <?php echo e($slot); ?>

    </a>
<?php else: ?>
    <button <?php echo e($attributes->merge(['type' => 'button', 'class' => $finalClass])); ?>>
        <?php echo e($slot); ?>

    </button>
<?php endif; ?><?php /**PATH /var/www/alxarafe/templates/component/button.blade.php ENDPATH**/ ?>