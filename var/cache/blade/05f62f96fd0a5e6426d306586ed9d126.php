<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-search me-2"></i><?php echo e($me->_('order_search')); ?>

                    </h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo e($me::url('index')); ?>" method="POST">
                        <div class="mb-3">
                            <label for="order" class="form-label"><?php echo e($me->_('order_number')); ?></label>
                            <input type="text" name="order" id="order" class="form-control form-control-lg" 
                                   placeholder="<?php echo e($me->_('enter_order_number')); ?>" required autofocus>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="search" class="btn btn-primary btn-lg">
                                <?php echo e($me->_('search')); ?>

                            </button>
                            <a href="<?php echo e($me::url('logout')); ?>" class="btn btn-outline-danger">
                                <?php echo e($me->_('exit')); ?>

                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/templates/labtrack/order/index.blade.php ENDPATH**/ ?>