<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Konsultasi Transkrip Final</title>
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

        .status-change {
            background-color: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .status-label {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            margin-right: 5px;
        }

        .status-previous {
            background-color: #f3f4f6;
            color: #6b7280;
        }

        .status-new {
            background-color: #dbeafe;
            color: #1e40af;
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

        .consultation-section {
            background-color: #ecfdf5;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #10b981;
        }

        .notes-section {
            background-color: #fffbeb;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #f59e0b;
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
            <h1>Jadwal Konsultasi Transkrip Final</h1>
        </div>

        <div class="content">
            <p>
                <?php if($recipientRole === 'student'): ?>
                    Halo <?php echo e($request->student_name); ?>,
                <?php elseif($recipientRole === 'kaprodi'): ?>
                    Halo Kepala Program Studi,
                <?php else: ?>
                    Halo,
                <?php endif; ?>
            </p>

            <p>
                <?php if($recipientRole === 'student'): ?>
                    Jadwal konsultasi untuk pengajuan transkrip final Anda telah ditentukan.
                <?php elseif($recipientRole === 'kaprodi'): ?>
                    Anda telah menjadwalkan konsultasi untuk pengajuan transkrip final mahasiswa ini.
                <?php endif; ?>
            </p>

            <div class="tracking-container">
                <p>Nomor Tracking</p>
                <div class="tracking-number"><?php echo e($request->tracking_number); ?></div>
            </div>

            <div class="status-change">
                <p>Status telah berubah:</p>
                <p>
                    <span class="status-label status-previous">
                        <?php echo e(\App\Enums\RequestStatus::from($oldStatus)->getLabel()); ?>

                    </span>
                    →
                    <span class="status-label status-new">
                        <?php echo e(\App\Enums\RequestStatus::from($newStatus)->getLabel()); ?>

                    </span>
                </p>
            </div>

            <div class="consultation-section">
                <h3>Detail Jadwal Konsultasi:</h3>
                <p><strong>Tanggal & Waktu:</strong> <?php echo e($request->consultation_date->format('d M Y, H:i')); ?></p>

                <?php if($request->consultation_notes): ?>
                    <h4>Catatan Konsultasi:</h4>
                    <div>
                        <?php echo $request->consultation_notes; ?>

                    </div>
                <?php endif; ?>
            </div>

            <?php if($notes): ?>
            <div class="notes-section">
                <h3>Catatan Tambahan:</h3>
                <p><?php echo e($notes); ?></p>
            </div>
            <?php endif; ?>

            <h3>Detail Permintaan:</h3>

            <table class="info-table">
                <tr>
                    <td>Nama Mahasiswa</td>
                    <td><?php echo e($request->student_name); ?></td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td><?php echo e($request->student_nim); ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo e($request->student_email); ?></td>
                </tr>
                <tr>
                    <td>Tanggal Pengajuan</td>
                    <td><?php echo e($request->created_at->format('d M Y, H:i')); ?></td>
                </tr>
            </table>

            <div style="text-align: center;">
                <?php if($recipientRole === 'kaprodi'): ?>
                    <a href="<?php echo e(url('/admin/transkrip-final/' . $request->id . '/edit')); ?>" class="btn">Lihat Detail Pengajuan</a>
                <?php else: ?>
                    <p style="font-weight: 600; margin-top: 30px;">Mohon hadir tepat waktu sesuai jadwal yang telah ditentukan.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> TranskripKU. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/emails/consultation-scheduled-notification.blade.php ENDPATH**/ ?>