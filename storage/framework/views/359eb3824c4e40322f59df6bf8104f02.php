<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Transkrip Akademik Selesai</title>
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
            background: linear-gradient(135deg, #12b76a 0%, #10a562 100%);
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
        }

        .tracking-container {
            background-color: #f7f7f7;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            border: 1px dashed #ddd;
        }

        .tracking-number {
            font-size: 28px;
            font-weight: 700;
            color: #12b76a;
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

        .footer {
            background-color: #f5f5f5;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
        }

        .btn {
            display: inline-block;
            background-color: #12b76a;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #10a562;
        }

        .status-badge {
            display: inline-block;
            background-color: #e6f7ef;
            color: #12b76a;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                margin: 0;
                border-radius: 0;
            }

            .header {
                padding: 20px;
            }

            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Permintaan Transkrip Akademik Selesai</h1>
        </div>

        <div class="content">
            <p>Halo <strong><?php echo e($request->student_name); ?></strong>,</p>

            <p>Dengan senang hati kami informasikan bahwa permintaan transkrip akademik Anda telah <strong>selesai diproses</strong>. Transkrip dapat diambil di Bagian Akademik dengan menunjukkan nomor tracking Anda.</p>

            <div class="tracking-container">
                <p>Nomor Tracking Anda</p>
                <div class="tracking-number"><?php echo e($request->tracking_number); ?></div>
            </div>

            <h3>Detail Permintaan:</h3>

            <table class="info-table">
                <tr>
                    <td>Nama</td>
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
                    <td>Keperluan</td>
                    <td><?php echo e($request->needs); ?></td>
                </tr>
                <tr>
                    <td>Bahasa</td>
                    <td><?php echo e($request->language == 'indonesia' ? 'Bahasa Indonesia' : 'Bahasa Inggris'); ?></td>
                </tr>
                <tr>
                    <td>Tanda Tangan</td>
                    <td><?php echo e($request->signature_type); ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><span class="status-badge">Selesai</span></td>
                </tr>
            </table>


            <div style="text-align: center;">
                <a href="<?php echo e(url('/track/show?id=' . $request->tracking_number)); ?>" class="btn">Lihat Detail</a>
            </div>
        </div>

        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> TranskripKU. Semua hak dilindungi.</p>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami di <a href="mailto:support@transkripku.ac.id">support@transkripku.ac.id</a></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/emails/academic-request-completed.blade.php ENDPATH**/ ?>