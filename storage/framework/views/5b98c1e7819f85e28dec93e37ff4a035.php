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
    <div class="flex justify-center items-start px-4 sm:px-6 lg:px-8 mt-10 pb-20 min-h-[80vh]">
        <div class="flex flex-col w-full max-w-3xl">
            <div class="flex flex-row items-center pb-8">
                <a href="<?php echo e(route('track.index')); ?>" class="flex items-center space-x-2">
                    <span class="text-4xl font-semibold">&larr;</span>
                </a>
                <h1 class="text-2xl font-poppins font-semibold text-center flex-1 pr-8">Track Pengajuanmu</h1>
            </div>

            <?php if(session('error') || $tracks->isEmpty()): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-semibold">Data tidak ditemukan</p>
                    <p>Nomor tracking <?php echo e($trackingNumber); ?> tidak ditemukan dalam sistem.</p>
                </div>
                <div class="flex justify-center mt-4">
                    <a href="<?php echo e(route('track.index')); ?>" class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                        Kembali
                    </a>
                </div>
            <?php else: ?>
                <h2 class="text-3xl font-semibold font-poppins mb-8 text-center">Halo <?php echo e($requestData->student_name); ?></h2>

                <div class="bg-white shadow-lg rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-semibold">Status</h2>
                        <div class="text-right">
                            <p class="text-lg font-medium">Estimasi: 3 hari</p>
                        </div>
                    </div>

                    <div class="relative">
                        <?php $__currentLoopData = $tracks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $track): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex mb-8 relative">
                                <div class="mr-4 relative z-10">
                                    <div class="bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                                        <?php switch($track->status):
                                            case (\App\Enums\RequestStatus::SELESAI): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <?php break; ?>

                                            <?php case (\App\Enums\RequestStatus::DITOLAK): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <?php break; ?>

                                            <?php case (\App\Enums\RequestStatus::DIKEMBALIKANKEOPERATOR): ?>

                                            <?php case (\App\Enums\RequestStatus::DIKEMBALIKANKEKAPRODI): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <?php break; ?>

                                            <?php case (\App\Enums\RequestStatus::PROSESOPERATOR): ?>
                                            <?php case (\App\Enums\RequestStatus::PROSESKAPRODI): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                <?php break; ?>

                                            <?php case (\App\Enums\RequestStatus::DITERUSKANKEOPERATOR): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                                </svg>
                                                <?php break; ?>

                                            <?php default: ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                        <?php endswitch; ?>
                                    </div>

                                    <!-- Vertical line -->
                                    <?php if($index < count($tracks) - 1): ?>
                                        <div class="absolute left-1/2 top-10 bottom-0 w-0.5 bg-gray-300 -ml-0.5 h-full"></div>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm text-gray-500 mb-1">
                                        <?php echo e(\Carbon\Carbon::parse($track->created_at)->format('d M Y - H:i')); ?> WIB
                                    </p>

                                    <p class="text-base"><?php echo e($track->action_desc); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="flex items-center mt-6 pt-6 border-t border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p>Nomor Tracking: <span class="font-medium"><?php echo e($trackingNumber); ?></span></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
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
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/mahasiswa/track/result.blade.php ENDPATH**/ ?>