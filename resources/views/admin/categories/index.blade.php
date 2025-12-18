@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
        <p class="text-gray-700 mt-1">Manage post categories</p>
    </div>
    <button onclick="openModal()" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium">
        <i class="bi bi-plus mr-1"></i> New Category
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posts</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            @if($category->image_url)
                                <img src="{{ $category->image_url }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 bg-{{ ['blue', 'green', 'purple', 'orange'][$loop->index % 4] }}-100 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-folder text-{{ ['blue', 'green', 'purple', 'orange'][$loop->index % 4] }}-600"></i>
                                </div>
                            @endif
                            <span class="font-medium text-gray-900">{{ $category->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $category->slug }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $category->posts_count }}</td>
                    <td class="px-6 py-4">
                        @if($category->is_active)
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Active</span>
                        @else
                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" class="edit-category-btn p-2 text-gray-400 hover:text-primary-600" title="Edit"
                                    data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}"
                                    data-description="{{ $category->description }}"
                                    data-is-active="{{ $category->is_active ? '1' : '0' }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="bi bi-folder text-4xl"></i>
                        <p class="mt-2">No categories found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($categories->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $categories->links() }}
        </div>
    @endif
</div>

<!-- Modal -->
<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">
        <form id="categoryForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>
            
            <div class="p-6 border-b">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">New Category</h3>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="categoryName" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="categoryDescription" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700">
                </div>
                
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" id="categoryActive" value="1" checked
                               class="w-4 h-4 text-primary-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>
            
            <div class="p-6 border-t bg-gray-50 flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const modal = document.getElementById('categoryModal');
    const form = document.getElementById('categoryForm');
    const methodField = document.getElementById('methodField');
    
    function openModal() {
        form.action = '{{ route("admin.categories.store") }}';
        methodField.innerHTML = '';
        document.getElementById('modalTitle').textContent = 'New Category';
        document.getElementById('categoryName').value = '';
        document.getElementById('categoryDescription').value = '';
        document.getElementById('categoryActive').checked = true;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function editCategory(id, name, description, isActive) {
        form.action = '/admin/categories/' + id;
        methodField.innerHTML = '@method("PUT")';
        document.getElementById('modalTitle').textContent = 'Edit Category';
        document.getElementById('categoryName').value = name;
        document.getElementById('categoryDescription').value = description || '';
        document.getElementById('categoryActive').checked = isActive === '1';
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
    
    // Event delegation for edit buttons
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.edit-category-btn');
        if (btn) {
            editCategory(
                btn.dataset.id,
                btn.dataset.name,
                btn.dataset.description,
                btn.dataset.isActive
            );
        }
    });
</script>
@endpush
@endsection
