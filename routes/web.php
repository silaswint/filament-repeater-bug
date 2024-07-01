<?php

// filament.admin.auth.login should has "login" as alias
use Illuminate\Support\Facades\Route;

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
