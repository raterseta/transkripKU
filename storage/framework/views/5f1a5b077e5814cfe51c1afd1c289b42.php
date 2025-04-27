<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>TranskripKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body class="h-full">
    <div>
        <?php if(auth()->guard()->check()): ?>
            <?php if (isset($component)) { $__componentOriginalf2d127ec02acb2fe16e0bd0cf86744e3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf2d127ec02acb2fe16e0bd0cf86744e3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar-admin','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar-admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf2d127ec02acb2fe16e0bd0cf86744e3)): ?>
<?php $attributes = $__attributesOriginalf2d127ec02acb2fe16e0bd0cf86744e3; ?>
<?php unset($__attributesOriginalf2d127ec02acb2fe16e0bd0cf86744e3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf2d127ec02acb2fe16e0bd0cf86744e3)): ?>
<?php $component = $__componentOriginalf2d127ec02acb2fe16e0bd0cf86744e3; ?>
<?php unset($__componentOriginalf2d127ec02acb2fe16e0bd0cf86744e3); ?>
<?php endif; ?>
        <?php endif; ?>

        <?php if(auth()->guard()->guest()): ?>
            <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
        <?php endif; ?>
        
        <main class="justify-center flex items-center bg-[url('/public/images/filkom-50.png')] bg-[center_30%] h-full">
            <div class="flex flex-col items-center text-center py-36 space-y-3">
                <!-- Text Halaman -->
                <p class="font-poppins text-xl">Selamat Datang di Website</p>
                <h1 class="font-poppins font-bold text-4xl">TranskripKU</h1>

                <!-- Group Track dan Pengajuan -->
                <div class="flex flex-row space-x-20 py-16">
                    <a href="<?php echo e(url('/pengajuan-final')); ?>" class="shadow-md shadow-black/50 mx-auto box-content bg-orange-500 h-10 rounded-2xl flex items-center justify-center">
                        <button class="px-2">Lakukan Pengajuan Final</button>
                    </a>
                    <a href="<?php echo e(url('/pengajuan')); ?>" class="text-lg mx-auto box-content bg-orange-500 h-10 flex rounded-2xl flex items-center justify-center shadow-md shadow-black/50">
                        <button class="px-5">Lakukan Pengajuan</button>
                    </a>
                </div>
            </div>
        </main>
    </div>
    <?php if (isset($component)) { $__componentOriginalae25fe17d93ff9f3b32915f9d9addc74 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae25fe17d93ff9f3b32915f9d9addc74 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar-footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar-footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae25fe17d93ff9f3b32915f9d9addc74)): ?>
<?php $attributes = $__attributesOriginalae25fe17d93ff9f3b32915f9d9addc74; ?>
<?php unset($__attributesOriginalae25fe17d93ff9f3b32915f9d9addc74); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae25fe17d93ff9f3b32915f9d9addc74)): ?>
<?php $component = $__componentOriginalae25fe17d93ff9f3b32915f9d9addc74; ?>
<?php unset($__componentOriginalae25fe17d93ff9f3b32915f9d9addc74); ?>
<?php endif; ?>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\testingv2\resources\views/home.blade.php ENDPATH**/ ?>