<div class="sidebar" id="sidebar-wrapper">
    <!-- App Branding -->
    <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
        <i class="<?php echo e(\Alxarafe\Base\Config::getConfig()->main->appIcon ?? 'fas fa-rocket'); ?> me-2"></i> <?php echo e(\Alxarafe\Base\Config::getConfig()->main->appName ?? 'Alxarafe'); ?>

    </div>
    <!-- Main Menu (Navigation) -->
    <?php if(!empty($main_menu) && is_array($main_menu)): ?>
        <nav class="nav flex-column">
        <?php $__currentLoopData = $main_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($item['url']); ?>" class="nav-link text-body" title="<?php echo e($item['label']); ?>">
                <?php if(!empty($item['icon'])): ?>
                    <i class="<?php echo e($item['icon']); ?> me-2"></i>
                <?php endif; ?>
                <span class="d-none d-md-inline"><?php echo e($item['label']); ?></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>
    <?php endif; ?>


</div>
<!-- Legacy Fallback removed --><?php /**PATH /var/www/alxarafe/templates/partial/main_menu.blade.php ENDPATH**/ ?>