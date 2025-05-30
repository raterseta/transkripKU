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
<body class="h-full font-poppins" x-data="{ showPopup: false }">
    <div>
        <?php if (isset($component)) { $__componentOriginal49a931dfd920b9ebcc8382452462cef9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49a931dfd920b9ebcc8382452462cef9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar-home','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar-home'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49a931dfd920b9ebcc8382452462cef9)): ?>
<?php $attributes = $__attributesOriginal49a931dfd920b9ebcc8382452462cef9; ?>
<?php unset($__attributesOriginal49a931dfd920b9ebcc8382452462cef9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49a931dfd920b9ebcc8382452462cef9)): ?>
<?php $component = $__componentOriginal49a931dfd920b9ebcc8382452462cef9; ?>
<?php unset($__componentOriginal49a931dfd920b9ebcc8382452462cef9); ?>
<?php endif; ?>

        <!-- Section Utama -->
        <main class="flex items-center justify-center bg-[url('/public/images/filkom-50.png')] bg-cover bg-center min-h-screen px-4">
            <div class="text-center max-w-2xl w-full py-20 sm:py-10 space-y-1 rounded-xl">

                <!-- Judul dan Subjudul -->
                <div class="flex flex-col space-y-2 lg:space-y-5">
                    <p class="pt-8 text-base font-semibold font-poppins sm:text-3xl text-gray-900">Selamat Datang di Website</p>
                    <h1 class="text-3xl sm:text-5xl font-bold font-poppins text-gray-900">TranskripKU</h1>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8 sm:pt-10 lg:pt-32 pt-10">
                    <a href="<?php echo e(url('/pengajuan-final')); ?>" class="w-full sm:w-auto">
                        <button class="w-1/2 sm:w-full max-w-3/4 sm:min-w-[200px] px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl shadow shadow-black/30 transition">
                            Lakukan Pengajuan Final
                        </button>
                    </a>

                    <a href="<?php echo e(url('/pengajuan')); ?>" class="w-full sm:w-auto">
                        <button class="w-1/2 sm:w-full max-w-3/4 sm:min-w-[200px] px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl shadow shadow-black/30 transition">
                            Lakukan Pengajuan
                        </button>
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
<?php /**PATH C:\xampp\htdocs\transkripKU\resources\views/home.blade.php ENDPATH**/ ?>