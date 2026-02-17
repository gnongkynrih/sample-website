<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/admin/hero-section', 'admin.⚡hero-section-management')
    ->name('admin.hero-section');

Route::livewire('/admin/room-type', 'admin.⚡room-type-management')
    ->name('admin.room-type');
Route::livewire('/admin/room', 'admin.⚡room-management')
    ->name('admin.room');

Route::livewire('/admin/about', 'admin.⚡about-management')
    ->name('admin.about');

Route::livewire('/about', '⚡about')
    ->name('about');

Route::livewire('/alpine', '⚡alpine-demo')
    ->name('alpine');

Route::livewire('/', '⚡homepage')
    ->name('homepage');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
