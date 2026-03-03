<?php
    $hasSidebar = !empty($main_menu);
?>
<div id="id_container" class="id_container <?php echo e($hasSidebar ? 'has-sidebar' : 'no-sidebar'); ?>">
    <?php if($hasSidebar): ?>
        <?php echo $__env->make('partial.main_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <div id="id-right">

        <?php echo $__env->make('partial.user_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Unified Page Header -->
        <div class="container-fluid mt-4">
            <div class="row mb-4 align-items-center">
                <div class="col d-flex align-items-center">
                    <?php if($me->title): ?>
                        <h1 class="display-6 fw-bold mb-0"><?php echo $me->title; ?></h1>
                    <?php endif; ?>
                </div>
                <div class="col text-end">
                    <div class="page-actions" id="global-actions-container">
                        <?php echo $__env->yieldContent('header_actions'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php echo $__env->make('partial.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>
<?php /**PATH /var/www/alxarafe/templates/partial/body_standard.blade.php ENDPATH**/ ?>