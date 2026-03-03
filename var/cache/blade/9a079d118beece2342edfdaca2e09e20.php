<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Filter Sidebar/Header -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="<?php echo e($me::url('user')); ?>" method="POST" class="row g-3 align-items-end">
                        <?php if(!empty($users)): ?>
                            <div class="col-md-3">
                                <label class="form-label fw-bold"><?php echo e($me->_('select_user')); ?></label>
                                <select name="user_id" class="form-select">
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>" <?php echo e($userId == $user->id ? 'selected' : ''); ?>>
                                            <?php echo e($user->username); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="user_id" value="<?php echo e($userId); ?>">
                        <?php endif; ?>

                        <div class="col-md-3">
                            <label class="form-label fw-bold"><?php echo e($me->_('date_from')); ?></label>
                            <input type="date" name="date_from" class="form-control" value="<?php echo e($dateFrom); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold"><?php echo e($me->_('date_to')); ?></label>
                            <input type="date" name="date_to" class="form-control" value="<?php echo e($dateTo); ?>">
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" name="accept" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-search me-1"></i><?php echo e($me->_('accept')); ?>

                            </button>
                            <a href="<?php echo e($me::url('index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if(!empty($report)): ?>
            <!-- Summary Stats -->
            <?php
                $totalUnits = $report->sum('unidades');
                $totalDuration = $report->sum('duracion');
                $avgDuration = $totalUnits > 0 ? round($totalDuration / $totalUnits, 1) : 0;
            ?>
            <div class="col-12 mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white border-0 shadow-sm">
                            <div class="card-body py-4">
                                <h6 class="text-uppercase mb-2"><?php echo e($me->_('total_units')); ?></h6>
                                <h2 class="mb-0"><?php echo e($totalUnits); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white border-0 shadow-sm">
                            <div class="card-body py-4">
                                <h6 class="text-uppercase mb-2"><?php echo e($me->_('total_duration')); ?></h6>
                                <h2 class="mb-0"><?php echo e($totalDuration); ?> min</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white border-0 shadow-sm">
                            <div class="card-body py-4">
                                <h6 class="text-uppercase mb-2"><?php echo e($me->_('avg_duration')); ?></h6>
                                <h2 class="mb-0"><?php echo e($avgDuration); ?> min</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Table -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i><?php echo e($me->_('production_summary')); ?>

                        </h5>
                        <button class="btn btn-sm btn-outline-success">
                            <i class="fas fa-file-export me-1"></i><?php echo e($me->_('export')); ?>

                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th><?php echo e($me->_('date')); ?></th>
                                        <th><?php echo e($me->_('order')); ?></th>
                                        <th><?php echo e($me->_('sequence')); ?> / <?php echo e($me->_('process')); ?></th>
                                        <th><?php echo e($me->_('units')); ?></th>
                                        <th><?php echo e($me->_('duration')); ?></th>
                                        <th><?php echo e($me->_('status')); ?></th>
                                        <th class="text-end"><?php echo e($me->_('actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(\Carbon\Carbon::parse($movement->hora)->format('d/m/Y H:i')); ?></td>
                                            <td>
                                                <a href="<?php echo e($me::url('LabTrack.Order.index', ['order' => $movement->id_orden])); ?>" class="text-decoration-none fw-bold">
                                                    <?php echo e($movement->id_orden); ?>

                                                </a>
                                            </td>
                                            <td>
                                                <div><?php echo e($movement->sequence->nombre ?? $movement->id_secuencia); ?></div>
                                                <small class="text-muted"><?php echo e($movement->process->nombre ?? ''); ?></small>
                                            </td>
                                            <td><?php echo e($movement->unidades); ?></td>
                                            <td><?php echo e($movement->duracion); ?>'</td>
                                            <td>
                                                <?php if($movement->supervisado > 0): ?>
                                                    <span class="badge bg-success"><?php echo e($me->_('verified')); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark"><?php echo e($me->_('pending')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <?php if(!$movement->supervisado && \Alxarafe\Lib\Auth::$user->is_supervisor): ?>
                                                    <a href="<?php echo e($me::url('validate', ['id' => $movement->id])); ?>" class="btn btn-sm btn-success">
                                                        <?php echo e($me->_('validate')); ?>

                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif(isset($_POST['accept'])): ?>
            <div class="col-12 text-center py-5">
                <div class="alert alert-secondary">
                    <?php echo e($me->_('no_data_found')); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/templates/labtrack/report/user.blade.php ENDPATH**/ ?>