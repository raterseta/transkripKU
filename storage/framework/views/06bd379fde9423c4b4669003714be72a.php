<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (sudah termasuk Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
  <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <title>TranskripKU</title>
</head>
<body class="h-full" x-data="{ showPopup: false }">
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
    <main class="flex justify-center items-center px-4 sm:px-6 lg:px-8 mt-10">
      <div class="flex flex-col w-full max-w-3xl space-y-6 pb-24">

        <!-- Navigasi dan judul -->
        <div class="flex flex-row items-center">
          <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2 transition">
            <span class="text-4xl font-semibold">&larr;</span>
          </a>
            <p class="text-2xl text-center flex-1 pr-8 font-poppins">Daftar Permohonan Final</p>
        </div>

        <form
          id="formPengajuanFinal"
          method="POST" action="/pengajuan-final" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <!-- Form Box -->
          <div class="w-full bg-white shadow-xl shadow-black/50 rounded-2xl px-6 py-8 space-y-4">
            <!-- Input Group -->
            <div class="space-y-2 text-left">
              <label class="font-semibold font-poppins" for="nama">Nama Lengkap  <span class="text-red-500">*</span></label> 
              <input id="nama" name="nama" required type="text" placeholder="Nama lengkap" class="border-solid w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-300 text-sm font-poppins" />
            </div>
            <div class="space-y-2 text-left">
              <label class="font-semibold font-poppins" for="nim">NIM <span class="text-red-500">*</span></label>
              <input id="nim" name="nim" required type="number" placeholder="NIM" class="border-solid w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-300 text-sm font-poppins" />
            </div>
            <div class="space-y-2 text-left">
              <label class="font-semibold font-poppins" for="email">Email Aktif <span class="text-red-500">*</span></label>
              <input id="email" name="email" required type="email" placeholder="Email" class="border-solid w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-300 text-sm font-poppins" />
            </div>
            <div class="space-y-2 text-left">
              <label class="font-semibold font-poppins" for="keterangan">Keterangan Konsultasi</label>
              <Textarea 
                id="keterangan"
                name="keterangan"
                contenteditable="true"
                class="font-poppins w-full h-40 p-3 border-solid border border-gray-300 font-mono text-sm rounded-md focus:outline-none resize-none"
                placeholder="Masukkan Keterangan Konsultasi..."></Textarea>
            </div>

            <!-- Upload Transkrip + Tombol Submit -->
            <div class="pt-6 flex justify-between items-center">
              <!-- Upload Transkrip Akademik -->
              <label class="block">
                <span class="font-semibold font-poppins">Upload Dokumen Pendukung</span>
                <input 
                  id="file_pendukung"
                  name="file_pendukung"
                  type="file" 
                  accept=".pdf,.jpg,.jpeg,.png"
                  class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-10
                        file:border-blue-500
                        file:text-sm file:font-semibold
                        file:bg-white file:text-orange-700
                        hover:file:bg-orange-100
                        mt-1"
                />
              </label>
              

              <!-- Tombol Submit -->
              <button
                type="button"
                id="submitBtn"
                class="w-1/6 py-2 ml-4 font-semibold text-white transition bg-orange-500 rounded-md hover:bg-orange-600"
                >
                Submit
              </button>
              <!-- Modal Sukses -->
              <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content p-4 text-center font-poppins">
                    <div class="modal-body">
                      <h5 class="modal-title mb-2" id="successModalLabel">Pengajuan Berhasil Terkirim</h5>
                      <p class="pb-3">Nomor tracking dikirim via Email anda</p>
                      <button type="button" class="btn btn-success bg-orange-500 w-48 mt-3" id="confirmSubmit">Lanjut</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </form>
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
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const submitButton = document.getElementById('submitBtn'); // ubah ini
      const form = document.getElementById('formPengajuanFinal');

      submitButton.addEventListener('click', function () {
        if (form.checkValidity()) {
          // Kalau semua field required sudah diisi, tampilkan modal
          const modal = new bootstrap.Modal(document.getElementById('successModal'));
          modal.show();
        } else {
          // Kalau belum lengkap, munculin browser validation message
          form.reportValidity();
        }
      });

      const confirmSubmitButton = document.getElementById('confirmSubmit');
      confirmSubmitButton.addEventListener('click', function () {
        form.submit(); // Baru submit ke server
      });
    });

  </script>
</body>

</html>

<!-- tambahkan label "Upload Transkrip Akademik" yang isinya upload file. Label ini ditaruh sebaris dengan button (nanti pake justtify-between antara label upload dan button) --><?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/mahasiswa/pengajuan/pengajuan-final.blade.php ENDPATH**/ ?>