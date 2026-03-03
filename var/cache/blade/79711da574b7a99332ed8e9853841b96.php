<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-0"><?php echo e($title); ?></h1>
            <p class="text-muted">Operario: <strong><?php echo e($_SESSION['labtrack']['operator_name']); ?></strong></p>
        </div>
        <?php if (isset($component)) { $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.button','data' => ['variant' => 'outline-danger','href' => $me::url('logout'),'class' => 'shadow-sm px-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'outline-danger','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($me::url('logout')),'class' => 'shadow-sm px-4']); ?>
            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce)): ?>
<?php $attributes = $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce; ?>
<?php unset($__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce)): ?>
<?php $component = $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce; ?>
<?php unset($__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce); ?>
<?php endif; ?>
    </div>

    <?php if (isset($component)) { $__componentOriginal8057c34406d2bfd6c33945ad36163ce7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8057c34406d2bfd6c33945ad36163ce7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.card','data' => ['class' => 'shadow-sm border-0 mb-4','style' => 'border-radius: 15px;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'shadow-sm border-0 mb-4','style' => 'border-radius: 15px;']); ?>
        <h5 class="card-title mb-4">Seleccione una orden reciente o cree una nueva</h5>
        
        <div class="row g-3">
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4">
                <?php if (isset($component)) { $__componentOriginal0501b6ee18b923237233d5a4d752de33 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0501b6ee18b923237233d5a4d752de33 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::form.form','data' => ['action' => ''.e($me::url('selectCenter')).'','method' => 'POST']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => ''.e($me::url('selectCenter')).'','method' => 'POST']); ?>
                    <?php if (isset($component)) { $__componentOriginal20f6d7f3c58829f8ff5e356272a58fdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal20f6d7f3c58829f8ff5e356272a58fdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::form.hidden','data' => ['name' => 'order_id','value' => $order->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.hidden'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'order_id','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($order->id)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal20f6d7f3c58829f8ff5e356272a58fdf)): ?>
<?php $attributes = $__attributesOriginal20f6d7f3c58829f8ff5e356272a58fdf; ?>
<?php unset($__attributesOriginal20f6d7f3c58829f8ff5e356272a58fdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal20f6d7f3c58829f8ff5e356272a58fdf)): ?>
<?php $component = $__componentOriginal20f6d7f3c58829f8ff5e356272a58fdf; ?>
<?php unset($__componentOriginal20f6d7f3c58829f8ff5e356272a58fdf); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.button','data' => ['variant' => 'light','type' => 'submit','class' => 'w-100 p-4 text-start border shadow-sm transition-hover']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'light','type' => 'submit','class' => 'w-100 p-4 text-start border shadow-sm transition-hover']); ?>
                        <span class="d-block fs-5 fw-bold mb-1"><?php echo e($order->name); ?></span>
                        <small class="text-muted">ID: #<?php echo e($order->id); ?></small>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce)): ?>
<?php $attributes = $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce; ?>
<?php unset($__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce)): ?>
<?php $component = $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce; ?>
<?php unset($__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce); ?>
<?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0501b6ee18b923237233d5a4d752de33)): ?>
<?php $attributes = $__attributesOriginal0501b6ee18b923237233d5a4d752de33; ?>
<?php unset($__attributesOriginal0501b6ee18b923237233d5a4d752de33); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0501b6ee18b923237233d5a4d752de33)): ?>
<?php $component = $__componentOriginal0501b6ee18b923237233d5a4d752de33; ?>
<?php unset($__componentOriginal0501b6ee18b923237233d5a4d752de33); ?>
<?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="col-md-6 col-lg-4">
                <?php if (isset($component)) { $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.button','data' => ['variant' => 'primary','class' => 'w-100 p-4 text-center border shadow-sm transition-hover h-100 d-flex flex-column align-items-center justify-content-center','dataBsToggle' => 'modal','dataBsTarget' => '#newOrderModal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','class' => 'w-100 p-4 text-center border shadow-sm transition-hover h-100 d-flex flex-column align-items-center justify-content-center','data-bs-toggle' => 'modal','data-bs-target' => '#newOrderModal']); ?>
                    <i class="fas fa-plus fa-2x mb-2"></i>
                    <span class="fs-5 fw-bold">Nueva Orden</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce)): ?>
