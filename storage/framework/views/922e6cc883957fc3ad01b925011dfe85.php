<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <title>TranskripKU</title>
</head>
<body class="h-full">
  <div>
    <?php if(auth()->guard()->check()): ?>
      <?php if (isset($component)) { $__componentOriginalf8e8619fe27f97c53f4483db89dfb243 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8e8619fe27f97c53f4483db89dfb243 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar-admin-notrack','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar-admin-notrack'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8e8619fe27f97c53f4483db89dfb243)): ?>
<?php $attributes = $__attributesOriginalf8e8619fe27f97c53f4483db89dfb243; ?>
<?php unset($__attributesOriginalf8e8619fe27f97c53f4483db89dfb243); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8e8619fe27f97c53f4483db89dfb243)): ?>
<?php $component = $__componentOriginalf8e8619fe27f97c53f4483db89dfb243; ?>
<?php unset($__componentOriginalf8e8619fe27f97c53f4483db89dfb243); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if(auth()->guard()->guest()): ?>
       <?php if (isset($component)) { $__componentOriginal1ddff7623f86636fa1935d1c4b12620c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ddff7623f86636fa1935d1c4b12620c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar-notrack','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar-notrack'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ddff7623f86636fa1935d1c4b12620c)): ?>
<?php $attributes = $__attributesOriginal1ddff7623f86636fa1935d1c4b12620c; ?>
<?php unset($__attributesOriginal1ddff7623f86636fa1935d1c4b12620c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ddff7623f86636fa1935d1c4b12620c)): ?>
<?php $component = $__componentOriginal1ddff7623f86636fa1935d1c4b12620c; ?>
<?php unset($__componentOriginal1ddff7623f86636fa1935d1c4b12620c); ?>
<?php endif; ?>
    <?php endif; ?>
    <main class="flex justify-center items-start px-4 sm:px-6 lg:px-8 mt-10">
      <div class="flex flex-col w-full max-w-3xl pb-48">

        <!-- Navigasi -->
        <div class="flex flex-row items-center pb-16">
          <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2 transition">
            <span class="text-4xl font-semibold">&larr;</span>
          </a>
          <p class="text-xl font-poppins text-center flex-1 pr-8">Track Pengajuanmu</p>
        </div>

        <!-- Nama -->
        <div class="text-left mb-6">
          <?php if($tracks->isNotEmpty()): ?>
            <p class="text-lg font-semibold font-poppins">Halo <?php echo e($tracks->first()->nama); ?></p>
            <p class="text-sm text-gray-600">NIM: <?php echo e($tracks->first()->nim); ?></p>
          <?php else: ?>
            <p class="text-lg font-semibold font-poppins">Data tidak ditemukan</p>
          <?php endif; ?>
        </div>

        <!-- Form Box -->
        <div class="w-full bg-white shadow-xl shadow-black/50 rounded-2xl px-6 py-8 space-y-6">
          <!-- Status Tracking -->
          <div class="space-y-4 text-left">
            <p class="text-2xl font-bold font-poppins text-gray-700">Riwayat Status</p>

            <!-- Looping Riwayat Status -->
            <?php $__empty_1 = true; $__currentLoopData = $tracks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <div class="border rounded-xl p-4 bg-gray-50">
                <p class="text-lg font-semibold text-green-700"><?php echo e(ucfirst($r->status)); ?></p>
                <p class="text-sm text-gray-500">
                  Diperbarui pada: <?php echo e(\Carbon\Carbon::parse($r->updated_at)->format('d M Y, H:i')); ?>

                </p>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <div class="border rounded-xl p-4 bg-gray-50">
                <p class="text-lg font-semibold text-gray-400">Belum ada riwayat status.</p>
              </div>
            <?php endif; ?>

            <!-- Nomor Tracking -->
            <div class="flex flex-row space-x-2 pt-6 pl-1">
              <img src="/images/file.svg" alt="icon file" class="w-4 h-6">
              <p>Nomor Tracking: <?php echo e($customId); ?></p>
            </div>
          </div>

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
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
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
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/mahasiswa/tracking/datatrack.blade.php ENDPATH**/ ?>