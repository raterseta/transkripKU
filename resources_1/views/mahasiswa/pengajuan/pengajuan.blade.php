<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap JS Bundle (sudah termasuk Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

  <!-- Quill CSS -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <!-- Quill JS -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.min.js" defer></script>

  @vite('resources/css/app.css')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <title>TranskripKU</title>
</head>
<body class="h-full bg-gray-100" x-data="{ showPopup: false }">
  <div>
    <x-navbar></x-navbar>
    <main class="flex items-center justify-center px-4 mt-10 sm:px-6 lg:px-8 min-h-[90dvh]">
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
                      <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-500">Form Pengajuan</span>
                  </div>
                </li>
              </ol>
            </nav>
          </div>
          <div class="flex flex-row items-center">
            <a href="{{ url('/') }}" class="flex items-center space-x-2 transition">
              <span class="text-4xl font-semibold">&larr;</span>
            </a>
              <p class="flex-1 pr-8 text-2xl text-center font-poppins">Daftar Permohonan</p>
          </div>
        </div>

        <form
          id="formPengajuan"
          method="POST" action="/academic-request" enctype="multipart/form-data">
          @csrf
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
                  <option value="Lainnya">Lainnya</option>
                </select>

                <!-- Alasan Lainnya -->
                <input
                  type="text"
                  id="other_needs"
                  name="other_needs"
                  class="mt-2 w-full px-3 py-2 text-sm border border-gray-300 border-solid rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300 font-poppins hidden"
                  placeholder="Tulis keperluan lainnya..."
                >
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
              <label class="block mb-1 text-sm font-medium text-gray-700 rounded-t-md">Catatan Tambahan</label>
              <div id="quill-editor" class="bg-white h-40 border border-gray-300"></div>
              <input type="hidden" name="student_notes" id="student_notes">
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
                      <button type="button" class="btn btn-success border-solid border-orange-500 hover:bg-red-700 bg-orange-500 w-48 mt-3" id="confirmSubmit">Lanjut</button>
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
  <x-navbar-footer></x-navbar-footer>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const submitButton = document.getElementById('submitBtn');
    const form = document.getElementById('formPengajuan');
    const confirmSubmitButton = document.getElementById('confirmSubmit');

    // Inisialisasi Quill
    const quill = new Quill('#quill-editor', {
      theme: 'snow'
    });

    // Tangkap kebutuhan transkrip
    const needsSelect = document.getElementById('needs');
    const otherNeedsInput = document.getElementById('other_needs');

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
      // Isi nilai hidden input dengan isi editor Quill
      document.getElementById('student_notes').value = quill.root.innerHTML;

      if (form.checkValidity()) {
        const modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();
      } else {
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
