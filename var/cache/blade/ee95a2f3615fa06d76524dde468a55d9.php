<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-5 fw-bold text-center"><?php echo e($title); ?></h1>
            <p class="lead text-center text-muted">Pantalla de configuración de la aplicación.</p>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-4 col-lg-3">
            <a href="<?php echo e($me::url('users')); ?>" class="btn btn-primary w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-users fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Usuarios</span>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?php echo e($me::url('centers')); ?>" class="btn btn-primary w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-building fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Centros de costes</span>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?php echo e($me::url('families')); ?>" class="btn btn-primary w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-tags fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Familias</span>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?php echo e($me::url('processes')); ?>" class="btn btn-primary w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-cogs fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Procesos</span>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?php echo e($me::url('sequences')); ?>" class="btn btn-primary w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-list-ol fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Secuencias</span>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?php echo e($me::url('index', [], 'Main')); ?>" class="btn btn-danger w-100 py-5 shadow-sm d-flex flex-column align-items-center justify-content-center h-100">
                <i class="fas fa-sign-out-alt fa-3x mb-3"></i>
                <span class="fs-4 fw-bold">Salir</span>
            </a>
        </div>
    </div>
</div>

<style>
    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        transition: transform 0.2s, background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: #2980b9;
        transform: scale(1.05);
    }
    .btn-danger {
        transition: transform 0.2s;
    }
    .btn-danger:hover {
        transform: scale(1.05);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/templates/labtrack/config/index.blade.php ENDPATH**/ ?>