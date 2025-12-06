<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi OTP</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .otp-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }

        .otp-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .otp-header h2 {
            margin: 0;
            font-weight: 600;
        }

        .otp-header .subtitle {
            opacity: 0.9;
            margin-top: 5px;
        }

        .otp-body {
            padding: 30px;
        }

        .otp-code-input {
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 0.5rem;
            text-align: center;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .otp-code-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-verify {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .resend-otp {
            color: #667eea;
            text-decoration: none;
            cursor: pointer;
        }

        .resend-otp:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .countdown {
            font-weight: bold;
            color: #dc3545;
        }

        .alert {
            border: none;
            border-radius: 10px;
        }

        .email-display {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px 15px;
            font-weight: 500;
            border-left: 4px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>
