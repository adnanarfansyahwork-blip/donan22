@extends('layouts.app')

@section('title', 'Unsubscribe - ' . config('app.name'))
@section('robots', 'noindex, nofollow')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8 text-center">
        @if($success)
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        @else
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        @endif

        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            {{ $success ? 'Unsubscribed' : 'Error' }}
        </h2>
        
        <p class="text-gray-600 mb-8">{{ $message }}</p>

        <a href="{{ route('home') }}" 
           class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Back to Home
        </a>
    </div>
</div>
@endsection
