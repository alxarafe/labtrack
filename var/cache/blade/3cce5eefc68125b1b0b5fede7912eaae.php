<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Order Header Info -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 text-primary">
                            <i class="fas fa-file-invoice me-2"></i><?php echo e($me->_('order')); ?>: <?php echo e($order->id); ?>

                        </h2>
                        <span class="text-muted fs-5"><?php echo e($order->nombre); ?></span>
                    </div>
                    <div>
                        <a href="<?php echo e($me::url('index')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-search me-1"></i><?php echo e($me->_('search_another')); ?>

                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Production Selection Grid -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tasks me-2"></i><?php echo e($me->_('new_record')); ?>

                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Cost Centers -->
                        <div class="col-md-3">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><?php echo e($me->_('cost_centers')); ?></h6>
                            <div class="d-grid gap-2 overflow-auto" style="max-height: 300px;">
                                <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($me::url('index', ['order' => $order->id, 'center' => $center->id])); ?>" 
                                       class="btn <?php echo e($centerId == $center->id ? 'btn-primary' : 'btn-outline-primary'); ?> text-start">
                                        <?php echo e($center->nombre_boton ?: $center->nombre); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Families -->
                        <div class="col-md-3">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><?php echo e($me->_('families')); ?></h6>
                            <div class="d-grid gap-2 overflow-auto" style="max-height: 300px;">
                                <?php $__currentLoopData = $families; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $family): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($me::url('index', ['order' => $order->id, 'center' => $centerId, 'family' => $family->id])); ?>" 
                                       class="btn <?php echo e($familyId == $family->id ? 'btn-info text-white' : 'btn-outline-info'); ?> text-start">
                                        <?php echo e($family->nombre_boton ?: $family->nombre); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(empty($families) && $centerId): ?>
                                    <div class="alert alert-secondary small"><?php echo e($me->_('no_families_found')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Processes -->
                        <div class="col-md-3">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><?php echo e($me->_('processes')); ?></h6>
                            <div class="d-grid gap-2 overflow-auto" style="max-height: 300px;">
                                <?php $__currentLoopData = $processes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $process): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($me::url('index', ['order' => $order->id, 'center' => $centerId, 'family' => $familyId, 'process' => $process->id])); ?>" 
                                       class="btn <?php echo e($processId == $process->id ? 'btn-warning text-white' : 'btn-outline-warning'); ?> text-start">
                                        <?php echo e($process->nombre_boton ?: $process->nombre); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Sequences -->
                        <div class="col-md-3">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><?php echo e($me->_('sequences')); ?></h6>
                            <div class="d-grid gap-2 overflow-auto" style="max-height: 300px;">
                                <?php $__currentLoopData = $sequences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sequence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button class="btn btn-outline-success text-start" 
                                            onclick="confirmRecord(<?php echo e($sequence->id); ?>, '<?php echo e($sequence->nombre); ?>', <?php echo e($sequence->duracion); ?>)">
                                        <?php echo e($sequence->nombre_boton ?: $sequence->nombre); ?>

                                        <?php if($sequence->duracion > 0): ?>
                                            <span class="badge bg-success float-end"><?php echo e($sequence->duracion); ?>'</span>
                                        <?php endif; ?>
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Movements List -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i><?php echo e($me->_('production_history')); ?>

                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?php echo e($me->_('date')); ?></th>
                                    <th><?php echo e($me->_('sequence')); ?></th>
                                    <th><?php echo e($me->_('units')); ?></th>
                                    <th><?php echo e($me->_('duration')); ?></th>
                                    <th><?php echo e($me->_('operator')); ?></th>
                                    <th><?php echo e($me->_('status')); ?></th>
                                    <th class="text-end"><?php echo e($me->_('actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e(\Carbon\Carbon::parse($movement->hora)->format('d/m/Y H:i')); ?></td>
                                        <td>
                                            <strong><?php echo e($movement->sequence->nombre ?? $movement->id_secuencia); ?></strong>
                                        </td>
                                        <td><?php echo e($movement->unidades); ?></td>
                                        <td><?php echo e($movement->duracion); ?>'</td>
                                        <td><?php echo e($movement->operator->username ?? $movement->id_operador); ?></td>
                                        <td>
                                            <?php if($movement->supervisado > 0): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i><?php echo e($me->_('verified')); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i><?php echo e($me->_('pending')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-secondary" title="<?php echo e($me->_('edit')); ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                            <?php echo e($me->_('no_movements_found')); ?>

                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Recording Movement -->
<div class="modal fade" id="recordModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?php echo e($me::url('addRecord')); ?>" method="POST">
            <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
            <input type="hidden" name="center_id" value="<?php echo e($centerId); ?>">
            <input type="hidden" name="family_id" value="<?php echo e($familyId); ?>">
            <input type="hidden" name="process_id" value="<?php echo e($processId); ?>">
            <input type="hidden" name="sequence_id" id="modal_sequence_id">
            
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><?php echo e($me->_('confirm_record')); ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h4 id="modal_sequence_name" class="text-center mb-4"></h4>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label"><?php echo e($me->_('units')); ?></label>
                            <input type="number" name="units" class="form-control" value="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label"><?php echo e($me->_('duration')); ?> (min)</label>
                            <input type="number" name="duration" id="modal_duration" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label"><?php echo e($me->_('notes')); ?></label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e($me->_('cancel')); ?></button>
                    <button type="submit" class="btn btn-success"><?php echo e($me->_('save')); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function confirmRecord(id, name, duration) {
    document.getElementById('modal_sequence_id').value = id;
    document.getElementById('modal_sequence_name').innerText = name;
    document.getElementById('modal_duration').value = duration;
    new bootstrap.Modal(document.getElementById('recordModal')).show();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/templates/labtrack/order/edit.blade.php ENDPATH**/ ?>