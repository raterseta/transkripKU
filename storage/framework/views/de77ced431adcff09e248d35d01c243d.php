<?php
    $url = $getState(); // $getState() itu otomatis ambil value dari field yang diset di ViewField
?>

<div class="flex flex-col space-y-5">
    <label for="" class="font-poppins">Dokumen Pendukung</label>
    <div class="flex justify-center items-center">
        <!--[if BLOCK]><![endif]--><?php if($url): ?>
            <!--[if BLOCK]><![endif]--><?php if(Str::endsWith($url, ['jpg', 'jpeg', 'png'])): ?>
                <img src="http://127.0.0.1:8000/storage/<?php echo e($url); ?>" alt="Preview" class="max-w-xs rounded-lg shadow-lg">
            <?php elseif(Str::endsWith($url, ['pdf'])): ?>
                <a href="http://127.0.0.1:8000/storage/<?php echo e($url); ?>" target="_blank" class="text-blue-600 underline">Lihat PDF</a>
            <?php else: ?>
                <span class="text-gray-500">File tidak dapat dipreview.</span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php else: ?>
            <span class="text-gray-400 italic">Belum ada file.</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

</div><?php /**PATH C:\xampp\htdocs\testingv2\resources\views/components/preview-file.blade.php ENDPATH**/ ?>