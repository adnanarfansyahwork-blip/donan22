@extends('admin.layouts.app')

@section('title', 'Post Types')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Post Types</h1>
        <p class="text-gray-700 mt-1">Manage content types (software, mobile apps, tutorials, etc.)</p>
    </div>
    <button onclick="openModal()" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium">
        <i class="bi bi-plus mr-1"></i> New Post Type
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Post Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posts</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($postTypes as $type)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-{{ $type->icon ?? 'file-earmark' }} text-indigo-600"></i>
                            </div>
                            <div>
                                <span class="font-medium text-gray-900">{{ $type->name }}</span>
                                @if($type->description)
                                    <p class="text-sm text-gray-500 truncate max-w-xs">{{ $type->description }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <code class="bg-gray-100 px-2 py-1 rounded">{{ $type->slug }}</code>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-gray-900">{{ $type->posts_count }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($type->is_active)
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Active</span>
                        @else
                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" class="edit-btn p-2 text-gray-400 hover:text-primary-600" title="Edit"
                                    data-id="{{ $type->id }}"
                                    data-name="{{ $type->name }}"
                                    data-description="{{ $type->description }}"
                                    data-icon="{{ $type->icon }}"
                                    data-is-active="{{ $type->is_active ? '1' : '0' }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            @if($type->posts_count == 0)
                                <form action="{{ route('admin.post-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Delete this post type?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @else
                                <span class="p-2 text-gray-300 cursor-not-allowed" title="Cannot delete - has posts">
                                    <i class="bi bi-trash"></i>
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="bi bi-file-earmark-text text-4xl"></i>
                        <p class="mt-2">No post types found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($postTypes->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $postTypes->links() }}
        </div>
    @endif
</div>

<!-- Modal -->
<div id="typeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">
        <form id="typeForm" method="POST">
            @csrf
            <div id="methodField"></div>
            
            <div class="p-6 border-b">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">New Post Type</h3>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="typeName" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="e.g., Software, Mobile Apps, Tutorial">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="typeDescription" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                              placeholder="Brief description of this post type"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icon (Bootstrap Icons)</label>
                    <div class="flex items-center space-x-2">
                        <input type="text" name="icon" id="typeIcon"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="e.g., laptop, phone, book">
                        <div id="iconPreview" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="bi bi-file-earmark text-gray-500"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        <a href="https://icons.getbootstrap.com/" target="_blank" class="text-primary-600 hover:underline">Browse icons →</a>
                    </p>
                </div>
                
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" id="typeActive" value="1" checked
                               class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>
            
            <div class="p-6 border-t bg-gray-50 flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const modal = document.getElementById('typeModal');
    const form = document.getElementById('typeForm');
    const methodField = document.getElementById('methodField');
    const iconInput = document.getElementById('typeIcon');
    const iconPreview = document.getElementById('iconPreview');
    
    // Icon preview
    iconInput.addEventListener('input', function() {
        const iconName = this.value.trim() || 'file-earmark';
        iconPreview.innerHTML = `<i class="bi bi-${iconName} text-indigo-600"></i>`;
    });
    
    function openModal() {
        form.action = '{{ route("admin.post-types.store") }}';
        methodField.innerHTML = '';
        document.getElementById('modalTitle').textContent = 'New Post Type';
        document.getElementById('typeName').value = '';
        document.getElementById('typeDescription').value = '';
        document.getElementById('typeIcon').value = '';
        document.getElementById('typeActive').checked = true;
        iconPreview.innerHTML = '<i class="bi bi-file-earmark text-gray-500"></i>';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function editType(id, name, description, icon, isActive) {
        form.action = '/admin/post-types/' + id;
        methodField.innerHTML = '@method("PUT")';
        document.getElementById('modalTitle').textContent = 'Edit Post Type';
        document.getElementById('typeName').value = name;
        document.getElementById('typeDescription').value = description || '';
        document.getElementById('typeIcon').value = icon || '';
        document.getElementById('typeActive').checked = isActive === '1';
        iconPreview.innerHTML = `<i class="bi bi-${icon || 'file-earmark'} text-indigo-600"></i>`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });
    
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.edit-btn');
        if (btn) {
            editType(
                btn.dataset.id,
                btn.dataset.name,
                btn.dataset.description,
                btn.dataset.icon,
                btn.dataset.isActive
            );
        }
    });
</script>
@endpush
@endsection
