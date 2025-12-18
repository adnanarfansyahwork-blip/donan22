<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $postId = $this->route('post')?->id;
        
        return [
            'title' => 'required|string|max:500',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:1000',
            'status' => 'required|in:draft,published,scheduled,pending',
            'category_id' => 'required|exists:categories,id',
            'post_type_id' => 'nullable|exists:post_types,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url|max:500',
            'is_indexable' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'scheduled_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'software' => 'nullable|array',
            'software.version' => 'nullable|string|max:100',
            'software.developer' => 'nullable|string|max:255',
            'software.platform' => 'nullable|string|max:100',
            'software.license_type' => 'nullable|string|max:100',
            'software.file_size' => 'nullable|string|max:100',
            'software.official_website' => 'nullable|url|max:500',
            'software.system_requirements' => 'nullable|string',
            'software.whats_new' => 'nullable|string',
            'download_links' => 'nullable|array',
            'download_links.*.name' => 'nullable|string|max:255',
            'download_links.*.url' => 'nullable|url|max:500',
            'download_links.*.provider' => 'nullable|string|max:100',
            'download_links.*.file_size' => 'nullable|string|max:50',
            'download_links.*.password' => 'nullable|string|max:100',
        ];
    }

    public function validatedWithDefaults(): array
    {
        $data = $this->validated();
        
        // Set defaults
        $data['is_indexable'] = $this->boolean('is_indexable', true);
        $data['allow_comments'] = $this->boolean('allow_comments', true);
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        
        // Set published_at for published posts
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        
        return $data;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul post wajib diisi.',
            'content.required' => 'Konten post wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'featured_image.image' => 'File harus berupa gambar.',
            'featured_image.max' => 'Ukuran gambar maksimal 5MB.',
        ];
    }
}