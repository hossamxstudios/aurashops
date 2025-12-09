@extends('emails.layouts.master')

@section('title', $subject)

@section('content')
    {!! $body !!}
@endsection
