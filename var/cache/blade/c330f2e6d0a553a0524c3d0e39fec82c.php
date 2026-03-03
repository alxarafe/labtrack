<!DOCTYPE html>
<html lang="<?php echo $me->config->main->language ?? 'en'; ?>">
<head>
    <title><?php echo $me->title; ?></title>
    <?php echo $__env->make('partial.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="container">
    <!-- Header handled by Top Bar -->
    <!-- Header handled by Body Templates -->
    <?php if($empty ?? false): ?>
        <?php echo $__env->make('partial.body_empty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('partial.body_standard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php echo $__env->make('partial.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /var/www/alxarafe/templates/partial/layout/main.blade.php ENDPATH**/ ?>