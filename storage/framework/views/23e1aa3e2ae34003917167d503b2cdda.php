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
    <main class="flex justify-center items-center px-4 sm:px-6 lg:px-8 mt-10 h-[90dvh]">
      <div class="flex flex-col w-full max-w-3xl pb-48">

        <!-- Navigasi dan judul -->
        <div class="flex flex-row items-center pb-16">
          <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2 transition">
            <span class="text-4xl font-semibold">&larr;</span>
          </a>
            <p class="text-xl font-poppins text-center flex-1 pr-8">Track Pengajuanmu</p>
        </div>

        <!-- Form Box -->
         <img src="/images/truck.svg" alt="" class="h-20 w-20">
        <div class="w-full bg-white shadow-xl shadow-black/50 rounded-2xl px-6 py-8 space-y-4">
          <!-- Input Group -->
          <form method="GET" action="<?php echo e(route('track.show')); ?>">
            <div class="space-y-2 text-left font-poppins">
              <label for="tracking" class="font-semibold">Masukkan Nomor Tracking Kamu</label>
              <input
                id="tracking"
                name="id"
                type="text"
                placeholder="Nomor Tracking"
                class="text-sm bg-gray-300 w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-300"
              />
            </div>

            <div class="pt-6 flex justify-center">
              <button type="submit" class="w-1/6 bg-orange-500 hover:bg-orange-600 text-black py-2 rounded-md transition font-semibold">
                Lacak
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
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

  </div>
</body>
</html>
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/mahasiswa/track/index.blade.php ENDPATH**/ ?>