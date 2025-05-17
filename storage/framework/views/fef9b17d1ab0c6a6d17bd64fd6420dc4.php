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
    <main class="flex items-center justify-center px-4 mt-10 sm:px-6 lg:px-8 min-h-[90dvh]">
      <div class="flex flex-col w-full max-w-3xl pb-24 space-y-6">

        <!-- Navigasi dan judul -->
        <div class="flex flex-row items-center">
          <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2 transition">
            <span class="text-4xl font-semibold">&larr;</span>
          </a>
            <p class="flex-1 pr-8 text-2xl text-center font-poppins">Daftar Permohonan</p>
        </div>

        <form
          id="formPengajuan"
          method="POST" action="/academic-request" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
            <!-- Form Box -->
          <div class="w-full px-6 py-8 space-y-4 bg-white shadow-xl shadow-black/50 rounded-2xl">
            <div class="flex flex-row space-x-2 lg:space-x-10">
              <!-- Col 1 -->
              <div class="flex-col space-y-4">
                <div class="space-y-2 text-left">
                  <label class="font-semibold font-poppins" for="student_name">Nama Lengkap <span class="text-red-500">*</label>
                  <input id="student_name" name="student_name" type="text" placeholder="Nama lengkap" class="w-full px-3 py-2 text-sm border border-gray-300 border-solid rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300 font-poppins" required />
                </div>
                <div class="space-y-2 text-left">
                  <label class="font-semibold font-poppins" for="student_nim">NIM <span class="text-red-500">*</label>
                  <input id="student_nim" name="student_nim" type="number" placeholder="NIM" class="w-full px-3 py-2 text-sm border border-gray-300 border-solid rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300 font-poppins" required/>
                </div>
                <div class="space-y-2 text-left">
                  <label class="font-semibold font-poppins" for="student_email">Email Aktif <span class="text-red-500">*</label>
                  <input id="student_email" name="student_email" type="email" placeholder="Email" class="w-full px-3 py-2 text-sm border border-gray-300 border-solid rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300 font-poppins" required/>
                </div>
              </div>
              <!-- Col 2 -->
              <div class="flex flex-col space-y-4">
                <div class="flex flex-col space-y-2 text-left">
                  <label class="font-semibold font-poppins" for="needs">Keperluan Transkrip Akademik <span class="text-red-500">*</label>
                  <select id="needs" name="needs" class="lg:w-[340px] w-[240px] border-solid px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-300 text-sm font-poppins" required>
                    <option value="" disabled selected>Pilih keperluan</option>
                    <option value="Skripsi">Skripsi</option>
                    <option value="Beasiswa">Beasiswa</option>
                    <option value="Aktif Kuliah">Aktif Kuliah</option>
                  </select>
                </div>

                <!-- Group bahasa dan Tanda tangan (TTD) -->
                <div class="flex flex-row space-x-8">
                  <!-- Pilih Bahasa -->
                  <div class="space-y-2">
                    <label class="font-semibold font-poppins">Bahasa <span class="text-red-500">*</label>
                    <div class="flex flex-col space-y-4">
                      <label class="flex items-center space-x-1">
                        <input type="radio" id="language" name="language" value="indonesia" class="accent-orange-500" required/>
                        <span>Bahasa Indonesia</span>
                      </label>
                      <label class="flex items-center space-x-1">
                        <input type="radio" id="language" name="language" value="inggris" class="accent-orange-500" />
                        <span>Bahasa Inggris</span>
                      </label>
                    </div>
                  </div>

                  <!-- Pilih Jenis Tanda Tangan -->
                  <div class="space-y-2">
                    <label class="font-semibold font-poppins">Tanda Tangan <span class="text-red-500">*</label>
                    <div class="flex flex-col space-y-4">
                      <label class="flex items-center space-x-1">
                        <input type="radio" id="signature_type" name="signature_type" value="basah" class="accent-orange-500" required/>
                        <span>Basah</span>
                      </label>
                      <label class="flex items-center space-x-1">
                        <input type="radio" id="signature_type" name="signature_type" value="digital" class="accent-orange-500" />
                        <span>Digital</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="w-full mx-auto">
              <label class="block mb-1 text-sm font-medium text-gray-700">Catatan Tambahan</label>

              <!-- Toolbar -->
              <!-- <div class="flex items-center p-2 space-x-2 text-white bg-blue-700 rounded-t-md">
                <button onclick="document.execCommand('bold', false, null)" class="font-bold">B</button>
              </div> -->

              <!-- Textarea -->
              <Textarea
                id="student_notes"
                name="student_notes"
                contenteditable="true"
                class="w-full h-40 p-3 font-mono text-sm border border-gray-300 border-solid rounded-md resize-none font-poppins focus:outline-none"
                placeholder="Masukkan catatan..."></Textarea>
            </div>

            <!-- Upload Transkrip + Tombol Submit -->
            <div class="flex items-center justify-between pt-6">
              <!-- Upload Transkrip Akademik -->
              <label class="block">
                <span class="font-semibold font-poppins">Upload Dokumen Pendukung</span>
                <input
                  id="supporting_document_url"
                  name="supporting_document_url"
                  type="file"
                  accept=".pdf,.jpg,.jpeg,.png"
                  class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-10 file:border-blue-500 file:text-sm file:font-semibold file:bg-white file:text-orange-700 hover:file:bg-orange-100"
                />
              </label>


              <!-- Tombol Submit -->
               <!-- <button>submit</button> -->
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
      const submitButton = document.getElementById('submitBtn');
      const form = document.getElementById('formPengajuan');
      const confirmSubmitButton = document.getElementById('confirmSubmit');

      function setLoadingState(isLoading) {
        if (isLoading) {
          submitButton.disabled = true;
          submitButton.classList.add('opacity-70', 'cursor-not-allowed');
          submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Mengirim...';
        } else {
          submitButton.disabled = false;
          submitButton.classList.remove('opacity-70', 'cursor-not-allowed');
          submitButton.innerHTML = 'Submit';
        }
      }

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

      confirmSubmitButton.addEventListener('click', function () {
        setLoadingState(true);

        form.submit();

        confirmSubmitButton.disabled = true;
        confirmSubmitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';
      });
    });
  </script>
</body>
</html>
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/mahasiswa/pengajuan/pengajuan.blade.php ENDPATH**/ ?>