<div
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)); ?>

>
    <?php echo e($getChildSchema()); ?>

</div>
<?php /**PATH D:\github-repository-data\first-filament-app\vendor\filament\schemas\resources\views/components/grid.blade.php ENDPATH**/ ?>