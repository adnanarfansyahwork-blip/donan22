@extends('admin.layouts.app')

@section('title', 'View Administrator')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Administrator Details</h1>
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900">
            &larr; Back to List
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="space-y-4">
            <div class="flex items-center gap-4 pb-4 border-b">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-2xl font-bold text-blue-600">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $user->username }}</h2>
                    <p class="text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Full Name</label>
                    <p class="text-gray-900">{{ $user->full_name ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Role</label>
                    <p class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Status</label>
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Last Login</label>
                    <p class="text-gray-900">{{ $user->last_login ?? 'Never' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Created At</label>
                    <p class="text-gray-900">{{ $user->created_at ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Updated At</label>
                    <p class="text-gray-900">{{ $user->updated_at ?? '-' }}</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit</a>
            </div>
        </div>
    </div>
</div>
@endsection