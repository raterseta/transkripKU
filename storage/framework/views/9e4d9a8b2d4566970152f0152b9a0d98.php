<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?> 
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4 text-black w-full">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 sm:p-8 text-black">
        <div class="text-center mb-6">
            <a href="/">
                <img src="/images/login.png" alt="Logo Fakultas" class="h-6 mx-auto mb-4">
            </a>
            <h1 class="text-2xl font-semibold">Sign in</h1>
        </div>

        <form wire:submit.prevent="authenticate" class="space-y-8">
            <div class="space-y-4 text-black">
                <?php echo e($this->form); ?>


                <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['type' => 'submit','class' => 'w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold flex items-center justify-center gap-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold flex items-center justify-center gap-2']); ?>
                    <p class="text-white" wire:loading.remove wire:target="authenticate">Login</p>
                    <p class="text-white" wire:loading wire:target="authenticate">Loading...</p>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>

                <p class="font-poppins text-sm font-medium text-center">
                    Back to <a href="/" class="text-blue-500 hover:underline">Home</a>?
                </p>
            </div>
        </form>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\transkripKU\resources\views/filament/pages/custom-login.blade.php ENDPATH**/ ?>