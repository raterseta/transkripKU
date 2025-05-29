<?php $__env->startSection('content'); ?>
  <div class="flex justify-center items-center px-4 sm:px-6 lg:px-8 mt-10 min-h-[90dvh]">
    <div class="flex flex-col w-full max-w-3xl space-y-6 pb-24">

    <!-- Navigasi dan judul -->
    <div class="flex flex-col">
      <div class="pb-6">
      <nav class="text-gray-500 text-sm font-medium" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
          <a href="/" class="inline-flex items-center text-gray-500 hover:text-gray-700">Home</a>
        </li>
        <li>
          <div class="flex items-center">
          <svg class="w-4 h-4 mx-2 mt-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
            clip-rule="evenodd" />
          </svg>
          <span class="text-gray-500">Form Pengajuan Final</span>
          </div>
        </li>
        </ol>
      </nav>
      </div>

      <div class="flex flex-row items-center gap-4 sm:gap-0">
      <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2 transition">
        <span class="text-4xl font-semibold">&larr;</span>
      </a>
      <p class="flex-1 pr-8 lg:text-2xl sm:text-lg text-center font-poppins">Daftar Permohonan Final</p>
      </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-4 text-center font-poppins">
        <div class="modal-body">
        <h5 class="modal-title mb-2 text-red-600" id="errorModalLabel">Terjadi Kesalahan</h5>
        <div class="text-left">
          <ul class="list-disc list-inside text-sm text-gray-700">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
        <button type="button" class="btn btn-secondary mt-4" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
      </div>
    </div>

    <form id="formPengajuanFinal" method="POST" action="/thesis-request" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>

      <div class="w-full bg-white shadow-xl shadow-black/50 rounded-2xl px-6 py-8 space-y-4">

      <div class="space-y-2 text-left">
        <label class="font-semibold font-poppins" for="student_name">Nama Lengkap <span
          class="text-red-500">*</span></label>
        <input id="student_name" name="student_name" required type="text" placeholder="Nama lengkap"
        class="w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-300 text-sm font-poppins" />
      </div>

      <div class="space-y-2 text-left">
        <label class="font-semibold font-poppins" for="student_nim">NIM <span class="text-red-500">*</span></label>
        <input id="student_nim" name="student_nim" required type="number" placeholder="NIM"
        class="w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-300 text-sm font-poppins" />
      </div>

      <div class="space-y-2 text-left">
        <label class="font-semibold font-poppins" for="student_email">Email Aktif <span
          class="text-red-500">*</span></label>
        <input id="student_email" name="student_email" required type="email" placeholder="Email"
        class="w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-300 text-sm font-poppins" />
      </div>

      <div class="space-y-2 text-left">
        <label class="font-semibold font-poppins" for="keterangan">Catatan Tambahan</label>
        <textarea id="student_notes" name="student_notes"
        class="w-full h-40 p-3 border border-gray-300 font-mono text-sm rounded-md focus:outline-none resize-none font-poppins"
        placeholder="Masukkan catatan tambahan"></textarea>
      </div>

      <!-- Upload Transkrip + Tombol -->
      <div class="pt-6 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
        <div class="w-full sm:w-3/4">
        <label class="block font-semibold font-poppins">Upload Dokumen Pendukung</label>
        <input id="supporting_document_url" name="supporting_document_url" type="file" accept=".pdf,.jpg,.jpeg,.png"
          class="block w-full text-sm text-gray-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-md file:border-10
            file:border-blue-500
            file:text-sm file:font-semibold
            file:bg-white file:text-orange-700
            hover:file:bg-orange-100 mt-1" />
        </div>

        <div class="flex justify-end">
        <button type="button" id="submitBtn"
          class="w-full sm:w-auto py-2 px-4 font-semibold text-white transition bg-orange-500 rounded-md hover:bg-orange-600">
          Submit
        </button>
        </div>
      </div>

      <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 text-center font-poppins">
          <div class="modal-body">
          <h5 class="modal-title mb-2" id="confirmModalLabel">Konfirmasi Pengajuan</h5>
          <p class="pb-3">Apakah Anda yakin ingin mengirim pengajuan transkrip final ini?</p>
          <div class="d-flex justify-content-center gap-3">
            <button type="button" class="btn btn-secondary" id="cancelSubmit"
            data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-success bg-orange-500 border-orange-500 hover:bg-orange-600"
            id="confirmSubmit">Ya, Kirim</button>
          </div>
          </div>
        </div>
        </div>
      </div>

      </div>
    </form>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const submitButton = document.getElementById('submitBtn');
    const form = document.getElementById('formPengajuanFinal');
    const confirmSubmitButton = document.getElementById('confirmSubmit');

    <?php if($errors->any()): ?>
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    errorModal.show();
  <?php endif; ?>

    <?php if(old('student_name')): ?>
    document.getElementById('student_name').value = "<?php echo e(old('student_name')); ?>";
  <?php endif; ?>
    <?php if(old('student_nim')): ?>
    document.getElementById('student_nim').value = "<?php echo e(old('student_nim')); ?>";
  <?php endif; ?>
    <?php if(old('student_email')): ?>
    document.getElementById('student_email').value = "<?php echo e(old('student_email')); ?>";
  <?php endif; ?>
    <?php if(old('student_notes')): ?>
    document.getElementById('student_notes').value = `<?php echo old('student_notes'); ?>`;
  <?php endif; ?>

    function setLoadingState(isLoading) {
      if (isLoading) {
        confirmSubmitButton.disabled = true;
        confirmSubmitButton.classList.add('opacity-70', 'cursor-not-allowed');
        confirmSubmitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Mengirim...';

        const cancelButton = document.getElementById('cancelSubmit');
        cancelButton.disabled = true;
        cancelButton.classList.add('opacity-70', 'cursor-not-allowed');

        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        modal._config.backdrop = 'static';
        modal._config.keyboard = false;
      } else {
        confirmSubmitButton.disabled = false;
        confirmSubmitButton.classList.remove('opacity-70', 'cursor-not-allowed');
        confirmSubmitButton.innerHTML = 'Ya, Kirim';

        const cancelButton = document.getElementById('cancelSubmit');
        cancelButton.disabled = false;
        cancelButton.classList.remove('opacity-70', 'cursor-not-allowed');

        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        modal._config.backdrop = true;
        modal._config.keyboard = true;
      }
    }

    submitButton.addEventListener('click', function () {
      if (form.checkValidity()) {
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
      } else {
        form.reportValidity();
      }
    });

    confirmSubmitButton.addEventListener('click', function () {
      setLoadingState(true);
      const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
      form.submit();
    });
  });
</script>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/mahasiswa/pengajuan/pengajuan-final.blade.php ENDPATH**/ ?>