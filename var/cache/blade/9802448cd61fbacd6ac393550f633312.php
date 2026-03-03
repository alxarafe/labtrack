<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col d-flex align-items-center">
            <a href="<?php echo e($me::url('index')); ?>" class="btn btn-outline-secondary me-3 shadow-sm" title="<?php echo e($me->_('back')); ?>">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="display-6 fw-bold mb-0"><i class="fas fa-tags me-2"></i><?php echo e($title); ?></h1>
        </div>
    </div>

    <form action="<?php echo e($me::url('saveFamilies')); ?>" method="POST">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="familiesTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th style="width: 100px;">Orden</th>
                                <th>Centro de Coste</th>
                                <th>Nombre</th>
                                <th>Texto Botón</th>
                                <th class="text-center" style="width: 120px;">Desactivado</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $families; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $family): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="text" name="id[]" class="form-control text-center" value="<?php echo e($family->id); ?>" readonly>
                                </td>
                                <td>
                                    <input type="number" name="sort_order[]" class="form-control text-center" value="<?php echo e($family->sort_order); ?>" required>
                                </td>
                                <td>
                                    <select name="cost_center_id[]" class="form-select" required>
                                        <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($center->id); ?>" <?php echo e($family->cost_center_id == $center->id ? 'selected' : ''); ?>>
                                            <?php echo e($center->name); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="name[]" class="form-control" value="<?php echo e($family->name); ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="button_text[]" class="form-control" value="<?php echo e($family->button_text); ?>" placeholder="<?php echo e($family->name); ?>">
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-check-inline text-danger">
                                        <input class="form-check-input border-danger" type="checkbox" name="off[]" value="1" <?php echo e(!$family->active ? 'checked' : ''); ?>>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-link text-danger p-0 delete-row">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <div>
                <button type="button" id="addRow" class="btn btn-info text-white shadow-sm px-4 py-2">
                    <i class="fas fa-plus me-2"></i>Nueva línea
                </button>
            </div>
            <div>
                <button type="submit" name="guardar" class="btn btn-success shadow-sm px-5 py-2 me-2">
                    <i class="fas fa-check me-2"></i>Aceptar
                </button>
                <a href="<?php echo e($me::url('index')); ?>" class="btn btn-secondary shadow-sm px-4 py-2">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<template id="familyRowTemplate">
    <tr>
        <td>
            <input type="text" name="id[]" class="form-control text-center" value="0" readonly>
        </td>
        <td>
            <input type="number" name="sort_order[]" class="form-control text-center" value="0" required>
        </td>
        <td>
            <select name="cost_center_id[]" class="form-select" required>
                <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($center->id); ?>"><?php echo e($center->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </td>
        <td>
            <input type="text" name="name[]" class="form-control" value="" required>
        </td>
        <td>
            <input type="text" name="button_text[]" class="form-control" value="" placeholder="Nombre del botón">
        </td>
        <td class="text-center">
            <div class="form-check form-check-inline text-danger">
                <input class="form-check-input border-danger" type="checkbox" name="off[]" value="1">
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-link text-danger p-0 delete-row">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#familiesTable tbody');
    const template = document.getElementById('familyRowTemplate');

    document.getElementById('addRow').addEventListener('click', function() {
        const clone = template.content.cloneNode(true);
        tableBody.appendChild(clone);
    });

    tableBody.addEventListener('click', function(e) {
        if (e.target.closest('.delete-row')) {
            if (confirm('¿Está seguro de que desea eliminar esta fila?')) {
                e.target.closest('tr').remove();
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/templates/labtrack/config/families.blade.php ENDPATH**/ ?>