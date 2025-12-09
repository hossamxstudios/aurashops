@extends('emails.layouts.master')

@section('title', 'Welcome to AURA - Your Legal Journey Begins')

@section('content')
    <div style="text-align: center; margin-bottom: 30px;">
        <div
            style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #059669 0%, #10b981 100%); border-radius: 50px; margin-bottom: 20px;">
            <span style="color: #ffffff; font-size: 14px; font-weight: 600; letter-spacing: 1px;">🎉 WELCOME ABOARD</span>
        </div>
    </div>

    <h1 style="color: #ffffff; font-size: 32px; font-weight: 700; text-align: center; margin: 0 0 30px 0; line-height: 1.2;">
        Welcome to AURA, {{ $user->name }}!
    </h1>

    <div
        style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 12px; padding: 30px; margin: 30px 0; border-left: 4px solid #059669;">
        <p style="color: #2d3748; font-size: 18px; font-weight: 500; margin: 0 0 15px 0;">
            🚀 Your account is now active!
        </p>
        <p style="color: #4a5568; font-size: 16px; line-height: 1.7; margin: 0;">
            Thank you for joining AURA, Egypt's premier AI-powered legal consultation platform. We're excited to help
            you navigate your legal matters with confidence and expertise.
        </p>
    </div>

    <div style="background: #f8fafc; border-radius: 12px; padding: 30px; margin: 30px 0; border: 1px solid #e2e8f0;">
        <h2 style="color: #1a202c; font-size: 24px; font-weight: 700; margin: 0 0 20px 0; text-align: center;">
            🎯 What You Can Do Now
        </h2>

        <div style="display: grid; gap: 20px;">
            <div
                style="background: #ffffff; border-radius: 8px; padding: 20px; border-left: 4px solid #3b82f6; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <h3 style="color: #1e40af; font-size: 16px; font-weight: 600; margin: 0 0 8px 0;">
                    💬 AI Legal Consultation
                </h3>
                <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0;">
                    Get instant legal advice powered by advanced AI technology trained on Egyptian law.
                </p>
            </div>

            {{-- <div
                style="background: #ffffff; border-radius: 8px; padding: 20px; border-left: 4px solid #8b5cf6; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <h3 style="color: #7c3aed; font-size: 16px; font-weight: 600; margin: 0 0 8px 0;">
                    📋 Case Management
                </h3>
                <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0;">
                    Organize and track your legal matters with our comprehensive case management system.
                </p>
            </div>

            <div
                style="background: #ffffff; border-radius: 8px; padding: 20px; border-left: 4px solid #f59e0b; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <h3 style="color: #d97706; font-size: 16px; font-weight: 600; margin: 0 0 8px 0;">
                    👨‍💼 Expert Lawyers
                </h3>
                <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0;">
                    Connect with verified legal professionals for complex cases requiring human expertise.
                </p>
            </div>

            <div
                style="background: #ffffff; border-radius: 8px; padding: 20px; border-left: 4px solid #ef4444; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <h3 style="color: #dc2626; font-size: 16px; font-weight: 600; margin: 0 0 8px 0;">
                    📚 Legal Resources
                </h3>
                <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0;">
                    Access our extensive library of legal documents, templates, and educational content.
                </p>
            </div> --}}
        </div>
    </div>

    <div class="btn-container" style="text-align: center;display: flex;justify-content: center;align-items: center;">
        <a href="{{ url('/client/profile') }}" class="button"
            style="display: inline-block; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #ffffff !important; text-decoration: none; padding: 18px 40px; border-radius: 12px; font-weight: 600; font-size: 16px; letter-spacing: 0.5px; box-shadow: 0 8px 25px rgba(5, 150, 105, 0.2); transition: all 0.3s ease; margin-right: 15px;">
            🚀 Access My Dashboard
        </a>
        <a href="{{ url('/') }}" class="btn-secondary"
            style="display: inline-block; background: #fff; color: #1a202c !important; text-decoration: none; padding: 18px 40px; border-radius: 12px; font-weight: 600; font-size: 16px; letter-spacing: 0.5px; border: 2px solid #1a202c; transition: all 0.3s ease;">
            🌐 Explore Platform
        </a>
    </div>

    <div style="background: #fffbeb; border: 1px solid #fed7aa; border-radius: 8px; padding: 20px; margin: 30px 0;">
        <h3 style="color: #92400e; font-size: 16px; font-weight: 600; margin: 0 0 10px 0;">
            💡 Pro Tips for Getting Started
        </h3>
        <ul style="color: #78350f; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 20px;">
            <li>Complete your profile </li>
            <li>Start with our AI consultation for legal questions</li>
            {{-- <li>Bookmark important legal resources for future reference</li>
                <li>Set up notifications to stay updated on your cases</li> --}}
        </ul>
    </div>

    <div class="divider"
        style="height: 1px; background: linear-gradient(90deg, transparent 0%, #e2e8f0 50%, transparent 100%); margin: 40px 0;">
    </div>

    <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 20px; margin: 30px 0;">
        <h3 style="color: #0c4a6e; font-size: 16px; font-weight: 600; margin: 0 0 10px 0;">
            📞 Need Help Getting Started?
        </h3>
        <p style="color: #075985; font-size: 14px; line-height: 1.6; margin: 0 0 15px 0;">
            Our support team is here to help you make the most of AURA:
        </p>
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <a href="mailto:support@xslawyer.co" style="color: #0c4a6e; text-decoration: none; font-weight: 500;">
                📧 support@xslawyer.co
            </a>
            <a href="tel:+201234567890" style="color: #0c4a6e; text-decoration: none; font-weight: 500;">
                📱 +20 123 456 7890
            </a>
        </div>
    </div>

    <div style="text-align: center; margin: 40px 0 20px 0;">
        <p style="color: #ffffff; font-size: 16px; margin: 0 0 10px 0;">
            Welcome to the future of legal services in Egypt!
        </p>
        <p style="color: #ffffff; font-size: 16px; margin: 0;">
            Best regards,<br>
            <strong style="color: #ffffff;">The AURA Team</strong>
        </p>
    </div>

    <div style="background: #f7fafc; border-radius: 8px; padding: 15px; margin: 30px 0; text-align: center;">
        <p style="color: #718096; font-size: 12px; margin: 0;">
            Follow us for legal tips and updates:
            <a href="#" style="color: #1a202c; margin: 0 5px;">Facebook</a> |
            <a href="#" style="color: #1a202c; margin: 0 5px;">LinkedIn</a> |
            <a href="#" style="color: #1a202c; margin: 0 5px;">Twitter</a>
        </p>
    </div>
@endsection
