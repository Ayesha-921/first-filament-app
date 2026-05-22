<?php if (isset($component)) { $__componentOriginal388e1416f496c833c11c2ba7d86d1f07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal388e1416f496c833c11c2ba7d86d1f07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.theme-switcher.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::theme-switcher'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal388e1416f496c833c11c2ba7d86d1f07)): ?>
<?php $attributes = $__attributesOriginal388e1416f496c833c11c2ba7d86d1f07; ?>
<?php unset($__attributesOriginal388e1416f496c833c11c2ba7d86d1f07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal388e1416f496c833c11c2ba7d86d1f07)): ?>
<?php $component = $__componentOriginal388e1416f496c833c11c2ba7d86d1f07; ?>
<?php unset($__componentOriginal388e1416f496c833c11c2ba7d86d1f07); ?>
<?php endif; ?><?php /**PATH D:\github-repository-data\first-filament-app\storage\framework\views/2d7d076b9f3ea5d9521748f9bbe5d412.blade.php ENDPATH**/ ?>