<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>403 - Forbidden</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css'])
    @else
        <link rel="stylesheet" href="/build/assets/app-Dh07Ywdd.css">
    @endif
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-200">403</h1>
        <p class="text-2xl font-semibold text-gray-800 mt-4">Access Forbidden</p>
        <p class="text-gray-500 mt-2">You don't have permission to access this page.</p>
        <a href="{{ url('/') }}" class="inline-block mt-6 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium">
            Go Home
        </a>
    </div>
</body>
</html>
