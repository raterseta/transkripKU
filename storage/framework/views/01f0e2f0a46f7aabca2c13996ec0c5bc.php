<?php $__env->startComponent('mail::message'); ?>
# Informasi Pengajuan Final

Halo, **<?php echo e($nama); ?>**!

Berikut ini adalah informasi terkait pengajuan final Anda:

**Keterangan:**
<?php echo e($keterangan); ?>


<?php if(!empty($file_transkrip)): ?>
<?php $__env->startComponent('mail::button', ['url' => url('storage/' . $file_transkrip)]); ?>
Lihat Transkrip
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

Terima kasih,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\testingv2\resources\views/emails/Pengajuan-final.blade.php ENDPATH**/ ?>