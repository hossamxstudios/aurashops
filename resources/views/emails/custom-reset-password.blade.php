@extends('emails.layouts.master')

@section('title', 'Reset Your Password - AURA')

@section('content')
    <div style="text-align: center; margin-bottom: 30px;">
        <div style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); border-radius: 50px; margin-bottom: 20px;">
            <span style="color: #ffffff; font-size: 14px; font-weight: 600; letter-spacing: 1px;">🔑 PASSWORD RESET</span>
        </div>
    </div>

    <h1 style="color: #1a202c; font-size: 32px; font-weight: 700; text-align: center; margin: 0 0 30px 0; line-height: 1.2;">
        Reset Your Password
    </h1>

    <div style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-radius: 12px; padding: 30px; margin: 30px 0; border-left: 4px solid #dc2626;">
        <p style="color: #2d3748; font-size: 18px; font-weight: 500; margin: 0 0 15px 0;">
            Hello <strong>{{ $user->name ?? 'User' }}</strong>,
        </p>
        <p style="color: #4a5568; font-size: 16px; line-height: 1.7; margin: 0;">
            We received a request to reset your password for your AURA account. If you made this request, click the button below to create a new password.
        </p>
    </div>

    <div class="btn-container" style="text-align: center; margin: 40px 0;">
        <a href="{{ $url }}" class="button" style="display: inline-block; background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); color: #ffffff !important; text-decoration: none; padding: 18px 40px; border-radius: 12px; font-weight: 600; font-size: 16px; letter-spacing: 0.5px; box-shadow: 0 8px 25px rgba(220, 38, 38, 0.2); transition: all 0.3s ease;">
            🔑 Reset My Password
        </a>
    </div>

    <div style="background: #fffbeb; border: 1px solid #fed7aa; border-radius: 8px; padding: 20px; margin: 30px 0;">
        <h3 style="color: #92400e; font-size: 16px; font-weight: 600; margin: 0 0 10px 0;">
            ⚠️ Important Security Information
        </h3>
        <ul style="color: #78350f; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 20px;">
            <li><strong>Link expires in {{ $count ?? 60 }} minutes</strong> for your security</li>
            <li>Only use this link if you requested a password reset</li>
            <li>Choose a strong, unique password for your account</li>
            <li>Never share your password with anyone</li>
        </ul>
    </div>

    <div style="background: #f8fafc; border-radius: 8px; padding: 20px; margin: 30px 0; border: 1px solid #e2e8f0;">
        <h3 style="color: #2d3748; font-size: 16px; font-weight: 600; margin: 0 0 10px 0;">
            🛡️ Password Security Tips
        </h3>
        <ul style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 20px;">
            <li>Use at least 8 characters with a mix of letters, numbers, and symbols</li>
            <li>Avoid using personal information like names or birthdays</li>
            <li>Consider using a password manager for better security</li>
            <li>Enable two-factor authentication when available</li>
        </ul>
    </div>

    <div class="divider" style="height: 1px; background: linear-gradient(90deg, transparent 0%, #e2e8f0 50%, transparent 100%); margin: 40px 0;"></div>

    <div style="background: #fff5f5; border: 1px solid #fed7d7; border-radius: 8px; padding: 20px; margin: 30px 0;">
        <p style="color: #742a2a; font-size: 14px; line-height: 1.6; margin: 0;">
            <strong>🚨 Didn't request this?</strong> If you did not request a password reset, please ignore this email. Your account remains secure, and no changes will be made.
        </p>
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <p style="color: #718096; font-size: 14px; line-height: 1.6; margin: 0 0 15px 0;">
            Having trouble with the button? Copy and paste this link into your browser:
        </p>
        <div style="background: #f7fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; word-break: break-all;">
            <a href="{{ $url }}" style="color: #dc2626; font-size: 12px; text-decoration: none; font-family: monospace;">{{ $url }}</a>
        </div>
    </div>

    <div style="text-align: center; margin: 40px 0 20px 0;">
        <p style="color: #4a5568; font-size: 16px; margin: 0;">
            Best regards,<br>
            <strong style="color: #1a202c;">The AURA Security Team</strong>
        </p>
    </div>
@endsection
