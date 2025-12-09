<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .credentials {
            background-color: white;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
        }
        .credentials p {
            margin: 10px 0;
        }
        .credentials strong {
            color: #4CAF50;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Welcome to {{ config('app.name') }}!</h1>
    </div>

    <div class="content">
        <h2>Hello {{ $client->first_name }} {{ $client->last_name }}! 👋</h2>

        <p>Thank you for your order! We've created an account for you so you can easily track your orders and enjoy a faster checkout experience next time.</p>

        <div class="credentials">
            <h3 style="margin-top: 0; color: #4CAF50;">Your Account Credentials</h3>
            <p><strong>Email:</strong> {{ $client->email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            <p style="margin-top: 15px; font-size: 14px; color: #666;">
                ⚠️ For security reasons, we recommend changing your password after your first login.
            </p>
        </div>

        <p><strong>What you can do with your account:</strong></p>
        <ul>
            <li>Track your orders in real-time</li>
            <li>Save multiple delivery addresses</li>
            <li>View your order history</li>
            <li>Faster checkout on future purchases</li>
            <li>Manage your profile information</li>
        </ul>

        <center>
            <a href="{{ route('client.login') }}" class="button">Login to Your Account</a>
        </center>

        <p style="margin-top: 30px;">If you have any questions, feel free to contact our customer support.</p>

        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>

    <div class="footer">
        <p>This email was sent to {{ $client->email }}</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
