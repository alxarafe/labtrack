<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="mb-5">
        <h1 class="display-5 fw-bold"><?php echo e($title); ?></h1>
        <div class="d-flex gap-3">
             <span class="badge bg-secondary py-2 px-3 fs-6">Orden: #<?php echo e($_SESSION['labtrack']['order_id']); ?></span>
             <span class="badge bg-info text-white py-2 px-3 fs-6">Operario: <?php echo e($_SESSION['labtrack']['operator_name']); ?></span>
        </div>
    </div>

    <div class="row g-4">
        <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-6 col-md-4 col-lg-3">
            <a href="/center/<?php echo e($center->id); ?>/families" class="btn btn-outline-primary w-100 py-5 fs-4 shadow-sm border-2 rounded-4 transition-hover d-flex align-items-center justify-content-center text-decoration-none">
                <?php echo e($center->button_text ?: $center->name); ?>

            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-5 pt-4 border-top">
        <a href="/order" class="btn btn-secondary px-5 py-3 fs-5 shadow-sm rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<style>
    .transition-hover:hover {
        background-color: #0d6efd !important;
        color: white !important;
        transform: scale(1.05);
        box-shadow: 0 1rem 2rem rgba(13, 110, 253, 0.2) !important;
    }
    .transition-hover { transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .rounded-4 { border-radius: 1.5rem; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/templates/labtrack/station/center.blade.php ENDPATH**/ ?>