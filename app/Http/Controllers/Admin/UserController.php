<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = Administrator::latest()->paginate(20);
        $roles = ['admin', 'super_admin', 'editor', 'moderator'];
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create(): View
    {
        $roles = ['admin', 'super_admin', 'editor', 'moderator'];
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:administrators,username',
            'email' => 'required|email|unique:administrators,email',
            'full_name' => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        Administrator::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'full_name' => $validated['full_name'] ?? null,
            'password_hash' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Administrator created successfully.');
    }

    public function show(Administrator $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(Administrator $user): View
    {
        $roles = ['admin', 'super_admin', 'editor', 'moderator'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, Administrator $user): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:administrators,username,' . $user->id,
            'email' => 'required|email|unique:administrators,email,' . $user->id,
            'full_name' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'role' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $updateData = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'full_name' => $validated['full_name'] ?? null,
            'role' => $validated['role'],
            'status' => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password_hash'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'Administrator updated successfully.');
    }

    public function destroy(Administrator $user): RedirectResponse
    {
        if ($user->id === Auth::guard('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Administrator deleted successfully.');
    }

    public function profile(): View
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var Administrator $user */
        $user = Auth::guard('admin')->user();

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:administrators,username,' . $user->id,
            'email' => 'required|email|unique:administrators,email,' . $user->id,
            'full_name' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        $updateData = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'full_name' => $validated['full_name'] ?? null,
        ];

        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password_hash)) {
                return back()->with('error', 'Current password is incorrect.');
            }
            $updateData['password_hash'] = Hash::make($validated['new_password']);
        }

        $user->update($updateData);

        return back()->with('success', 'Profile updated successfully.');
    }
}