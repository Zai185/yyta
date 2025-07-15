<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
</head>

<body>
    <h2>Hi {{ $name }},</h2>

    <p>Thank you for reaching out to us. We’ve received your message:</p>

    <blockquote style="border-left: 4px solid #ccc; padding-left: 12px;">
        {{ $messageText }}
    </blockquote>

    <p>We’ll get back to you within 24 hours.</p>

    <p>Best regards,<br>Y Max University Team</p>
</body>

</html>
