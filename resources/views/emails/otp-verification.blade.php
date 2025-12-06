<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .content {
            padding: 30px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 5px;
            color: #007bff;
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px dashed #dee2e6;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #6c757d;
            padding: 20px;
            background: #f8f9fa;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info-box {
            background: #d1edff;
            border: 1px solid #b6d7ff;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verifikasi Email Anda</h1>
            <p>{{ $appName }}</p>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>

            <p>Terima kasih telah mendaftar di <strong>{{ $appName }}</strong>.
               Untuk melengkapi proses registrasi, silakan gunakan kode OTP berikut:</p>

            <div class="otp-code">{{ $otp }}</div>

            <div class="warning">
                <strong>⏰ Perhatian:</strong>
                Kode OTP ini akan kedaluwarsa dalam <strong>{{ $expiryMinutes }} menit</strong>.
                Jangan berikan kode ini kepada siapapun.
            </div>

            <div class="info-box">
                <strong>💡 Tips:</strong>
                <ul>
                    <li>Salin kode OTP di atas dan tempel di halaman verifikasi</li>
                    <li>Kode akan kadaluarsa secara otomatis setelah {{ $expiryMinutes }} menit</li>
                    <li>Jika tidak meminta kode, abaikan email ini</li>
                </ul>
            </div>

            <p>Jika Anda mengalami masalah, silakan hubungi administrator sistem.</p>

            <p>Salam hangat,<br>
            <strong>Tim {{ $appName }}</strong></p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
