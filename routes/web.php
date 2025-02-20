<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\Filepond\FilepondController;
use App\Http\Controllers\Files\DownloadFileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\NotificationPreferenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('email_verified', function () {
    return view('email_verified');
});

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware(['auth', 'verified', 'activity'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/upload_avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');

    Route::get('/2fa', function () {
        return view('users.2fa');
    })->name('users.2fa');
});

Route::group(['middleware' => ['auth', 'activity'], 'prefix' => 'filepond', 'as' => 'filepond.'], function () {
    Route::post('/process', [FilepondController::class, 'process'])->name('process');
    Route::match(['PUT', 'PATCH'], '/patch', [FilepondController::class, 'patch'])->name('patch');
    Route::get('/head', [FilepondController::class, 'head'])->name('head');
    Route::delete('/revert', [FilepondController::class, 'revert'])->name('revert');

});

Route::group(['middleware' => ['auth', 'activity']], function () {
    Route::get('downloadMedia/{media}', [DownloadFileController::class, 'downloadMedia'])->name('media.download');

});

Route::middleware(['auth', 'admin', 'activity'])->group(function () {
    Route::group(['prefix' => 'system_admin'], function () {
        Route::resource('users', UserController::class);

    });
});

Route::group(['middleware' => 'auth', 'activity'], function () {
    Route::resource('vehicles', VehicleController::class);
    Route::resource('incomes', IncomeController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('notification_preferences', NotificationPreferenceController::class);

});

require __DIR__.'/auth.php';
