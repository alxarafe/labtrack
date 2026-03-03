<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'type' => 'text',
    'name',
    'label' => '',
    'value' => '',
    'help' => '',
    'actions' => []
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'type' => 'text',
    'name',
    'label' => '',
    'value' => '',
    'help' => '',
    'actions' => []
]); ?>
<?php foreach (array_filter(([
    'type' => 'text',
    'name',
    'label' => '',
    'value' => '',
    'help' => '',
    'actions' => []
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $leftActions = array_filter($actions, fn($act) => ($act['position'] ?? 'left') === 'left');
    $rightActions = array_filter($actions, fn($act) => ($act['position'] ?? 'left') === 'right');
    $hasActions = count($actions) > 0;
?>

<div class="mb-3">
    <?php if($label): ?>
        <label for="<?php echo e($name); ?>" class="form-label"><?php echo e($label); ?></label>
    <?php endif; ?>
    
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['input-group' => $hasActions]); ?>">
        <?php $__currentLoopData = $leftActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button class="btn <?php echo e($action['class'] ?? 'btn-outline-secondary'); ?>" 
                    type="button" 
                    onclick="<?php echo $action['onclick']; ?>" 
                    title="<?php echo e($action['title'] ?? ''); ?>" 
                    <?php if(!empty($action['title'])): ?> data-bs-toggle="tooltip" <?php endif; ?>>
                <i class="<?php echo e($action['icon']); ?>"></i>
            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <input type="<?php echo e($type); ?>" name="<?php echo e($name); ?>" id="<?php echo e($attributes->get('id', $name)); ?>"
               placeholder="<?php echo e($label); ?>" value="<?php echo e($value); ?>"
               <?php echo e($attributes->whereDoesntStartWith('id')->merge(['class' => 'form-control'])); ?>>

        <?php $__currentLoopData = $rightActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button class="btn <?php echo e($action['class'] ?? 'btn-outline-secondary'); ?>" 
                    type="button" 
                    onclick="<?php echo $action['onclick']; ?>" 
                    title="<?php echo e($action['title'] ?? ''); ?>" 
                    <?php if(!empty($action['title'])): ?> data-bs-toggle="tooltip" <?php endif; ?>>
                <i class="<?php echo e($action['icon']); ?>"></i>
            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($help): ?>
        <div class="form-text"><?php echo e($help); ?></div>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/vendor/alxarafe/alxarafe/templates//form/input.blade.php ENDPATH**/ ?>