<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar me-2"></i><?php echo e($me->_('reports')); ?>

                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="<?php echo e($me::url('user')); ?>" class="btn btn-outline-primary btn-lg p-4">
                            <i class="fas fa-user-chart fa-2x mb-2 d-block"></i>
                            <?php echo e($me->_('user_report')); ?>

                        </a>
                        <a href="<?php echo e($me::url('order')); ?>" class="btn btn-outline-info btn-lg p-4 text-dark">
                            <i class="fas fa-file-invoice fa-2x mb-2 d-block"></i>
                            <?php echo e($me->_('order_report')); ?>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/templates/labtrack/report/index.blade.php ENDPATH**/ ?>