<?php

use App\Http\Controllers\Filepond\FilepondController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/upload_avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');

    Route::get('/2fa', function(){
        return view('users.2fa');
    })->name('users.2fa');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'filepond', 'as' => 'filepond.'], function () {
    Route::post('/process', [FilepondController::class, 'process'])->name('process');
    Route::match(['PUT', 'PATCH'], '/patch', [FilepondController::class, 'patch'])->name('patch');
    Route::get('/head', [FilepondController::class, 'head'])->name('head');
    Route::delete('/revert', [FilepondController::class, 'revert'])->name('revert');

});




require __DIR__.'/auth.php';