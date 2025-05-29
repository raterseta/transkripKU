<?php $__env->startSection('content'); ?>
  <div class="flex items-center justify-center px-4 mt-10 sm:px-6 lg:px-8 min-h-[90dvh]">
    <div class="flex flex-col w-full max-w-3xl pb-24 space-y-6">
    <!-- Navigasi dan judul -->
    <div class="flex flex-col">
      <div class="pb-6">
      <nav class="text-gray-500 text-sm font-medium" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
          <a href="/" class="inline-flex items-center text-gray-500 hover:text-gray-700">
          Home
          </a>
        </li>
        <li>
          <div class="flex items-center">
          <svg class="w-4 h-4 mx-2 text-gray-400 mt-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
            clip-rule="evenodd" />
          </svg>
          <span class="text-gray-500">Form Pengajuan</span>
          </div>
        </li>
        </ol>
      </nav>
      </div>
      <div class="flex flex-row items-center">
      <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2 transition">
        <span class="text-4xl font-semibold">&larr;</span>
      </a>
      <p class="flex-1 pr-8 lg:text-2xl sm:text-lg text-center font-poppins">Daftar Permohonan</p>
      </div>
    </div>

    <!-- Error Modal -->
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

    <!-- Form Pengajuan -->
    <form id="formPengajuan" method="POST" action="/academic-request" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <div class="w-full px-6 py-8 space-y-4 bg-white shadow-xl shadow-black/50 rounded-2xl">
      <div class="flex flex-col lg:flex-row lg:space-x-10 space-y-4 lg:space-y-0">
        <div class="flex-1 flex flex-col space-y-4">
        <div class="space-y-2 text-left">
          <label class="font-semibold font-poppins" for="student_name">Nama Lengkap <span
            class="text-red-500">*</span></label>
          <input id="student_name" name="student_name" type="text" placeholder="Nama lengkap"
          value="<?php echo e(old('student_name')); ?>"
          class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-300 font-poppins"
          required />
        </div>
        <div class="space-y-2 text-left">
          <label class="font-semibold font-poppins" for="student_nim">NIM <span
            class="text-red-500">*</span></label>
          <input id="student_nim" name="student_nim" type="number" placeholder="NIM"
          value="<?php echo e(old('student_nim')); ?>"
          class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-300 font-poppins"
          required />
        </div>
        <div class="space-y-2 text-left">
          <label class="font-semibold font-poppins" for="student_email">Email Aktif <span
            class="text-red-500">*</span></label>
          <input id="student_email" name="student_email" type="email" placeholder="Email"
          value="<?php echo e(old('student_email')); ?>"
          class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-300 font-poppins"
          required />
        </div>
        </div>
        <!-- Kolom 2 -->
        <div class="flex-1 flex flex-col space-y-4">
        <div class="space-y-2 text-left">
          <label class="font-semibold font-poppins" for="needs">Keperluan Transkrip Akademik <span
            class="text-red-500">*</span></label>
          <select id="needs" name="needs"
          class="w-full border px-3 py-2 rounded-md border-gray-300 focus:ring-2 focus:ring-orange-300 text-sm font-poppins"
          required>
          <option value="" disabled selected>Pilih keperluan</option>
          <option value="Skripsi" <?php echo e(old('needs') == 'Skripsi' ? 'selected' : ''); ?>>Skripsi</option>
          <option value="Beasiswa" <?php echo e(old('needs') == 'Beasiswa' ? 'selected' : ''); ?>>Beasiswa</option>
          <option value="Aktif Kuliah" <?php echo e(old('needs') == 'Aktif Kuliah' ? 'selected' : ''); ?>>Aktif Kuliah
          </option>
          <option value="Lainnya" <?php echo e(old('needs') == 'Lainnya' ? 'selected' : ''); ?>>Lainnya</option>
          </select>
          <input type="text" id="other_needs" name="other_needs"
          class="mt-2 w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-300 font-poppins hidden"
          placeholder="Tulis keperluan lainnya...">
        </div>
        <!-- Group Bahasa dan TTD -->
        <div class="flex flex-col md:flex-row md:space-x-8 space-y-4 md:space-y-0">
          <div class="space-y-2 w-full">
          <label class="font-semibold font-poppins">Bahasa <span class="text-red-500">*</span></label>
          <div class="flex flex-col space-y-2">
            <label class="flex items-center space-x-2">
            <input type="radio" name="language" value="indonesia" class="accent-orange-500" <?php echo e(old('language') == 'indonesia' ? 'checked' : ''); ?> required />
            <span>Bahasa Indonesia</span>
            </label>
            <label class="flex items-center space-x-2">
            <input type="radio" name="language" value="inggris" class="accent-orange-500" <?php echo e(old('language') == 'inggris' ? 'checked' : ''); ?> />
            <span>Bahasa Inggris</span>
            </label>
          </div>
          </div>
          <div class="space-y-2 w-full">
          <label class="font-semibold font-poppins">Tanda Tangan <span class="text-red-500">*</span></label>
          <div class="flex flex-col space-y-2">
            <label class="flex items-center space-x-2">
            <input type="radio" name="signature_type" value="basah" class="accent-orange-500" <?php echo e(old('signature_type') == 'basah' ? 'checked' : ''); ?> required />
            <span>Basah</span>
            </label>
            <label class="flex items-center space-x-2">
            <input type="radio" name="signature_type" value="digital" class="accent-orange-500" <?php echo e(old('signature_type') == 'digital' ? 'checked' : ''); ?> />
            <span>Digital</span>
            </label>
          </div>
          </div>
        </div>
        </div>
      </div>
      <!-- Editor dan Upload -->
      <div class="space-y-4">
        <div>
        <label class="block mb-1 text-sm font-medium text-gray-700 rounded-t-md">Catatan Tambahan</label>
        <div id="quill-editor" class="bg-white h-40 border border-gray-300"></div>
        <input type="hidden" name="student_notes" id="student_notes">
        </div>
      </div>
      <div class="flex flex-col lg:flex-row justify-between">
        <div>
        <label class="block">
          <span class="font-semibold font-poppins">Upload Dokumen Pendukung</span>
          <input id="supporting_document_url" name="supporting_document_url" type="file"
          accept=".pdf,.jpg,.jpeg,.png"
          class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-2 file:border-orange-500 file:text-sm file:font-semibold file:bg-white file:text-orange-700 hover:file:bg-orange-100" />
        </label>
        </div>
        <!-- Submit -->
        <div class="flex sm:flex-row lg:flex-row lg:justify-end items-end pt-6 space-y-4 lg:space-y-0 lg:space-x-4">
        <button type="button" id="submitBtn"
          class="w-full px-4 py-2 font-semibold text-white bg-orange-500 rounded-md hover:bg-orange-600 transition">Submit</button>
        </div>
      </div>

      <!-- Confirmation Modal -->
      <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 text-center font-poppins">
          <div class="modal-body">
          <h5 class="modal-title mb-2" id="confirmModalLabel">Konfirmasi Pengajuan</h5>
          <p class="pb-3">Apakah Anda yakin ingin mengirim pengajuan transkrip akademik ini?</p>
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
    const form = document.getElementById('formPengajuan');
    const confirmSubmitButton = document.getElementById('confirmSubmit');

    <?php if($errors->any()): ?>
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    errorModal.show();
    <?php endif; ?>

    // Inisialisasi Quill
    const quill = new Quill('#quill-editor', {
      theme: 'snow'
    });

    <?php if(old('student_notes')): ?>
    quill.root.innerHTML = `<?php echo old('student_notes'); ?>`;
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
    <?php if(old('needs')): ?>
    document.getElementById('needs').value = "<?php echo e(old('needs')); ?>";
    if ("<?php echo e(old('needs')); ?>" === 'Lainnya') {
      document.getElementById('other_needs').classList.remove('hidden');
      document.getElementById('other_needs').required = true;
    }
    <?php endif; ?>
    <?php if(old('other_needs')): ?>
    document.getElementById('other_needs').value = "<?php echo e(old('other_needs')); ?>";
    <?php endif; ?>
    <?php if(old('language')): ?>
    document.querySelector(`input[name="language"][value="<?php echo e(old('language')); ?>"]`).checked = true;
    <?php endif; ?>
    <?php if(old('signature_type')): ?>
    document.querySelector(`input[name="signature_type"][value="<?php echo e(old('signature_type')); ?>"]`).checked = true;
    <?php endif; ?>

    const needsSelect = document.getElementById('needs');
    const otherNeedsInput = document.getElementById('other_needs');

    if (needsSelect.value === 'Lainnya') {
      otherNeedsInput.classList.remove('hidden');
      otherNeedsInput.required = true;
    }

    needsSelect.addEventListener('change', function () {
      if (this.value === 'Lainnya') {
      otherNeedsInput.classList.remove('hidden');
      otherNeedsInput.required = true;
      } else {
      otherNeedsInput.classList.add('hidden');
      otherNeedsInput.required = false;
      otherNeedsInput.value = '';
      }
    });

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
      document.getElementById('student_notes').value = quill.root.innerHTML;

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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/mahasiswa/pengajuan/pengajuan.blade.php ENDPATH**/ ?>