<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('component.card', ['title' => 'Error', 'name' => 'error']); ?>
        <div class="alert alert-danger">
            <h4><i class="fas fa-exclamation-triangle"></i> Error</h4>
            <p><?php echo e($errorMessage ?? 'Unknown Error'); ?></p>
            <?php if(!empty($errorTrace)): ?>
                <hr>
                <div style="max-height: 300px; overflow-y: auto; background-color: #f8f9fa; padding: 10px; border-radius: 5px;">
                    <strong>Stack Trace:</strong>
                    <pre style="white-space: pre-wrap; margin-top: 10px;"><?php echo e($errorTrace); ?></pre>
                </div>
            <?php endif; ?>
        </div>
        <p>Go to the <a href="index.php?module=Admin&controller=Auth">user login page</a> to access the application.</p>
        <p>You can access the settings at the following <a href="index.php?module=Admin&controller=Config">link</a>.</p>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    
<?php $__env->stopPush(); ?>

<?php echo $__env->make('partial.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/alxarafe/src/Modules/Admin/Templates/page/error.blade.php ENDPATH**/ ?>