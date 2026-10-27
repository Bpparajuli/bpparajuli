<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminProjectImageController;
use App\Http\Controllers\Admin\AdminExperienceController;
use App\Http\Controllers\Admin\AdminHomepageController;
use App\Http\Controllers\Admin\AdminMediaController;
use App\Http\Controllers\Admin\AdminNavigationController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminSkillCategoryController;
use App\Http\Controllers\Admin\AdminSkillController;
use App\Http\Controllers\Admin\AdminSocialController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        Route::get('/homepage', [AdminHomepageController::class, 'index'])->name('homepage.index');
        Route::put('/homepage', [AdminHomepageController::class, 'update'])->name('homepage.update');
        Route::post('/homepage/reorder', [AdminHomepageController::class, 'reorder'])->name('homepage.reorder');
        Route::resource('currently', \App\Http\Controllers\Admin\AdminCurrentlyController::class)->except('show');

        Route::resource('projects', AdminProjectController::class)->except('show');
        Route::delete('projects/{project}/images/{image}', [AdminProjectImageController::class, 'destroy'])->name('projects.images.destroy');

        Route::resource('project-categories', \App\Http\Controllers\Admin\AdminProjectCategoryController::class)->except('show');

        Route::resource('services', AdminServiceController::class)->except('show');

        Route::resource('skills', AdminSkillController::class)->except('show');
        Route::resource('skill-categories', AdminSkillCategoryController::class)->except('show');

        Route::resource('experiences', AdminExperienceController::class)->except('show');

        Route::get('/media/picker', [AdminMediaController::class, 'picker'])->name('media.picker');
        Route::post('/media/upload', [AdminMediaController::class, 'upload'])->name('media.upload');
        Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
        Route::put('/media/{medium}', [AdminMediaController::class, 'update'])->name('media.update');
        Route::delete('/media/{medium}', [AdminMediaController::class, 'destroy'])->name('media.destroy');

        Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
        Route::patch('/messages/{message}/status', [AdminMessageController::class, 'updateStatus'])->name('messages.status');
        Route::delete('/messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

        Route::resource('pages', AdminPageController::class)->except('show');

        Route::resource('social-links', AdminSocialController::class)->except('show');

        Route::resource('navigation', AdminNavigationController::class)->except('show');

        Route::get('/settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');

        Route::resource('users', AdminUserController::class)->except('show');
    });
