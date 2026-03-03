<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4"><?php echo e($title); ?></h1>
        <p class="lead"><?php echo e($message); ?></p>
        <hr class="my-4">
        <p>Este es el punto de partida de la nueva versión de LabTrack basada en el Alxarafe Microframework.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Comenzar</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/templates/labtrack/index.blade.php ENDPATH**/ ?>