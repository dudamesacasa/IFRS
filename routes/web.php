<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
// Route::get('/documents/compartilhados', [DocumentController::class, 'compartilhados'])->name('compartilhados');
Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
Route::post('/documents/store', [DocumentController::class, 'store'])->name('documents.store');
Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');
Route::get('/documents/search', [DocumentController::class, 'search'])->name('documents.search');
Route::get('documents/download/{id}', [DocumentController::class, 'download'])->name('documents.download');
Route::get('/documents/{document}/share-users', [DocumentController::class, 'shareUsers'])->name('documents.share-users');
// Route::get('/documents/{document}/share', [DocumentController::class, 'share'])->name('documents.share.users');

Route::post('/documents/{document}/share', [DocumentController::class, 'share'])->name('documents.share');







require __DIR__.'/auth.php';
