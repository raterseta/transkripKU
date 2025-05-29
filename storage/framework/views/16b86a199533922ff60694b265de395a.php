<div
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)); ?>

>
    <?php echo e($getChildComponentContainer()); ?>

</div>
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/vendor/filament/forms/src/../resources/views/components/group.blade.php ENDPATH**/ ?>