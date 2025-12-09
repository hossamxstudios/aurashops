@extends('emails.layouts.master')

@section('title', 'Verify Your Email Address')

@section('content')
    <h2>Verify Your Email Address</h2>
    <p>Please click the button below to verify your email address and activate your account.</p>
    <p style="text-align: center;">
        <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
    </p>
    <p>If you did not create an account, no further action is required.</p>
    <br>
    <p>Best regards,</p>
    <p><strong>The  AURATeam</strong></p>
@endsection
