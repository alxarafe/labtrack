

<?php $__currentLoopData = $me->alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="alert alert-<?php echo $alert['type']; ?>" role="alert">
        <?php echo $alert['text']; ?>

    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/alxarafe/templates/partial/alerts.blade.php ENDPATH**/ ?>