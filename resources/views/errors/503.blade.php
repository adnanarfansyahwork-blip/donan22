<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>503 - Service Unavailable</title>
    @if (file_exists(public_path('build/manifest.json')))
        <link rel="stylesheet" href="/build/assets/app-Dh07Ywdd.css">
    @else
        <link rel="stylesheet" href="/build/assets/app-Dh07Ywdd.css">
    @endif
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-200">503</h1>
        <p class="text-2xl font-semibold text-gray-800 mt-4">Service Unavailable</p>
        <p class="text-gray-500 mt-2">We're currently performing maintenance. Please check back soon.</p>
        <div class="mt-6">
            <button onclick="location.reload()" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                Refresh Page
            </button>
        </div>
    </div>
</body>
</html>
