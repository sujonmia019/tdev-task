<!DOCTYPE html>
<html lang="en" style="background-color: #f4f4f7; padding: 0; margin: 0;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2d89ef;
            font-size: 28px;
            margin: 0 0 20px 0;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #333333;
            text-align: center;
        }
        .otp {
            display: block;
            margin: 20px auto;
            font-size: 32px;
            font-weight: bold;
            color: #2d89ef;
            letter-spacing: 5px;
            text-align: center;
            padding: 15px 0;
            border-radius: 8px;
            background-color: #f0f4ff;
            width: 200px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888888;
            text-align: center;
        }
        @media screen and (max-width: 600px) {
            .container {
                padding: 20px;
            }
            .otp {
                font-size: 28px;
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verify Your Email</h1>
        <p>Hello {{ $username }},</p>
        <p>Use the following One-Time Password (OTP) to complete your registration:</p>
        <span class="otp">{{ $otp }}</span>
        <p>This OTP is valid for 5 minutes. Do not share it with anyone.</p>
        <p class="footer">If you did not request this, you can safely ignore this email.</p>
    </div>
</body>
</html>
