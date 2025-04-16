<?php

use App\Livewire\Setting\User\IndexUser;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('setting')->group(function() {
    Route::get('/user', IndexUser::class)->name('user.index');
});

Route::redirect('settings', 'settings/profile');
Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
Volt::route('settings/password', 'settings.password')->name('settings.password');
Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
