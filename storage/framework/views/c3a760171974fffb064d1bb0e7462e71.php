
<?php if (isset($component)) { $__componentOriginald489e48d6214ecaf87e4b6a8ce684ad1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald489e48d6214ecaf87e4b6a8ce684ad1 = $attributes; } ?>
<?php $component = Filament\View\LegacyComponents\Widget::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Filament\View\LegacyComponents\Widget::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4 font-poppins">
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">Baru</div>
                <div class="text-2xl font-bold"><?php echo e($this->getData()['baru']); ?></div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">Diproses</div>
                <div class="text-2xl font-bold"><?php echo e($this->getData()['diproses']); ?></div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">Revisi</div>
                <div class="text-2xl font-bold"><?php echo e($this->getData()['revisi']); ?></div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">Selesai</div>
                <div class="text-2xl font-bold"><?php echo e($this->getData()['selesai']); ?></div>
            </div>
        </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald489e48d6214ecaf87e4b6a8ce684ad1)): ?>
<?php $attributes = $__attributesOriginald489e48d6214ecaf87e4b6a8ce684ad1; ?>
<?php unset($__attributesOriginald489e48d6214ecaf87e4b6a8ce684ad1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald489e48d6214ecaf87e4b6a8ce684ad1)): ?>
<?php $component = $__componentOriginald489e48d6214ecaf87e4b6a8ce684ad1; ?>
<?php unset($__componentOriginald489e48d6214ecaf87e4b6a8ce684ad1); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\testingv2\resources\views/filament/widgets/status-pengajuan-overview.blade.php ENDPATH**/ ?>