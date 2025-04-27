<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pengajuan</title>
</head>
<body>
    <h2>Halo, <?php echo e($nama); ?>!</h2>
    <p>Terima kasih telah melakukan pengajuan.</p>
    <p><strong>Detail Pengajuan:</strong></p>
    <ul>
        <li><strong>Nama:</strong> <?php echo e($nama); ?></li>
        <li><strong>NIM:</strong> <?php echo e($nim); ?></li>
        <li><strong>Nomor Tracking:</strong> <?php echo e($custom_id); ?></li>
    </ul>
    <p>Nomor tracking ini akan digunakan untuk memantau status pengajuan Anda.</p>
    <p>Pengajuan bisa cek di : http://taruh-urlnya-manual/track</p>
    <br>
    <p>Terima kasih.</p>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\testingv2\resources\views/emails/notifikasi-pengajuan.blade.php ENDPATH**/ ?>