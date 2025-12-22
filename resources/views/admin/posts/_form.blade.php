@php
    $isEdit = isset($post) && $post->exists;
    $formAction = $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store');
    $formMethod = $isEdit ? 'PUT' : 'POST';
@endphp

<form action="{{ $formAction }}" 
      method="POST" 
      enctype="multipart/form-data"
      x-data="postForm()"
      @submit="handleSubmit">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif
    
    <!-- Header with Actions -->
    <div class="sticky top-0 bg-gray-100 py-4 px-4 -mx-4 mb-6 z-40 shadow-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.posts.index') }}" 
                   class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">
                        {{ $isEdit ? 'Edit Post' : 'Buat Post Baru' }}
                    </h1>
                    <p class="text-sm text-gray-500">
                        {{ $isEdit ? 'Perbarui post yang sudah ada' : 'Buat post baru untuk website Anda' }}
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.posts.index') }}" 
                   class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        name="status" 
                        value="draft"
                        class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg font-medium transition-colors">
                    <i class="bi bi-save mr-1"></i> Simpan Draft
                </button>
                <button type="submit" 
                        name="status" 
                        value="published"
                        class="px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                    <i class="bi bi-check-circle mr-1"></i> 
                    {{ $isEdit ? 'Update & Publish' : 'Publish Sekarang' }}
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center">
            <i class="bi bi-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            <div class="flex items-center mb-2">
                <i class="bi bi-exclamation-triangle mr-2"></i>
                <strong>Terdapat kesalahan:</strong>
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content Column -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Title -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title"
                       name="title" 
                       value="{{ old('title', $post->title ?? '') }}" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg @error('title') border-red-500 @enderror"
                       placeholder="Masukkan judul post">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Content -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Konten <span class="text-red-500">*</span>
                </label>
                <textarea id="content"
                          name="content" 
                           
                          required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm @error('content') border-red-500 @enderror"
                          placeholder="Tulis konten post di sini...">{{ old('content', $post->content ?? '') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-2">Mendukung format HTML untuk styling</p>
            </div>
            
            <!-- Excerpt -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                    Ringkasan (Opsional)
                </label>
                <textarea id="excerpt"
                          name="excerpt" 
                          rows="3"
                          maxlength="1000"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Deskripsi singkat post (akan tampil di halaman list)">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-2">Maksimal 1000 karakter</p>
            </div>
            
            <!-- Software Details -->
            <div class="bg-white rounded-xl shadow-sm p-6" x-data="{ showSoftware: {{ ($isEdit && $post->softwareDetail) || old('software') ? 'true' : 'false' }} }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="bi bi-app-indicator mr-2"></i>Detail Software
                    </h3>
                    <button type="button" 
                            @click="showSoftware = !showSoftware" 
                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        <span x-text="showSoftware ? 'Sembunyikan' : 'Tampilkan'"></span>
                    </button>
                </div>
                <p class="text-sm text-gray-500 mb-4">Isi jika post ini adalah software atau aplikasi</p>
                
                <div x-show="showSoftware" x-collapse class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Versi</label>
                            <input type="text" 
                                   name="software[version]" 
                                   value="{{ old('software.version', $post->softwareDetail->version ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                                   placeholder="contoh: 1.0.0">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Developer</label>
                            <input type="text" 
                                   name="software[developer]" 
                                   value="{{ old('software.developer', $post->softwareDetail->developer ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                   placeholder="Nama developer">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Platform</label>
                            <select name="software[platform]" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Platform</option>
                                @foreach(\App\Models\SoftwareDetail::platforms() as $value => $label)
                                    <option value="{{ $value }}" {{ old('software.platform', $post->softwareDetail->platform ?? '') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Lisensi</label>
                            <select name="software[license_type]" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Lisensi</option>
                                @foreach(\App\Models\SoftwareDetail::licenseTypes() as $value => $label)
                                    <option value="{{ $value }}" {{ old('software.license_type', $post->softwareDetail->license_type ?? '') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Ukuran File</label>
                            <input type="text" 
                                   name="software[file_size]" 
                                   value="{{ old('software.file_size', $post->softwareDetail->file_size ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                                   placeholder="contoh: 150 MB">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Website Resmi</label>
                            <input type="url" 
                                   name="software[official_website]" 
                                   value="{{ old('software.official_website', $post->softwareDetail->official_website ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                   placeholder="https://example.com">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">System Requirements</label>
                        <textarea name="software[system_requirements]" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                  placeholder="Kebutuhan sistem minimum...">{{ old('software.system_requirements', $post->softwareDetail->system_requirements ?? '') }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">What's New</label>
                        <textarea name="software[whats_new]" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                  placeholder="Fitur baru di versi ini...">{{ old('software.whats_new', $post->softwareDetail->whats_new ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Download Links -->
            @php
                $downloadLinksData = old('download_links', $isEdit && $post->downloadLinks 
                    ? $post->downloadLinks->map(function($l) {
                        return [
                            'name' => $l->name,
                            'url' => $l->url,
                            'provider' => $l->provider,
                            'file_size' => $l->file_size,
                            'password' => $l->password,
                        ];
                    })->toArray()
                    : [['name' => '', 'url' => '', 'provider' => '', 'file_size' => '', 'password' => '']]
                );
            @endphp
            <div class="bg-white rounded-xl shadow-sm p-6" 
                 x-data="downloadLinks({{ json_encode($downloadLinksData) }})">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="bi bi-download mr-2"></i>Link Download
                    </h3>
                    <button type="button" 
                            @click="addLink()" 
                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        <i class="bi bi-plus-lg"></i> Tambah Link
                    </button>
                </div>
                
                <div class="space-y-4">
                    <template x-for="(link, index) in links" :key="index">
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-medium text-gray-700" x-text="'Link #' + (index + 1)"></span>
                                <button type="button" 
                                        @click="removeLink(index)" 
                                        x-show="links.length > 1"
                                        class="text-red-500 hover:text-red-700 text-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Nama Link</label>
                                    <input type="text" 
                                           :name="'download_links[' + index + '][name]'" 
                                           x-model="link.name"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                                           placeholder="contoh: Google Drive">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">URL <span class="text-red-500">*</span></label>
                                    <input type="url" 
                                           :name="'download_links[' + index + '][url]'" 
                                           x-model="link.url"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                                           placeholder="https://...">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Provider</label>
                                    <select :name="'download_links[' + index + '][provider]'" 
                                            x-model="link.provider"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih Provider</option>
                                        @foreach(\App\Models\DownloadLink::providers() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Ukuran File</label>
                                    <input type="text" 
                                           :name="'download_links[' + index + '][file_size]'" 
                                           x-model="link.file_size"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                                           placeholder="contoh: 500 MB">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs text-gray-500 mb-1">Password (jika ada)</label>
                                    <input type="text" 
                                           :name="'download_links[' + index + '][password]'" 
                                           x-model="link.password"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                                           placeholder="Password file (opsional)">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- SEO Settings -->
            <div class="bg-white rounded-xl shadow-sm p-6" x-data="{ showSeo: {{ old('meta_title') || old('meta_description') || ($isEdit && ($post->meta_title || $post->meta_description)) ? 'true' : 'false' }} }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="bi bi-search mr-2"></i>Pengaturan SEO
                    </h3>
                    <button type="button" 
                            @click="showSeo = !showSeo" 
                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        <span x-text="showSeo ? 'Sembunyikan' : 'Tampilkan'"></span>
                    </button>
                </div>
                
                <div x-show="showSeo" x-collapse class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Meta Title</label>
                        <input type="text" 
                               name="meta_title" 
                               value="{{ old('meta_title', $post->meta_title ?? '') }}"
                               maxlength="255"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                               placeholder="Kosongkan untuk menggunakan judul post">
                        <p class="text-xs text-gray-500 mt-1">Maksimal 60 karakter disarankan</p>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Meta Description</label>
                        <textarea name="meta_description" 
                                  rows="3"
                                  maxlength="500"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                                  placeholder="Deskripsi untuk hasil pencarian Google">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Maksimal 160 karakter disarankan</p>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Meta Keywords</label>
                        <input type="text" 
                               name="meta_keywords" 
                               value="{{ old('meta_keywords', $post->meta_keywords ?? '') }}"
                               maxlength="255"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                               placeholder="keyword1, keyword2, keyword3">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Canonical URL</label>
                        <input type="url" 
                               name="canonical_url" 
                               value="{{ old('canonical_url', $post->canonical_url ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                               placeholder="https://... (opsional)">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Column -->
        <div class="space-y-6">
            
            <!-- Post Type & Category -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Klasifikasi</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Post <span class="text-red-500">*</span>
                        </label>
                        <select name="post_type_id" 
                                required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('post_type_id') border-red-500 @enderror">
                            <option value="">Pilih Tipe</option>
                            @foreach($postTypes as $type)
                                <option value="{{ $type->id }}" {{ old('post_type_id', $post->post_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('post_type_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Publishing Options -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Publishing</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            @foreach(\App\Models\Post::getStatuses() as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $post->status ?? 'draft') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publish</label>
                        <input type="datetime-local" 
                               name="published_at" 
                               value="{{ old('published_at', $isEdit && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan untuk publish langsung</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jadwalkan</label>
                        <input type="datetime-local" 
                               name="scheduled_at" 
                               value="{{ old('scheduled_at', $isEdit && $post->scheduled_at ? $post->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Untuk status "Scheduled"</p>
                    </div>
                </div>
            </div>
            
            <!-- Featured Image -->
            <div class="bg-white rounded-xl shadow-sm p-6" x-data="imageUpload()">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Gambar Utama</h3>
                
                <!-- Preview -->
                <div class="mb-4">
                    @if($isEdit && $post->featured_image)
                        <div class="relative" x-show="!removeImage">
                            <img src="{{ $post->featured_image_url }}" 
                                 alt="{{ $post->title }}"
                                 class="w-full h-40 object-cover rounded-lg"
                                >
                            <button type="button" 
                                    @click="removeImage = true"
                                    class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <input type="hidden" name="remove_featured_image" :value="removeImage ? 1 : 0">
                    @endif
                    
                    <!-- New image preview -->
                    <div x-show="previewUrl" class="relative">
                        <img :src="previewUrl" 
                             alt="Preview"
                             class="w-full h-40 object-cover rounded-lg">
                        <button type="button" 
                                @click="clearPreview()"
                                class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
                
                <input type="file" 
                       name="featured_image" 
                       accept="image/*"
                       @change="handleFileSelect($event)"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer">
                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, GIF. Maksimal 5MB</p>
                @error('featured_image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Options -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Opsi</h3>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_featured" 
                               value="1" 
                               {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Post Unggulan</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_trending" 
                               value="1" 
                               {{ old('is_trending', $post->is_trending ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Post Trending</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="allow_comments" 
                               value="1" 
                               {{ old('allow_comments', $post->allow_comments ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Izinkan Komentar</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="show_toc" 
                               value="1" 
                               {{ old('show_toc', $post->show_toc ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Tampilkan Daftar Isi</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_indexable" 
                               value="1" 
                               {{ old('is_indexable', $post->is_indexable ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Izinkan Indexing (SEO)</span>
                    </label>
                </div>
            </div>
            
            <!-- Tags -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags</h3>
                @if($tags->count() > 0)
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @php
                            $selectedTags = old('tags', $isEdit ? $post->tags->pluck('id')->toArray() : []);
                        @endphp
                        @foreach($tags as $tag)
                            <label class="flex items-center p-2 rounded hover:bg-gray-50">
                                <input type="checkbox" 
                                       name="tags[]" 
                                       value="{{ $tag->id }}" 
                                       {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">Belum ada tag tersedia.</p>
                @endif
            </div>
            
            <!-- Post Info (for edit) -->
            @if($isEdit)
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">ID:</span>
                            <span class="font-medium">{{ $post->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Slug:</span>
                            <span class="font-medium text-xs">{{ $post->slug }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Views:</span>
                            <span class="font-medium">{{ number_format($post->views_count) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Downloads:</span>
                            <span class="font-medium">{{ number_format($post->downloads_count) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Dibuat:</span>
                            <span class="font-medium">{{ $post->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Diupdate:</span>
                            <span class="font-medium">{{ $post->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</form>

@push('scripts')
@verbatim
<script>
$(document).ready(function() {
    $('#content').summernote({
        height: 500,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        fontNames: ['Arial', 'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana', 'Segoe UI'],
        fontNamesIgnoreCheck: ['Segoe UI'],
        styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote', 'pre'],
        placeholder: 'Tulis konten post di sini...',
        tabsize: 2,
        lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0']
    });
});
</script>
@endverbatim
<script>
function postForm() {
    return {
        handleSubmit(e) {
            // Add any pre-submit validation here
        }
    }
}

function downloadLinks(initialLinks) {
    return {
        links: initialLinks || [{ name: '', url: '', provider: '', file_size: '', password: '' }],
        addLink() {
            this.links.push({ name: '', url: '', provider: '', file_size: '', password: '' });
        },
        removeLink(index) {
            this.links.splice(index, 1);
        }
    }
}

function imageUpload() {
    return {
        previewUrl: null,
        removeImage: false,
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.previewUrl = URL.createObjectURL(file);
                this.removeImage = false;
            }
        },
        clearPreview() {
            this.previewUrl = null;
            const input = this.$el.querySelector('input[type="file"]');
            if (input) input.value = '';
        }
    }
}
</script>
@endpush
