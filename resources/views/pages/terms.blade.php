@extends('layouts.app')

@section('title', 'Terms of Service - Donan22')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Terms of Service</h1>
    
    <div class="prose prose-lg max-w-none">
        <p>Last updated: {{ date('F d, Y') }}</p>
        
        <h2>Acceptance of Terms</h2>
        <p>
            By accessing and using Donan22, you accept and agree to be bound by the terms and 
            provision of this agreement.
        </p>
        
        <h2>Use of Service</h2>
        <p>
            You agree to use our service only for lawful purposes and in accordance with these Terms. 
            You agree not to:
        </p>
        <ul>
            <li>Use the service in any way that violates any applicable law or regulation</li>
            <li>Engage in any conduct that restricts or inhibits anyone's use of the service</li>
            <li>Attempt to gain unauthorized access to any portion of the service</li>
            <li>Use the service to distribute malware or other harmful content</li>
        </ul>
        
        <h2>Content</h2>
        <p>
            All content provided on this website is for informational purposes only. We make no 
            representations as to the accuracy or completeness of any information.
        </p>
        
        <h2>Downloads</h2>
        <p>
            While we make every effort to ensure all downloads are safe and virus-free, we recommend 
            scanning all downloaded files with your antivirus software before use.
        </p>
        
        <h2>Limitation of Liability</h2>
        <p>
            Donan22 shall not be liable for any indirect, incidental, special, consequential, or 
            punitive damages resulting from your use of or inability to use the service.
        </p>
        
        <h2>Contact</h2>
        <p>
            If you have any questions about these Terms, please contact us at 
            <a href="mailto:legal@donan22.com">legal@donan22.com</a>.
        </p>
    </div>
</div>
@endsection
