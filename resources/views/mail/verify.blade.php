<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Email</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f7f7f7; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#fff; padding:30px; border-radius:8px; text-align:center;">
        <h2 style="color:#333;">Hello {{ $username }},</h2>
        <p>Please verify your email address by clicking the button below. The link expires in 60 minutes.</p>
        <a href="{{ $verify_url }}"
           style="display:inline-block; margin-top:20px; padding:12px 25px; background:#007bff; color:#fff; text-decoration:none; border-radius:6px;">
           Verify Email
        </a>
        <p style="margin-top:20px; font-size:14px; color:#555;">
            If you did not create an account, no action is required.
        </p>
    </div>
</body>
</html>
