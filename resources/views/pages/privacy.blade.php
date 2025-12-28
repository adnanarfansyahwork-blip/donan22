@extends('layouts.app')

@section('title', 'Privacy Policy - Donan22')
@section('meta_description', 'Donan22 Privacy Policy - Learn how we collect, use, and protect your information.')
@section('canonical', route('privacy'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Privacy Policy</h1>
    
    <div class="prose prose-lg max-w-none">
        <p>Last updated: {{ date('F d, Y') }}</p>
        
        <h2>Information We Collect</h2>
        <p>
            We collect information you provide directly to us, such as when you create an account, 
            submit a comment, or contact us for support.
        </p>
        
        <h2>How We Use Your Information</h2>
        <p>We use the information we collect to:</p>
        <ul>
            <li>Provide, maintain, and improve our services</li>
            <li>Send you technical notices and support messages</li>
            <li>Respond to your comments and questions</li>
            <li>Monitor and analyze trends, usage, and activities</li>
        </ul>
        
        <h2>Information Sharing</h2>
        <p>
            We do not share your personal information with third parties except as described in this policy 
            or with your consent.
        </p>
        
        <h2>Cookies</h2>
        <p>
            We use cookies and similar technologies to collect information about your browsing activities 
            and to provide you with a better experience on our site.
        </p>
        
        <h2>Contact Us</h2>
        <p>
            If you have any questions about this Privacy Policy, please contact us at 
            <a href="mailto:privacy@donan22.com">privacy@donan22.com</a>.
        </p>
    </div>
</div>
@endsection
