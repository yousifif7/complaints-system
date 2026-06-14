<?php

use App\Http\Controllers\TranslationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/', [CatController::class, 'index'])->name('home');
Route::get('/complaints', [CatController::class, 'index'])->name('complaints.index');
Route::get('/complaints/cat/{id}', [CatController::class, 'cat'])->name('category.cat');

Route::post('/form', [FormController::class, 'store'])->name('form.store');
Route::get('/form/{id}', [FormController::class, 'show'])->name('form.show');

Route::prefix('track')->name('complaints.track.')->group(function () {
    Route::get('/', [TrackingController::class, 'index'])->name('index');
    Route::post('/', [TrackingController::class, 'lookup'])->name('lookup');
    Route::get('/{ticketNumber}', [TrackingController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/admins', [UserController::class, 'index'])->name('login');
Route::post('/loginAdmin', [UserController::class, 'loginAdmin'])->name('loginAdmin');
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('admins')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/translate', [TranslationController::class, 'translate'])->name('translate');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/forms', [FormController::class, 'requests'])->name('forms');
    Route::get('/export', [ExportController::class, 'complaints'])->name('export');
    Route::get('/delete', [FormController::class, 'deleteAll'])->name('forms.delete');
    Route::get('/deletecomp', [FormController::class, 'deleteCompleted'])->name('forms.deletecomp');

    Route::get('/createcat', [CatController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CatController::class, 'storeCat'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CatController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CatController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CatController::class, 'destroy'])->name('categories.destroy');

    Route::get('/createreq_type', [RequestTypeController::class, 'create'])->name('requesttypes.create');
    Route::post('/requesttypes', [RequestTypeController::class, 'store'])->name('requesttypes.store');
    Route::get('/requesttypes/{requesttype}/edit', [RequestTypeController::class, 'edit'])->name('requesttypes.edit');
    Route::put('/requesttypes/{requesttype}', [RequestTypeController::class, 'update'])->name('requesttypes.update');
    Route::delete('/requesttypes/{requesttype}', [RequestTypeController::class, 'destroy'])->name('requesttypes.destroy');

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::put('/forms/{form}', [FormController::class, 'update'])->name('forms.update');
    Route::delete('/forms/{form}', [FormController::class, 'destroy'])->name('forms.destroy');
});