<?php $attributes = $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce; ?>
<?php unset($__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce)): ?>
<?php $component = $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce; ?>
<?php unset($__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce); ?>
<?php endif; ?>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8057c34406d2bfd6c33945ad36163ce7)): ?>
<?php $attributes = $__attributesOriginal8057c34406d2bfd6c33945ad36163ce7; ?>
<?php unset($__attributesOriginal8057c34406d2bfd6c33945ad36163ce7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8057c34406d2bfd6c33945ad36163ce7)): ?>
<?php $component = $__componentOriginal8057c34406d2bfd6c33945ad36163ce7; ?>
<?php unset($__componentOriginal8057c34406d2bfd6c33945ad36163ce7); ?>
<?php endif; ?>
</div>

<!-- Modal para Nueva Orden -->
<div class="modal fade" id="newOrderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nueva Orden</h5>
                <?php if (isset($component)) { $__componentOriginal274d888842123b0e8a231d50ff65c480 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal274d888842123b0e8a231d50ff65c480 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.closebutton','data' => ['dataBsDismiss' => 'modal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.closebutton'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-bs-dismiss' => 'modal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal274d888842123b0e8a231d50ff65c480)): ?>
<?php $attributes = $__attributesOriginal274d888842123b0e8a231d50ff65c480; ?>
<?php unset($__attributesOriginal274d888842123b0e8a231d50ff65c480); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal274d888842123b0e8a231d50ff65c480)): ?>
<?php $component = $__componentOriginal274d888842123b0e8a231d50ff65c480; ?>
<?php unset($__componentOriginal274d888842123b0e8a231d50ff65c480); ?>
<?php endif; ?>
            </div>
            <?php if (isset($component)) { $__componentOriginal0501b6ee18b923237233d5a4d752de33 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0501b6ee18b923237233d5a4d752de33 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::form.form','data' => ['action' => ''.e($me::url('addOrder')).'','method' => 'POST']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => ''.e($me::url('addOrder')).'','method' => 'POST']); ?>
                <div class="modal-body p-4">
                    <?php if (isset($component)) { $__componentOriginal5c2a97ab476b69c1189ee85d1a95204b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c2a97ab476b69c1189ee85d1a95204b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::form.input','data' => ['name' => 'name','class' => 'form-control-lg','required' => true,'placeholder' => 'Ej: Pedido #452 / Paciente X','label' => $me->_('order_name_reference')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'name','class' => 'form-control-lg','required' => true,'placeholder' => 'Ej: Pedido #452 / Paciente X','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($me->_('order_name_reference'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c2a97ab476b69c1189ee85d1a95204b)): ?>
<?php $attributes = $__attributesOriginal5c2a97ab476b69c1189ee85d1a95204b; ?>
<?php unset($__attributesOriginal5c2a97ab476b69c1189ee85d1a95204b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c2a97ab476b69c1189ee85d1a95204b)): ?>
<?php $component = $__componentOriginal5c2a97ab476b69c1189ee85d1a95204b; ?>
<?php unset($__componentOriginal5c2a97ab476b69c1189ee85d1a95204b); ?>
<?php endif; ?>
                </div>
                <div class="modal-footer border-0">
                    <?php if (isset($component)) { $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.button','data' => ['variant' => 'light','class' => 'px-4','dataBsDismiss' => 'modal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'light','class' => 'px-4','data-bs-dismiss' => 'modal']); ?>Cancelar <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce)): ?>
<?php $attributes = $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce; ?>
<?php unset($__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce)): ?>
<?php $component = $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce; ?>
<?php unset($__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.button','data' => ['variant' => 'primary','type' => 'submit','class' => 'px-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','type' => 'submit','class' => 'px-4']); ?>Crear y Continuar <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce)): ?>
<?php $attributes = $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce; ?>
<?php unset($__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce)): ?>
<?php $component = $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce; ?>
<?php unset($__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce); ?>
<?php endif; ?>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0501b6ee18b923237233d5a4d752de33)): ?>
<?php $attributes = $__attributesOriginal0501b6ee18b923237233d5a4d752de33; ?>
<?php unset($__attributesOriginal0501b6ee18b923237233d5a4d752de33); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0501b6ee18b923237233d5a4d752de33)): ?>
<?php $component = $__componentOriginal0501b6ee18b923237233d5a4d752de33; ?>
<?php unset($__componentOriginal0501b6ee18b923237233d5a4d752de33); ?>
<?php endif; ?>
        </div>
    </div>
</div>

<style>
    .transition-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        border-color: #0d6efd !important;
    }
    .transition-hover { transition: all 0.2s ease; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/templates/labtrack/station/order.blade.php ENDPATH**/ ?>