<?php $__env->startSection('content'); ?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <?php if (isset($component)) { $__componentOriginal8057c34406d2bfd6c33945ad36163ce7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8057c34406d2bfd6c33945ad36163ce7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.card','data' => ['class' => 'shadow-lg border-0','style' => 'width: 100%; max-width: 400px; border-radius: 20px;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'shadow-lg border-0','style' => 'width: 100%; max-width: 400px; border-radius: 20px;']); ?>
        <div class="p-5 text-center">
            <div class="mb-4">
                <i class="fas fa-microscope fa-4x text-primary mb-3"></i>
                <h2 class="fw-bold"><?php echo e($me->_('station_identification')); ?></h2>
                <p class="text-muted">Introduce tu PIN para comenzar</p>
            </div>

            <?php if(isset($error)): ?>
                <?php if (isset($component)) { $__componentOriginal7337bea1b45f72099b8ed00caf65209e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7337bea1b45f72099b8ed00caf65209e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.alert','data' => ['type' => 'danger','class' => 'mb-4 py-2 small']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger','class' => 'mb-4 py-2 small']); ?>
                    <?php echo e($error); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7337bea1b45f72099b8ed00caf65209e)): ?>
<?php $attributes = $__attributesOriginal7337bea1b45f72099b8ed00caf65209e; ?>
<?php unset($__attributesOriginal7337bea1b45f72099b8ed00caf65209e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7337bea1b45f72099b8ed00caf65209e)): ?>
<?php $component = $__componentOriginal7337bea1b45f72099b8ed00caf65209e; ?>
<?php unset($__componentOriginal7337bea1b45f72099b8ed00caf65209e); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal0501b6ee18b923237233d5a4d752de33 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0501b6ee18b923237233d5a4d752de33 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::form.form','data' => ['action' => '/login','method' => 'POST','id' => 'pinForm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => '/login','method' => 'POST','id' => 'pinForm']); ?>
                <?php if (isset($component)) { $__componentOriginal5c2a97ab476b69c1189ee85d1a95204b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c2a97ab476b69c1189ee85d1a95204b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::form.input','data' => ['type' => 'password','name' => 'pin','id' => 'pinInput','class' => 'text-center mb-4 tracking-widest fw-bold border-0 bg-light','placeholder' => '••••','maxlength' => '10','readonly' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'password','name' => 'pin','id' => 'pinInput','class' => 'text-center mb-4 tracking-widest fw-bold border-0 bg-light','placeholder' => '••••','maxlength' => '10','readonly' => true]); ?>
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
                
                <div class="row g-2 mb-4">
                    <?php for($i = 1; $i <= 9; $i++): ?>
                    <div class="col-4">
                        <?php if (isset($component)) { $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.button','data' => ['variant' => 'light','class' => 'w-100 py-3 fs-3 rounded-4 pin-btn border shadow-sm','dataVal' => ''.e($i).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'light','class' => 'w-100 py-3 fs-3 rounded-4 pin-btn border shadow-sm','data-val' => ''.e($i).'']); ?>
                            <?php echo e($i); ?>

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
                    <?php endfor; ?>
                    <div class="col-4">
                        <?php if (isset($component)) { $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.button','data' => ['variant' => 'danger','class' => 'w-100 py-3 rounded-4 pin-btn d-flex flex-column align-items-center justify-content-center h-100 shadow-sm','dataVal' => 'C']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'danger','class' => 'w-100 py-3 rounded-4 pin-btn d-flex flex-column align-items-center justify-content-center h-100 shadow-sm','data-val' => 'C']); ?>
                            <i class="fas fa-backspace mb-1"></i>
                            <small class="fw-bold text-uppercase" style="font-size: 0.65rem;"><?php echo e($me->_('clear')); ?></small>
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
                    <div class="col-4">
                        <?php if (isset($component)) { $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.button','data' => ['variant' => 'light','class' => 'w-100 py-4 fs-4 rounded-4 pin-btn border shadow-sm','dataVal' => '0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'light','class' => 'w-100 py-4 fs-4 rounded-4 pin-btn border shadow-sm','data-val' => '0']); ?>
                            0
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
                    <div class="col-4">
                        <?php if (isset($component)) { $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8079edf3a53116f6e1e206a526781189::component.button','data' => ['variant' => 'primary','type' => 'submit','class' => 'w-100 py-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','type' => 'submit','class' => 'w-100 py-3 rounded-4 d-flex flex-column align-items-center justify-content-center h-100']); ?>
                            <i class="fas fa-check mb-1"></i>
                            <small class="fw-bold text-uppercase" style="font-size: 0.65rem;"><?php echo e($me->_('enter')); ?></small>
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
<?php if (isset($__attributesOriginal0501b6ee18b923237233d5a4d752de33)): ?>
<?php $attributes = $__attributesOriginal0501b6ee18b923237233d5a4d752de33; ?>
<?php unset($__attributesOriginal0501b6ee18b923237233d5a4d752de33); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0501b6ee18b923237233d5a4d752de33)): ?>
<?php $component = $__componentOriginal0501b6ee18b923237233d5a4d752de33; ?>
<?php unset($__componentOriginal0501b6ee18b923237233d5a4d752de33); ?>
<?php endif; ?>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('pinInput');
    const btns = document.querySelectorAll('.pin-btn');

    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            const val = btn.getAttribute('data-val');
            if (val === 'C') {
                input.value = input.value.slice(0, -1);
            } else {
                if (input.value.length < 10) {
                    input.value += val;
                }
            }
        });
    });
});
</script>

<style>
    #pinInput { letter-spacing: 0.5rem; font-size: 2rem; box-shadow: none !important; }
    .pin-btn:active { background-color: #0d6efd !important; color: white !important; }
    .tracking-widest { letter-spacing: 0.5em; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/templates/labtrack/station/login.blade.php ENDPATH**/ ?>