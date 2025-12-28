<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>500 - Server Error</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css'])
    @else
        <link rel="stylesheet" href="/build/assets/app-C6uQa5Od.css">
    @endif
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-200">500</h1>
        <p class="text-2xl font-semibold text-gray-800 mt-4">Server Error</p>
        <p class="text-gray-500 mt-2">Something went wrong on our end. Please try again later.</p>
        <div class="mt-6 space-x-4">
            <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                Go Home
            </a>
            <button onclick="location.reload()" class="inline-block px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium">
                Try Again
            </button>
        </div>
    </div>
</body>
</html>
