<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <title>@yield('title', 'AURA')</title>


    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #2d3748;
            margin: 0;
            padding: 0;
            background-color: #f7fafc;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            width: 100% !important;
            min-width: 100%;
        }

        /* Container Styles */
        .email-wrapper {
            width: 100%;
            background-color: #f7fafc;
            padding: 20px 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        /* Header Styles */
        .email-header {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.03)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.03)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.02)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .logo-container {
            position: relative;
            z-index: 2;
        }

        .logo {
            max-width: 280px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .brand-tagline {
            color: #cbd5e0;
            font-size: 14px;
            margin-top: 12px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        /* Content Styles */
        .email-content {
            padding: 40px 30px;
            background-color: #ffffff;
        }

        .email-content h1, .email-content h2, .email-content h3 {
            color: #1a202c;
            margin: 0 0 20px 0;
            font-weight: 700;
            line-height: 1.3;
        }

        .email-content h1 {
            font-size: 28px;
        }

        .email-content h2 {
            font-size: 24px;
        }

        .email-content h3 {
            font-size: 20px;
        }

        .email-content p {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.7;
            margin: 0 0 20px 0;
        }

        .email-content .lead {
            font-size: 18px;
            color: #2d3748;
            font-weight: 500;
        }

        /* Button Styles */
        .btn-container {
            text-align: center;
            margin: 30px 0;
        }

        .btn, .button {
            display: inline-block;
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(26, 32, 44, 0.15);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            letter-spacing: 0.5px;
        }

        .btn:hover, .button:hover {
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            box-shadow: 0 6px 20px rgba(26, 32, 44, 0.25);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: transparent;
            color: #1a202c !important;
            border: 2px solid #1a202c;
        }

        .btn-secondary:hover {
            background: #1a202c;
            color: #ffffff !important;
        }

        /* Link Styles */
        a {
            color: #1a202c;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            color: #2d3748;
            text-decoration: underline;
        }

        a.button {
            color: #ffffff !important;
            text-decoration: none !important;
        }

        /* Info Box Styles */
        .info-box {
            background-color: #f7fafc;
            border-left: 4px solid #1a202c;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }

        .verification-code {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 18px;
            font-weight: 700;
            color: #1a202c;
            letter-spacing: 2px;
            word-break: break-all;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #e2e8f0 50%, transparent 100%);
            margin: 30px 0;
        }

        /* Footer Styles */
        .email-footer {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            padding: 30px;
            text-align: center;
            color: #cbd5e0;
        }

        .footer-content {
            max-width: 400px;
            margin: 0 auto;
        }

        .footer-logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .footer-text {
            font-size: 14px;
            line-height: 1.6;
            margin: 8px 0;
            color: #a0aec0;
        }

        .footer-links {
            margin: 20px 0 15px 0;
        }

        .footer-links a {
            color: #cbd5e0;
            text-decoration: none;
            margin: 0 15px;
            font-size: 14px;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: #ffffff;
        }

        .social-links {
            margin: 20px 0;
        }

        .social-links a {
            display: inline-block;
            margin: 0 8px;
            padding: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            width: 36px;
            height: 36px;
            text-align: center;
            line-height: 20px;
        }

        .disclaimer {
            font-size: 12px;
            color: #718096;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive Styles */
        @media only screen and (max-width: 640px) {
            .email-wrapper {
                padding: 10px 0;
            }

            .email-container {
                margin: 0 10px;
                border-radius: 8px;
            }

            .email-header {
                padding: 30px 20px;
            }

            .logo {
                max-width: 220px;
            }

            .email-content {
                padding: 30px 20px;
            }

            .email-content h1 {
                font-size: 24px;
            }

            .email-content h2 {
                font-size: 20px;
            }

            .email-content p {
                font-size: 15px;
            }

            .btn, .button {
                display: block;
                width: 100%;
                padding: 18px 20px;
                font-size: 16px;
                margin: 20px 0;
            }

            .email-footer {
                padding: 25px 20px;
            }

            .footer-links a {
                display: block;
                margin: 8px 0;
            }
        }

        @media only screen and (max-width: 480px) {
            .email-container {
                margin: 0 5px;
            }

            .email-header {
                padding: 25px 15px;
            }

            .email-content {
                padding: 25px 15px;
            }

            .logo {
                max-width: 180px;
            }

            .email-content h1 {
                font-size: 22px;
            }

            .verification-code {
                font-size: 16px;
                padding: 15px;
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            .email-wrapper {
                background-color: #1a202c !important;
            }

            .email-container {
                background-color: #2d3748 !important;
                border-color: #4a5568 !important;
            }

            .email-content {
                background-color: #2d3748 !important;
            }

            /* .email-content h1, .email-content h2, .email-content h3 {
                color: #f7fafc !important;
            } */

            /* .email-content p {
                color: #e2e8f0 !important;
            } */
        }
/*

        .email-container {
            width: 600px !important;
        }

        .btn, .button {
            border: none !important;
        } */
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header Section -->
            <div class="email-header">
                <div class="logo-container">
                    <img src="https://xs-lawyer.com/dark_logo.png" alt="AURA" class="logo" style="width: 100%;">
                    <div class="brand-tagline">Professional Legal Services</div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="email-content">
                @yield('content')
            </div>

            <!-- Footer Section -->
            <div class="email-footer">
                <div class="footer-content">
                    <div class="footer-text">
                        <strong>AURA</strong><br>
                        Professional Legal Consultation Services
                    </div>

                    <div class="footer-links">
                        <a href="{{ url('/') }}">Website</a>
                        <a href="{{ url('/about') }}">About Us</a>
                        <a href="{{ url('/contact') }}">Contact</a>
                        <a href="{{ url('/privacy') }}">Privacy Policy</a>
                    </div>

                    <div class="social-links">
                        <a href="#" title="Facebook">📘</a>
                        <a href="#" title="Twitter">🐦</a>
                        <a href="#" title="LinkedIn">💼</a>
                        <a href="#" title="Instagram">📷</a>
                    </div>

                    <div class="footer-text">
                        Cairo, Egypt<br>
                        <a href="mailto:support@xslawyer.co" style="color: #cbd5e0;">support@xslawyer.co</a><br>
                        <a href="tel:+201234567890" style="color: #cbd5e0;">+20 123 456 7890</a>
                    </div>

                    <div class="disclaimer">
                        <p>&copy; {{ date('Y') }} AURA. All rights reserved.</p>
                        <p>This is an automated message. Please do not reply to this email.</p>
                        <p>If you no longer wish to receive these emails, you can <a href="#" style="color: #cbd5e0;">unsubscribe here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
