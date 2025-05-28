<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pengajuan Transkrip Baru</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .content {
            padding: 30px;
            color: #333;
        }

        .tracking-container {
            background-color: #f0f9ff;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            border: 1px dashed #93c5fd;
        }

        .tracking-number {
            font-size: 24px;
            font-weight: 700;
            color: #2563eb;
            letter-spacing: 1px;
            margin: 10px 0;
        }

        .info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .info-table td:first-child {
            font-weight: 600;
            width: 40%;
        }

        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: white !important;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }

        .footer {
            background-color: #f5f5f5;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
        }

        .request-type-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .academic {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .thesis {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pengajuan Transkrip <?php echo e($requestType === 'academic' ? 'Akademik' : 'Final'); ?> Baru</h1>
        </div>

        <div class="content">
            <p>Halo Operator Akademik,</p>

            <p>Ada pengajuan transkrip <?php echo e($requestType === 'academic' ? 'akademik' : 'final'); ?> baru yang memerlukan tindak lanjut Anda. Berikut detail pengajuannya:</p>

            <div class="tracking-container">
                <p>Nomor Tracking</p>
                <div class="tracking-number"><?php echo e($trackingNumber); ?></div>
                <span class="request-type-badge <?php echo e($requestType); ?>">
                    Transkrip <?php echo e($requestType === 'academic' ? 'Akademik' : 'Final'); ?>

                </span>
            </div>

            <h3>Detail Permintaan:</h3>

            <table class="info-table">
                <tr>
                    <td>Nama Mahasiswa</td>
                    <td><?php echo e($studentName); ?></td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td><?php echo e($studentNim); ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo e($studentEmail); ?></td>
                </tr>
                <?php if($requestType === 'academic'): ?>
                    <?php if($needs): ?>
                    <tr>
                        <td>Keperluan</td>
                        <td><?php echo e($needs); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if($language): ?>
                    <tr>
                        <td>Bahasa</td>
                        <td><?php echo e($language == 'indonesia' ? 'Bahasa Indonesia' : 'Bahasa Inggris'); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if($signatureType): ?>
                    <tr>
                        <td>Tanda Tangan</td>
                        <td><?php echo e($signatureType); ?></td>
                    </tr>
                    <?php endif; ?>
                <?php endif; ?>
                <tr>
                    <td>Tanggal Pengajuan</td>
                    <td><?php echo e($createdAt->format('d M Y, H:i')); ?></td>
                </tr>
            </table>

            <div style="text-align: center;">
                <?php if($requestType === 'academic'): ?>
                    <a href="<?php echo e(url('/admin/pengajuan/' . $requestId . '/edit')); ?>" class="btn">Lihat Detail Pengajuan</a>
                <?php else: ?>
                    <a href="<?php echo e(url('/admin/pengajuan-final/' . $requestId . '/edit')); ?>" class="btn">Lihat Detail Pengajuan</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> TranskripKU. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/emails/new-transcript-request-notification.blade.php ENDPATH**/ ?>