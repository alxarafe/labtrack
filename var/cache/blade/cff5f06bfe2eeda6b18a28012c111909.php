<?php
    $themes = \Alxarafe\Lib\Functions::getThemes();
    $currentTheme = $_COOKIE['alx_theme'] ?? \Alxarafe\Base\Config::getConfig()->main->theme ?? 'default';
?>

<div class="dropdown <?php echo e($class ?? ''); ?>">
    <button class="btn btn-link text-info p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="<?php echo e(\Alxarafe\Lib\Trans::_('select_theme')); ?>">
        <i class="fas fa-palette fa-2x"></i>
    </button>
    <ul class="dropdown-menu shadow">
        <li class="dropdown-header text-uppercase small"><?php echo e(\Alxarafe\Lib\Trans::_('available_themes')); ?></li>
        <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a class="dropdown-item d-flex align-items-center <?php echo e($currentTheme === $name ? 'active' : ''); ?>" 
                   href="index.php?module=Admin&controller=Auth&action=setTheme&theme=<?php echo e($name); ?>">
                    <i class="fas fa-circle me-2" style="font-size: 0.5em;"></i>
                    <?php echo e($label); ?>

                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php /**PATH /var/www/alxarafe/templates/partial/theme_switcher.blade.php ENDPATH**/ ?>