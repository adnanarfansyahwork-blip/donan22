<?php

use Illuminate\Support\Facades\Route;

// Redirect public login to admin login
Route::get('login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Logout uses admin logout
Route::post('logout', function () {
    return redirect()->route('admin.logout');
})->name('logout');
