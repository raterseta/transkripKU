<?php
    $colors = [
        'success' => 'bg-success-100 text-success-800',
        'danger' => 'bg-danger-100 text-danger-800',
        'primary' => 'bg-primary-100 text-primary-800',
    ];
?>

<span class="px-2.5 py-0.5 rounded-full text-sm font-medium <?php echo e($colors[$color]); ?>">
    <?php echo e($status); ?>

</span>
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/filament/components/status-badge.blade.php ENDPATH**/ ?>