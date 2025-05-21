<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Transkrip Akademik</title>
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
            background: linear-gradient(135deg, #ff8c42 0%, #f96e46 100%);
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
            color: #ff8c42;
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
            background-color: #ff8c42;
            color: white !important;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #f96e46;
        }

        .status-badge {
            display: inline-block;
            background-color: #f0f8ff;
            color: #0077cc;
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
            <h1>Permintaan Transkrip Akademik Berhasil</h1>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $request->student_name }}</strong>,</p>

            <p>Terima kasih telah mengajukan permintaan transkrip akademik di TranskripKU. Permintaan Anda telah berhasil diterima dan sedang diproses.</p>

            <div class="tracking-container">
                <p>Nomor Tracking Anda</p>
                <div class="tracking-number">{{ $request->tracking_number }}</div>
                <p>Gunakan nomor tracking ini untuk memantau status permintaan Anda</p>
            </div>

            <h3>Detail Permintaan:</h3>

            <table class="info-table">
                <tr>
                    <td>Nama</td>
                    <td>{{ $request->student_name }}</td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>{{ $request->student_nim }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $request->student_email }}</td>
                </tr>
                <tr>
                    <td>Keperluan</td>
                    <td>{{ $request->needs }}</td>
                </tr>
                <tr>
                    <td>Bahasa</td>
                    <td>{{ $request->language == 'indonesia' ? 'Bahasa Indonesia' : 'Bahasa Inggris' }}</td>
                </tr>
                <tr>
                    <td>Tanda Tangan</td>
                    <td>{{ $request->signature_type }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><span class="status-badge">Sedang Diproses</span></td>
                </tr>
            </table>

            <p>Anda akan menerima pemberitahuan saat status permintaan Anda berubah. Proses pengajuan biasanya membutuhkan waktu 2-3 hari kerja.</p>

            <div style="text-align: center;">
                <a href="{{ url('/track/show?id=' . $request->tracking_number) }}" class="btn">Lacak Permintaan</a>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} TranskripKU. Semua hak dilindungi.</p>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami di <a href="mailto:support@transkripku.ac.id">support@transkripku.ac.id</a></p>
        </div>
    </div>
</body>
</html>
