<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <title>TranskripKU - Tracking</title>
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

        <!-- Form Box -->
        <div class="w-full bg-white shadow-xl shadow-black/50 rounded-2xl px-6 py-8 space-y-6">
          <!-- Form Input Tracking -->
          <div class="space-y-4 text-left">
            <p class="text-2xl font-bold font-poppins text-gray-700">Masukkan Nomor Tracking</p>

            <form action="<?php echo e(route('mahasiswa.tracking.track.store')); ?>" method="POST" class="space-y-6">
              <?php echo csrf_field(); ?>
              <div>
                <label for="custom_id" class="block text-sm font-medium text-gray-700 mb-2">Nomor Tracking</label>
                <input type="text" name="custom_id" id="custom_id" required
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-3">
                <?php $__errorArgs = ['custom_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                  <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>

              <div class="flex justify-end">
                <button type="submit"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  Cari Tracking
                </button>
              </div>
            </form>
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
<?php /**PATH C:\xampp\htdocs\testingv2\resources\views/mahasiswa/tracking/form.blade.php ENDPATH**/ ?>