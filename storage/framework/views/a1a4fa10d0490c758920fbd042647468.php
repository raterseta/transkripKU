<?php
    $urgencyIcon = match (true) {
        $isOverdue => 'heroicon-o-exclamation-triangle',
        $isUrgent => 'heroicon-o-clock',
        default => 'heroicon-o-check-circle'
    };
?>

<div class="space-y-2">
    
    <div class="flex items-center gap-2">
        <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $urgencyIcon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-'.e($statusColor).'-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
        <span class="text-sm font-medium text-<?php echo e($statusColor); ?>-500">
            <?php echo e($statusText); ?>

        </span>
    </div>

    
    <div class="bg-<?php echo e($statusColor); ?>-50 dark:bg-<?php echo e($statusColor); ?>-500/10 rounded-lg p-3">
        <div class="space-y-1">
            
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500 dark:text-gray-400">Estimasi Selesai:</span>
                <span class="text-sm font-medium"><?php echo e($estimatedCompletion); ?></span>
            </div>

            
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500 dark:text-gray-400">Sisa Waktu:</span>
                <span class="text-sm font-medium text-<?php echo e($statusColor); ?>-600 dark:text-<?php echo e($statusColor); ?>-400">
                    <!--[if BLOCK]><![endif]--><?php if($isOverdue): ?>
                        Terlambat <?php echo e($remainingDays); ?> hari
                    <?php else: ?>
                        <?php echo e($remainingDays); ?> hari lagi
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </span>
            </div>

            
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500 dark:text-gray-400">Durasi Pengajuan:</span>
                <span class="text-sm font-medium">
                    <?php echo e($durationDays); ?> hari <?php echo e($durationHours); ?> jam
                </span>
            </div>
        </div>
    </div>

    
    <!--[if BLOCK]><![endif]--><?php if($isUrgent || $isOverdue): ?>
        <div class="mt-2 text-sm text-<?php echo e($statusColor); ?>-600 dark:text-<?php echo e($statusColor); ?>-400">
            <!--[if BLOCK]><![endif]--><?php if($isOverdue): ?>
                ⚠️ Pengajuan ini sudah melewati batas waktu pengerjaan!
            <?php elseif($isUrgent): ?>
                ⚠️ Pengajuan ini membutuhkan perhatian segera!
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/filament/components/enhanced-deadline-info.blade.php ENDPATH**/ ?>