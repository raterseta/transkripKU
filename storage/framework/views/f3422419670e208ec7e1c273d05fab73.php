<div class="space-y-2">
    <div class="flex items-center justify-between">
        <span class="text-sm font-medium text-gray-600">Diajukan:</span>
        <span class="text-sm <?php echo e($durationDays > 3 ? 'text-danger-600' : 'text-gray-600'); ?> font-medium">
            <?php if($durationDays > 0): ?><?php echo e($durationDays); ?> hari <?php endif; ?><!--[if ENDBLOCK]><![endif]--> <!--[if BLOCK]><![endif]--><?php if($durationHours > 0): ?><?php echo e($durationHours); ?> jam <?php endif; ?><!--[if ENDBLOCK]><![endif]--> yang lalu
        </span>
    </div>

    <div class="flex items-center justify-between">
        <span class="text-sm font-medium text-gray-600">Estimasi Selesai:</span>
        <span class="text-sm <?php echo e($isOverdue ? 'text-danger-600' : 'text-gray-900'); ?> font-medium">
            <?php echo e($estimatedCompletion); ?>

        </span>
    </div>

    <!--[if BLOCK]><![endif]--><?php if(!$isOverdue): ?>
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-600">Sisa Waktu:</span>
            <span class="text-sm <?php echo e($remainingDays <= 1 ? 'text-danger-600' : 'text-gray-900'); ?> font-medium">
                <?php echo e($remainingDays); ?> hari tersisa
            </span>
        </div>
    <?php else: ?>
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-600">Keterlambatan:</span>
            <span class="text-sm text-danger-600 font-medium">
                <?php echo e(abs($remainingDays)); ?> hari
            </span>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/filament/components/deadline-info.blade.php ENDPATH**/ ?>