@extends('emails.layouts.master')

@section('title', 'Verify Your Email Address - AURA')

@section('content')
    <div style="text-align: center; margin-bottom: 30px;">
        <div style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%); border-radius: 50px; margin-bottom: 20px;">
            <span style="color: #ffffff; font-size: 14px; font-weight: 600; letter-spacing: 1px;">🔐 EMAIL VERIFICATION</span>
        </div>
    </div>

    <h1 style="color: #ffffff; font-size: 32px; font-weight: 700; text-align: center; margin: 0 0 30px 0; line-height: 1.2;">
        Verify Your Email Address
    </h1>

    <div style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border-radius: 12px; padding: 30px; margin: 30px 0; border-left: 4px solid #1a202c;">
        <p style="color: #2d3748; font-size: 18px; font-weight: 500; margin: 0 0 15px 0;">
            Hello <strong>{{ $user->name ?? 'User' }}</strong>,
        </p>
        <p style="color: #4a5568; font-size: 16px; line-height: 1.7; margin: 0;">
            Welcome to AURA! We're excited to have you join our professional legal services platform. To get started, please verify your email address by clicking the button below.
        </p>
    </div>

    <div class="btn-container" style="text-align: center; margin: 40px 0;">
        <a href="{{ $url }}" class="button" style="display: inline-block; background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%); color: #ffffff !important; text-decoration: none; padding: 18px 40px; border-radius: 12px; font-weight: 600; font-size: 16px; letter-spacing: 0.5px; box-shadow: 0 8px 25px rgba(26, 32, 44, 0.2); transition: all 0.3s ease;">
            🔗 Verify Email Address
        </a>
    </div>

    <div style="background: #f8fafc; border-radius: 8px; padding: 20px; margin: 30px 0; border: 1px solid #e2e8f0;">
        <h3 style="color: #2d3748; font-size: 16px; font-weight: 600; margin: 0 0 10px 0;">
            ⏰ What happens next?
        </h3>
        <ul style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 20px;">
            <li>Click the verification button above</li>
            <li>You'll be redirected to our secure platform</li>
            <li>Your account will be activated instantly</li>
            <li>Start accessing our legal consultation services</li>
        </ul>
    </div>

    <div class="divider" style="height: 1px; background: linear-gradient(90deg, transparent 0%, #e2e8f0 50%, transparent 100%); margin: 40px 0;"></div>

    <div style="background: #fff5f5; border: 1px solid #fed7d7; border-radius: 8px; padding: 20px; margin: 30px 0;">
        <p style="color: #742a2a; font-size: 14px; line-height: 1.6; margin: 0;">
            <strong>🛡️ Security Notice:</strong> If you did not create an account with AURA, please ignore this email. No further action is required, and your email address will not be used.
        </p>
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <p style="color: #718096; font-size: 14px; line-height: 1.6; margin: 0 0 15px 0;">
            Having trouble with the button? Copy and paste this link into your browser:
        </p>
        <div style="background: #f7fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; word-break: break-all;">
            <a href="{{ $url }}" style="color: #1a202c; font-size: 12px; text-decoration: none; font-family: monospace;">{{ $url }}</a>
        </div>
    </div>

    <div style="text-align: center; margin: 40px 0 20px 0;">
        <p style="color: #ffffff; font-size: 16px; margin: 0;">
            Best regards,<br>
            <strong style="color: #ffffff;">The AURA Team</strong>
        </p>
    </div>
@endsection
