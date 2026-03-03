<?php $__env->startSection('content'); ?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <?php if (isset($component)) { $__componentOriginal8057c34406d2bfd6c33945ad36163ce7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8057c34406d2bfd6c33945ad36163ce7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '1acd7488fb14a1c7746cb8b35f14aadd::component.card','data' => ['class' => 'shadow-lg border-0','style' => 'width: 100%; max-width: 450px; border-radius: 20px;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'shadow-lg border-0','style' => 'width: 100%; max-width: 450px; border-radius: 20px;']); ?>
        <div class="p-4 text-center">
            <div class="mb-4">
                <i class="fas fa-user-shield fa-4x text-primary mb-3"></i>
                <h2 class="fw-bold"><?php echo e($me->_('administration_access')); ?></h2>
                <p class="text-muted"><?php echo e($me->_('please_enter_credentials')); ?></p>
            </div>

            <?php if (isset($component)) { $__componentOriginal0501b6ee18b923237233d5a4d752de33 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0501b6ee18b923237233d5a4d752de33 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '1acd7488fb14a1c7746cb8b35f14aadd::form.form','data' => ['method' => 'POST','action' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['method' => 'POST','action' => '']); ?>
                <input type="hidden" name="action" value="login">
                
                <div class="text-start">
                    <?php if (isset($component)) { $__componentOriginal5c2a97ab476b69c1189ee85d1a95204b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c2a97ab476b69c1189ee85d1a95204b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '1acd7488fb14a1c7746cb8b35f14aadd::form.input','data' => ['name' => 'username','label' => $me->_('login_name'),'placeholder' => 'admin','required' => true,'class' => 'form-control-lg mb-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'username','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($me->_('login_name')),'placeholder' => 'admin','required' => true,'class' => 'form-control-lg mb-3']); ?>
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
                    
                    <?php if (isset($component)) { $__componentOriginal5c2a97ab476b69c1189ee85d1a95204b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c2a97ab476b69c1189ee85d1a95204b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '1acd7488fb14a1c7746cb8b35f14aadd::form.input','data' => ['type' => 'password','name' => 'password','label' => $me->_('login_password'),'placeholder' => '••••••••','required' => true,'class' => 'form-control-lg mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'password','name' => 'password','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($me->_('login_password')),'placeholder' => '••••••••','required' => true,'class' => 'form-control-lg mb-4']); ?>
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

                <div class="d-grid mt-2">
                    <?php if (isset($component)) { $__componentOriginal5fdb3ddb6f48af634ffa7876751c05ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fdb3ddb6f48af634ffa7876751c05ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '1acd7488fb14a1c7746cb8b35f14aadd::component.button','data' => ['variant' => 'primary','type' => 'submit','class' => 'btn-lg rounded-pill py-3 fw-bold shadow-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','type' => 'submit','class' => 'btn-lg rounded-pill py-3 fw-bold shadow-sm']); ?>
                        <i class="fas fa-sign-in-alt me-2"></i><?php echo e($me->_('login_button')); ?>

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

<style>
    body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
    .card { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.9) !important; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- Prueba de script -->
<?php $__env->stopPush(); ?>

<?php echo $__env->make('partial.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/alxarafe/src/Modules/Admin/Templates/page/login.blade.php ENDPATH**/ ?>