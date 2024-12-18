<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .email-body {
            padding: 30px 20px;
        }
        .email-body p {
            margin-bottom: 20px;
        }
        .email-footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #777;
        }
        .cta-button {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Welcome to Our Platform, {{ $user->name }}!</h1>
        </div>
        <div class="email-body">
            <p>Dear {{ $user->name }},</p>
            
            <p>We are thrilled to welcome you to our platform! Your registration marks the beginning of an exciting journey with us. Our team is committed to providing you with the best possible experience and supporting you every step of the way.</p>
            
            <p>Here's what you can expect:</p>
            <ul>
                <li>Seamless user experience</li>
                <li>Cutting-edge features</li>
                <li>Dedicated customer support</li>
            </ul>
            
            <a href="#" class="cta-button">Get Started</a>
            
            <p>If you need any assistance or have questions, our support team is always ready to help. Don't hesitate to reach out to us.</p>
            
            <p>Welcome aboard!</p>
            
            <p>Best regards,<br>The Platform Team</p>
        </div>
        <div class="email-footer">
            <p>© 2024 Our Platform. All rights reserved.</p>
            <p>If you did not sign up for our service, please ignore this email.</p>
        </div>
    </div>
</body>
</html>