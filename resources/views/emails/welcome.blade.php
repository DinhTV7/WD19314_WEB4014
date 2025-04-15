<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chào mừng bạn!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f6;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #4CAF50;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .email-body {
            padding: 30px;
        }
        .email-body h1 {
            margin-top: 0;
        }
        .email-footer {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h2>Chào mừng đến với {{ config('app.name') }}!</h2>
        </div>
        <div class="email-body">
            <h1>Xin chào {{ $user->name }},</h1>
            <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>{{ config('app.name') }}</strong>. Chúng tôi rất vui được chào đón bạn đến với cộng đồng của chúng tôi.</p>

            <p>Dưới đây là thông tin tài khoản của bạn:</p>
            <ul>
                <li><strong>Họ tên:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
            </ul>

            <p>Hãy bắt đầu khám phá ngay:</p>
            <a href="{{ url('/') }}" class="btn">Truy cập website</a>

            <p style="margin-top: 30px;">Nếu bạn có bất kỳ câu hỏi nào, đừng ngần ngại liên hệ với chúng tôi qua email hỗ trợ hoặc kênh chat trực tuyến.</p>

            <p>Trân trọng,<br/>Đội ngũ {{ config('app.name') }}</p>
        </div>
        <div class="email-footer">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
