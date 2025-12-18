<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function image(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,gif,webp|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            
            // Create directory if not exists
            $uploadPath = public_path('uploads/posts');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Save directly to public/uploads/posts
            $file->move($uploadPath, $filename);
            $path = 'uploads/posts/' . $filename;

            return response()->json([
                'success' => true,
                'location' => asset($path),
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'No file uploaded',
        ], 400);
    }
}