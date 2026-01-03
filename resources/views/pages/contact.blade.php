@extends('layouts.app')

@section('title', 'Hubungi Kami - Donan22 Support')
@section('meta_description', 'Hubungi tim Donan22 untuk pertanyaan, saran, atau kerjasama. Kami siap membantu Anda dengan kebutuhan software dan tutorial IT.')
@section('meta_keywords', 'kontak donan22, hubungi kami, customer support, bantuan download')
@section('canonical', route('contact'))

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-4">Contact Us</h1>
        <p class="text-xl text-primary-100">Have questions? We'd love to hear from you.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Contact Form -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a message</h2>
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <input type="text" name="subject" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea name="message" rows="5" required 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>
                <button type="submit" class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                    Send Message
                </button>
            </form>
        </div>
        
        <!-- Contact Info -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in touch</h2>
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-envelope text-xl text-primary-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Email</h3>
                        <p class="text-gray-600">contact@donan22.com</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-clock text-xl text-primary-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Response Time</h3>
                        <p class="text-gray-600">We typically respond within 24-48 hours</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t">
                <h3 class="font-semibold text-gray-900 mb-4">Follow us</h3>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
